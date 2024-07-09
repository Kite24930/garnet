@props(['link' => null])
<div class="flex flex-col items-center btn-item" data-link="{{ $link }}">
    <div class="py-1 px-4 flex justify-center items-center eng-title">
        {{ $slot }}
    </div>
    <div class="garnet-line"></div>
</div>
