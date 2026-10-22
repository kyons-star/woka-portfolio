<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'woka – portfolio builder')</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@85..100,500..800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="sheet">
  <header>
    <a class="logo" href="{{ route('home') }}">woka</a>
    <nav>
      <a class="link" href="{{ route('home') }}#services">Templates</a>
      @auth
        <span class="who">Hi, {{ auth()->user()->name }}</span>
        <a class="btn" href="{{ route('dashboard') }}">Dashboard</a>
        <button type="button" class="btn" id="navbtn">Log out</button>
      @else
        <a class="btn" href="{{ route('login') }}">Log in</a>
        <a class="btn primary" href="{{ route('register') }}">Create account</a>
      @endauth
    </nav>
  </header>

  @yield('content')

  @auth
  <div class="modal" id="outModal" role="dialog" aria-modal="true" aria-labelledby="outT">
    <div class="mbox">
      <h3 id="outT">Log out?</h3>
      <p>Are you sure you want to log out of woka?</p>
      <form method="POST" action="{{ route('logout') }}" class="macts">
        @csrf
        <button type="button" class="btn" id="outNo">Cancel</button>
        <button type="submit" class="btn primary" id="outYes">Yes, log out</button>
      </form>
    </div>
  </div>
  @endauth

  <footer>© woka · portfolio builder</footer>
</div>
</body>
</html>