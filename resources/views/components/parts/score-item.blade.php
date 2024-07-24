@props(['item_name' => null, 'item_value' => null])
<div class="flex gap-4 items-center justify-between">
    <div class="text-xs">{{ $item_name }}</div>
    <div class="pl-2">{{ $item_value }}</div>
</div>
