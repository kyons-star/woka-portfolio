{{-- One repeating row of a list. Needs: $key, $i (index or __INDEX__), $v (values) --}}
<div class="row"><button type="button" class="rm">Remove</button>
@foreach(\App\Support\PortfolioSchema::LISTS[$key]['fields'] as $field)
  <label>{{ $field[1] }}</label>
  @if($field[2] === 'ta')
    <textarea rows="3" name="{{ $key }}[{{ $i }}][{{ $field[0] }}]">{{ $v[$field[0]] ?? '' }}</textarea>
  @else
    <input type="text" name="{{ $key }}[{{ $i }}][{{ $field[0] }}]" value="{{ $v[$field[0]] ?? '' }}">
  @endif
@endforeach
</div>