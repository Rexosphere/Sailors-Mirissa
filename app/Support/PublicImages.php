<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Uploaded site images live under public/images/{dir} and are referenced by
 * their URL path (e.g. /images/rooms/room-101-20260908120000.avif).
 */
class PublicImages
{
    public const DISK = 'public_uploads';

    public static function store(UploadedFile $file, string $dir, string $name): string
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $filename = Str::slug($name).'-'.now()->format('YmdHis').'.'.$extension;

        $file->storeAs("images/{$dir}", $filename, self::DISK);

        return "/images/{$dir}/{$filename}";
    }

    /**
     * Remove a stored image unless other rows still reference it.
     */
    public static function delete(?string $url, int $otherReferences = 0): void
    {
        if (! $url || $otherReferences > 0 || ! str_starts_with($url, '/images/')) {
            return;
        }

        Storage::disk(self::DISK)->delete(ltrim($url, '/'));
    }

    /**
     * Extract the src of an icon stored as an <img> tag.
     */
    public static function srcFromHtml(?string $html): ?string
    {
        if ($html && preg_match('/src="([^"]+)"/', $html, $m)) {
            return $m[1];
        }

        return null;
    }
}
