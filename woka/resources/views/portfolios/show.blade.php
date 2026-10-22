@extends('layouts.app')

@section('title', ($d['name'] ?? 'Portfolio') . ' – woka')

@section('content')
<section class="view show" id="v-view">
  <div class="dash">
    <div class="bar" style="margin:0 0 24px">
      <a class="btn" href="{{ route('dashboard') }}">Dashboard</a>
      <a class="btn primary" href="{{ route('portfolios.edit', $portfolio) }}">Edit information</a>
      <button type="button" class="btn" onclick="window.print()">Save as PDF</button>
    </div>

    <form class="switch" id="switch" method="POST" action="{{ route('portfolios.style', $portfolio) }}" role="group" aria-label="Template style">
      @csrf
      @method('PATCH')
      <span class="lbl">Template</span>
      @foreach($styles as $s)
        <button type="submit" name="style" value="{{ $s }}" class="{{ $portfolio->style === $s ? 'on' : '' }}" aria-pressed="{{ $portfolio->style === $s ? 'true' : 'false' }}">{{ $s }}</button>
      @endforeach
    </form>

    <div id="pfwrap">
      @include('partials.portfolio', ['d' => $d, 'style' => $portfolio->style])
    </div>
  </div>
</section>
@endsection