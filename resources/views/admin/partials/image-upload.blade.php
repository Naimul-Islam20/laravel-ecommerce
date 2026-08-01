@php
    $fieldId = $name ?? 'image';
    $fieldLabel = $label ?? 'Image';
    $currentUrl = $url ?? null;
    $isRequired = $required ?? false;
    $help = $help ?? null;
@endphp
<div data-single-image-upload>
    <label for="{{ $fieldId }}" class="mb-1 block text-sm font-medium">
        {{ $fieldLabel }}@if ($isRequired) *@endif
    </label>
    <input id="{{ $fieldId }}" name="{{ $fieldId }}" type="file" accept="image/*"
           @if ($isRequired && ! $currentUrl) required @endif
           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
           data-image-input>
    @if ($help)
        <p class="mt-1 text-xs text-brand-ink/50">{{ $help }}</p>
    @endif
    <div class="mt-3 flex items-center gap-3">
        <img src="{{ $currentUrl ?: '' }}" alt=""
             class="h-14 w-14 rounded border border-brand-ink/10 object-cover bg-white {{ $currentUrl ? '' : 'hidden' }}"
             data-image-preview>
        <div class="flex h-14 w-14 items-center justify-center rounded border border-dashed border-brand-ink/20 text-[10px] text-brand-ink/40 {{ $currentUrl ? 'hidden' : '' }}"
             data-image-placeholder>
            No image
        </div>
        @if ($currentUrl)
            <p class="text-xs text-brand-ink/50">Leave empty to keep current image</p>
        @endif
    </div>
    @error($fieldId)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>
