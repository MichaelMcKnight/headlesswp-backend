@props([
  'block'               =>  null,
  'additional_classes'  =>  null,
])

<section
    @if (isset($block->block->id)) data-id="{{ $block->block->id }}" @endif
    @if (isset($block->block->anchor)) id="{{ $block->block->anchor }}" @endif
    class="{{ $block->classes ?? '' }} {{ $additional_classes ?? '' }}"
>
    {{ $slot }}
</section>
