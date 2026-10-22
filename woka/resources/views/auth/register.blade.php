@extends('layouts.app')

@section('title', 'Create account – woka')

@section('content')
<section class="view show" id="v-create">
  <div class="auth"><div class="create">
    <div>
      <h2 class="t" style="text-align:left">CREATE ACCOUNT</h2>
      <p class="sub" style="text-align:left">Start building your portfolio in minutes.</p>
      <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <label for="cn">Full name</label>
        <input type="text" id="cn" name="name" value="{{ old('name') }}" placeholder="your name" autocomplete="name" required>
        <label for="cp">Password</label>
        <input type="password" id="cp" name="password" placeholder="at least 8 characters" autocomplete="new-password" required>
        <label for="cc">Confirm password</label>
        <input type="password" id="cc" name="password_confirmation" placeholder="re-enter your password" autocomplete="new-password" required>
        <button type="submit" class="btn full primary">Create account</button>
        <div class="msg" role="status">{{ $errors->first() }}</div>
      </form>
      <p class="alt">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
    </div>
  </div></div>
</section>
@endsection