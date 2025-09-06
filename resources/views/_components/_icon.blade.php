@php
    $random_number= str_pad(str(random_int(0,9)),10,'2',STR_PAD_LEFT);
    $currentClass = $name . $random_number;
@endphp

<style>
    .{{ $currentClass }} > symbol >  path{
        fill: {{ $color ?? '$primary-color'}} !important
    }

    @if(isset($size))
        .{{ $currentClass }} symbol{
            width: {{ $size }};
            height: {{ $size }};
        }
    @endif

</style>

<svg class="{{ $currentClass }}">
    <use xlink:href="{{ asset('icons/sprite-icons.svg') }}#{{ $name }}"></use>
</svg>