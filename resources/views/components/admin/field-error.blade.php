@props(['name'])

@error($name)
    <p id="{{ $name }}-error" class="mt-1 text-sm text-red-700 dark:text-red-300">
        {{ $message }}
    </p>
@enderror
