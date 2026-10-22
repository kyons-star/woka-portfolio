{{-- Renders one portfolio. Needs: $d (array of details + "pic" URL) and $style (Simple|Modern|Creative) --}}
@php
    $d = $d ?? [];
    $style = $style ?? 'Simple';

    $link = function ($u) {
        $u = trim((string) $u);
        if ($u === '') {
            return '';
        }
        return preg_match('/^https?:\/\//i', $u) ? $u : 'https://' . $u;
    };

    $skills = array_values(array_filter(array_map('trim', explode(',', $d['skills'] ?? ''))));
    $soc    = $d['soc'] ?? [];
    $proj   = $d['proj'] ?? [];
    $work   = $d['work'] ?? [];
    $edu    = $d['edu'] ?? [];
@endphp
<div class="pf p-{{ strtolower($style) }}"><div class="pfh">@if(!empty($d['pic']))<img class="av" src="{{ $d['pic'] }}" alt="{{ $d['name'] ?? '' }}">@endif<div><h1>{{ !empty($d['name']) ? $d['name'] : 'Your name' }}</h1><div class="ct">@if(!empty($d['email']))<a href="mailto:{{ $d['email'] }}">{{ $d['email'] }}</a>@endif @if(!empty($d['phone']))<span>{{ $d['phone'] }}</span>@endif @if(!empty($d['address']))<span>{{ $d['address'] }}</span>@endif</div>@if(count($soc))<div class="soc">@foreach($soc as $x)<a href="{{ $link($x['url'] ?? '') }}" target="_blank" rel="noopener">{{ ($x['label'] ?? '') !== '' ? $x['label'] : ($x['url'] ?? '') }}</a>@endforeach</div>@endif</div></div><div class="bd">
@if(!empty($d['about']))<section><h2>About me</h2><p>{!! nl2br(e($d['about'])) !!}</p></section>@endif
@if(count($skills))<section><h2>Skills</h2><ul class="chips">@foreach($skills as $z)<li>{{ $z }}</li>@endforeach</ul></section>@endif
@if(count($proj))<section><h2>Projects</h2><div class="grid">@foreach($proj as $x)<div class="it"><b>{{ $x['title'] ?? '' }}</b><p>{{ $x['desc'] ?? '' }}</p>@if(!empty($x['link']))<a href="{{ $link($x['link']) }}" target="_blank" rel="noopener">View project</a>@endif</div>@endforeach</div></section>@endif
@if(count($work))<section><h2>Work experience</h2><div class="grid">@foreach($work as $x)<div class="it"><b>{{ $x['role'] ?? '' }}</b><span>{{ $x['company'] ?? '' }}</span><small>{{ $x['years'] ?? '' }}</small><p>{{ $x['desc'] ?? '' }}</p></div>@endforeach</div></section>@endif
@if(count($edu))<section><h2>Education</h2><div class="grid">@foreach($edu as $x)<div class="it"><b>{{ $x['degree'] ?? '' }}</b><span>{{ $x['school'] ?? '' }}</span><small>{{ $x['years'] ?? '' }}</small></div>@endforeach</div></section>@endif
</div></div>