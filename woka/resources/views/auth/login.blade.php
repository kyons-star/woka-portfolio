@extends('layouts.app')

@section('title', 'Log in – woka')

@section('content')
<section class="view show" id="v-login">
  <div class="auth"><div class="box">
    <div class="tabs"><a class="on" href="{{ route('login') }}">Log in</a><a href="{{ route('register') }}">Create account</a></div>
    <h2 class="t">LOG IN</h2>
    <p class="sub">Welcome back, sign in to manage your portfolio.</p>
    <form method="POST" action="{{ route('login.store') }}">
      @csrf
      <label for="ln">Full name</label>
      <input type="text" id="ln" name="name" value="{{ old('name') }}" placeholder="your name" autocomplete="name" required>
      <label for="lp">Password</label>
      <input type="password" id="lp" name="password" placeholder="enter your password" autocomplete="current-password" required>
      <div class="remember"><input type="checkbox" id="rem" name="remember" value="1"><label for="rem" style="margin:0;text-transform:none;font-weight:400;font-size:13px">remember me</label></div>
      <button type="submit" class="btn full primary">Log in</button>
      <div class="msg" role="status">{{ $errors->first() }}</div>
    </form>
    <p class="alt">New to woka? <a href="{{ route('register') }}">Create account</a></p>
  </div></div>
</section>
@endsection