<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    public function store(UploadedFile $file, string $directory = 'products'): string
    {
        return $file->store($directory, 'public');
    }

    /**
     * @param  array<int, UploadedFile>  $files
     * @return array<int, string>
     */
    public function storeMany(array $files, string $directory = 'products'): array
    {
        $paths = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $this->store($file, $directory);
            }
        }

        return $paths;
    }

    public function delete(?string $path): void
    {
        if (! $path) {
            return;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        // Bundled public assets — do not delete from disk.
        if (str_starts_with($path, 'images/')) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * @param  array<int, string|null>  $paths
     */
    public function deleteMany(array $paths): void
    {
        foreach ($paths as $path) {
            $this->delete($path);
        }
    }

    public function url(?string $path, ?string $fallback = null): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return $fallback ? asset($fallback) : null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Built through asset() so URLs follow the current request host/port
        // instead of a possibly stale APP_URL.
        if (Storage::disk('public')->exists($path)) {
            return asset('storage/'.ltrim($path, '/'));
        }

        return asset(ltrim($path, '/'));
    }

    public function replace(?string $currentPath, ?UploadedFile $file, string $directory): ?string
    {
        if (! $file) {
            return $currentPath;
        }

        $this->delete($currentPath);

        return $this->store($file, $directory);
    }
}
