<li class="{{ is_array($item->classes) ? implode(' ', $item->classes) : $item->classes }} {{ $item->current ? 'active' : '' }}">
  <a href="{{ $item->url }}"
     @if (!empty($item->target)) target="{{ $item->target }}" @endif
     @if (!empty($item->attr_title)) title="{{ $item->attr_title }}" @endif
  >
    {{ $item->title }}
  </a>

  @if (!empty($item->children))
    <ul class="sub-menu box-shadow-lg">
      @foreach ($item->children as $child)
        @include('partials.navigation.item', ['item' => $child])
      @endforeach
    </ul>
  @endif
</li>