<?php

namespace App\Http\Controllers;

use App\Support\PortfolioSchema;
use App\Support\SamplePortfolio;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $portfolios = $request->user()->portfolios()->orderBy('id')->get();

        return view('dashboard', [
            'portfolios' => $portfolios,
            'byStyle'    => $portfolios->countBy('style'),
            'styles'     => PortfolioSchema::PICK_TEXT,
            'sample'     => SamplePortfolio::data(),
        ]);
    }
}
