@props(['link' => null])
<div class="flex flex-col items-center gap-2">
    <div class="py-2 flex justify-center items-center eng-title" data-link="{{ $link }}">
        {{ $slot }}
    </div>
</div>
