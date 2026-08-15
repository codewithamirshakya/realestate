<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Property;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ManagesPropertyImages
{
    /**
     * @param  array<int, UploadedFile>  $files
     */
    protected function storeImages(Property $property, array $files): void
    {
        $hasPrimary = $property->images()->where('is_primary', true)->exists();

        foreach ($files as $index => $file) {
            $path = $file->store('properties', 'public');

            $property->images()->create([
                'path' => $path,
                'is_primary' => ! $hasPrimary && $index === 0,
                'sort_order' => $property->images()->count(),
            ]);
        }
    }

    protected function deleteImage(Property $property, int $imageId): void
    {
        $image = $property->images()->findOrFail($imageId);

        Storage::disk('public')->delete($image->path);
        $image->delete();

        if (! $property->images()->where('is_primary', true)->exists()) {
            $next = $property->images()->first();
            $next?->update(['is_primary' => true]);
        }
    }
}
