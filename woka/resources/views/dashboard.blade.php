@extends('layouts.app')

@section('title', 'Dashboard – woka')

@section('content')
<section class="view show" id="v-dashboard">
  <div class="dash">
    <h2>DASHBOARD</h2>
    <p>Welcome, {{ auth()->user()->name }}.</p>

    @if(session('status'))<div class="msg ok">{{ session('status') }}</div>@endif

    <div class="sec">
      <h2 style="font-size:20px">Your templates</h2>
      <p>
        <span class="badge">{{ $portfolios->count() }}</span>
        {{ $portfolios->count() === 1 ? 'template' : 'templates' }} created
        @if($portfolios->count())
          &middot; {{ $byStyle->map(fn ($n, $style) => "$n $style")->implode(', ') }}
        @endif
      </p>
      <div class="mine" id="mine">
        @forelse($portfolios as $p)
          @php
            $d = $p->viewData();
            $facts = array_filter(['Name' => $d['name'] ?? '', 'Email' => $d['email'] ?? '', 'Contact' => $d['phone'] ?? '', 'Address' => $d['address'] ?? '']);
            $skillCount = count(array_filter(array_map('trim', explode(',', $d['skills'] ?? ''))));
          @endphp
          <div class="card">
            <div class="pv">@include('partials.portfolio', ['d' => $d, 'style' => $p->style])</div>
            <b>{{ $p->style }} #{{ $p->number }}</b>
            <span>Created {{ $p->created_at->format('M j, Y') }}</span>
            <div class="facts">
              @forelse($facts as $label => $value)
                <div><b>{{ $label }}:</b> {{ $value }}</div>
              @empty
                <div>No details added yet.</div>
              @endforelse
              <div>{{ count($d['proj'] ?? []) }} projects &middot; {{ $skillCount }} skills &middot; {{ count($d['work'] ?? []) }} jobs &middot; {{ count($d['edu'] ?? []) }} education &middot; {{ count($d['soc'] ?? []) }} links</div>
            </div>
            <div class="acts">
              <a class="btn sm" href="{{ route('portfolios.edit', $p) }}">Edit</a>
              <a class="btn sm" href="{{ route('portfolios.show', $p) }}">View</a>
              <form method="POST" action="{{ route('portfolios.destroy', $p) }}" data-confirm="Delete this template?">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn sm">Delete</button>
              </form>
            </div>
          </div>
        @empty
          <div class="empty"><div class="zero">0</div><p>No templates yet. Choose one below to get started.</p></div>
        @endforelse
      </div>
    </div>

    <div class="sec pick">
      <h2 style="font-size:20px">Choose a template</h2>
      <p>Pick a style to create a new template.</p>
      <div class="cards">
        @foreach($styles as $name => $text)
          <form method="POST" action="{{ route('portfolios.store') }}">
            @csrf
            <input type="hidden" name="style" value="{{ $name }}">
            <button type="submit" class="card">
              @include('partials.preview', ['d' => $sample, 'style' => $name])
              <b>{{ $name }}</b><span>{{ $text }}</span>
            </button>
          </form>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endsection