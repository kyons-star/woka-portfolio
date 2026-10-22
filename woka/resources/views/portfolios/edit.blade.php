@extends('layouts.app')

@section('title', 'Edit portfolio – woka')

@section('content')
<section class="view show" id="v-editor">
  <div class="dash"><div class="ed">
    <h2>{{ strtoupper($portfolio->style) }} PORTFOLIO</h2>
    <p>Fill in your details. Your portfolio is generated in the style you chose.</p>

    <form method="POST" action="{{ route('portfolios.update', $portfolio) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="ow-sec">
        <h3>Personal information</h3>
        <label for="e-name">Full name</label>
        <input type="text" id="e-name" name="name" value="{{ old('name', $d['name'] ?? '') }}" autocomplete="name">
        <div class="pic">
          <div id="epic" @if($d['pic']) style="background-image:url('{{ $d['pic'] }}')" @endif></div>
          <div>
            <label style="margin-top:0" for="efile">Profile picture</label>
            <input type="file" id="efile" name="picture" accept="image/*">
            @if($d['pic'])
              <label style="margin-top:8px;text-transform:none;font-weight:400"><input type="checkbox" name="remove_picture" value="1"> Remove current picture</label>
            @endif
          </div>
        </div>
        <div class="g2">
          <div><label for="e-email">Email</label><input type="email" id="e-email" name="email" value="{{ old('email', $d['email'] ?? '') }}" autocomplete="email"></div>
          <div><label for="e-phone">Contact number</label><input type="tel" id="e-phone" name="phone" value="{{ old('phone', $d['phone'] ?? '') }}" autocomplete="tel"></div>
        </div>
        <label for="e-addr">Address</label>
        <input type="text" id="e-addr" name="address" value="{{ old('address', $d['address'] ?? '') }}" autocomplete="street-address">
      </div>

      <div class="ow-sec">
        <h3>About me</h3>
        <textarea id="e-about" name="about" rows="5" placeholder="Tell visitors who you are and what you do">{{ old('about', $d['about'] ?? '') }}</textarea>
      </div>

      <div class="ow-sec">
        <h3>Skills</h3>
        <input type="text" id="e-skills" name="skills" value="{{ old('skills', $d['skills'] ?? '') }}" placeholder="Separate skills with commas, e.g. Photoshop, HTML, Public speaking">
      </div>

      @foreach($lists as $key => $list)
        @php
          $rows = old($key, $d[$key] ?? []);
          if (! is_array($rows) || ! count($rows)) { $rows = [[]]; }
          $rows = array_values($rows);
        @endphp
        <div class="ow-sec" data-list="{{ $key }}" data-next="{{ count($rows) }}">
          <h3>{{ $list['title'] }}</h3>
          <div class="rows">
            @foreach($rows as $i => $v)
              @include('portfolios._row', ['key' => $key, 'i' => $i, 'v' => $v])
            @endforeach
          </div>
          <template>@include('portfolios._row', ['key' => $key, 'i' => '__INDEX__', 'v' => []])</template>
          <button type="button" class="btn sm" data-add>{{ $list['add'] }}</button>
        </div>
      @endforeach

      <div class="bar">
        <button type="submit" class="btn primary">Save and preview</button>
        <a class="btn" href="{{ route('dashboard') }}">Back to dashboard</a>
      </div>
      <div class="msg" role="status">{{ $errors->first() }}</div>
    </form>
  </div></div>
</section>
@endsection