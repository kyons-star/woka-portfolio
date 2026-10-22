<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioRequest;
use App\Models\Portfolio;
use App\Support\PortfolioSchema;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PortfolioController extends Controller
{
    /** "Choose a template": create a new portfolio in the picked style. */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'style' => ['required', Rule::in(PortfolioSchema::styleNames())],
        ]);

        $user = $request->user();

        $portfolio = $user->portfolios()->create([
            'number' => ((int) $user->portfolios()->max('number')) + 1,
            'style'  => $data['style'],
            'data'   => ['name' => $user->name],
        ]);

        return redirect()->route('portfolios.edit', $portfolio);
    }

    /** Enter / change your details. */
    public function edit(Request $request, Portfolio $portfolio)
    {
        $this->owned($request, $portfolio);

        return view('portfolios.edit', [
            'portfolio' => $portfolio,
            'd'         => $portfolio->viewData(),
            'lists'     => PortfolioSchema::LISTS,
        ]);
    }

    public function update(PortfolioRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $this->owned($request, $portfolio);

        $data = $request->safe()->only(['name', 'email', 'phone', 'address', 'about', 'skills']);
        $data = array_map(fn ($v) => trim((string) $v), $data);

        // Keep only list rows where at least one field was filled in.
        foreach (PortfolioSchema::LISTS as $key => $list) {
            $rows = collect($request->input($key, []))
                ->map(fn ($row) => collect((array) $row)
                    ->only(array_column($list['fields'], 0))
                    ->map(fn ($v) => trim((string) $v))
                    ->all())
                ->filter(fn ($row) => collect($row)->filter()->isNotEmpty())
                ->values()
                ->all();

            $data[$key] = $rows;
        }

        // Profile picture: upload, replace or remove.
        $picture = $portfolio->picture;

        if ($request->hasFile('picture')) {
            if ($picture) {
                Storage::disk('public')->delete($picture);
            }
            $picture = $request->file('picture')->store('avatars', 'public');
        } elseif ($request->boolean('remove_picture') && $picture) {
            Storage::disk('public')->delete($picture);
            $picture = null;
        }

        $portfolio->update([
            'data'    => $data,
            'picture' => $picture,
        ]);

        return redirect()->route('portfolios.show', $portfolio);
    }

    /** Preview page. */
    public function show(Request $request, Portfolio $portfolio)
    {
        $this->owned($request, $portfolio);

        return view('portfolios.show', [
            'portfolio' => $portfolio,
            'd'         => $portfolio->viewData(),
            'styles'    => PortfolioSchema::styleNames(),
        ]);
    }

    /** Switch the preview between Simple / Modern / Creative. */
    public function style(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $this->owned($request, $portfolio);

        $data = $request->validate([
            'style' => ['required', Rule::in(PortfolioSchema::styleNames())],
        ]);

        $portfolio->update(['style' => $data['style']]);

        return redirect()->route('portfolios.show', $portfolio);
    }

    public function destroy(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $this->owned($request, $portfolio);

        if ($portfolio->picture) {
            Storage::disk('public')->delete($portfolio->picture);
        }

        $portfolio->delete();

        return redirect()->route('dashboard')->with('status', 'Template deleted.');
    }

    /** Only the owner may see or change a portfolio. */
    private function owned(Request $request, Portfolio $portfolio): void
    {
        abort_unless($portfolio->user_id === $request->user()->id, 404);
    }
}