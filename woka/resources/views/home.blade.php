@extends('layouts.app')

@section('content')
<section class="view show" id="v-home">
  <div class="hero">
    <h1>WELCOME</h1>
    <p>Showcase your best work in minutes. Pick a style, add your projects, and share your portfolio with the world.</p>
    <a class="btn primary" href="{{ auth()->check() ? route('dashboard') : route('register') }}">Get started</a>
  </div>
  <div class="styles" id="services">
    <div class="eyebrow">Portfolio</div>
    <h2>Choose a style and<br>fill in your details.</h2>
    <div class="slider" id="slider" tabindex="0" role="region" aria-roledescription="carousel" aria-label="Portfolio styles">
      <div class="tabs3" id="tabs3" role="tablist">
        @foreach($styles as $name => $text)
          <button type="button" class="tab {{ $loop->first ? 'on' : '' }}" role="tab" aria-selected="{{ $loop->first ? 'true' : 'false' }}" aria-label="{{ $name }}">
            @include('partials.preview', ['d' => $sample, 'style' => $name])
            <div class="cap"><div class="cn">{{ $name }}</div><div class="cs">{{ $text }}</div></div>
          </button>
        @endforeach
      </div>
      <a class="btn primary" id="useStyle" href="{{ auth()->check() ? route('dashboard') : route('register') }}">Use this style</a>
    </div>
  </div>
</section>
@endsection