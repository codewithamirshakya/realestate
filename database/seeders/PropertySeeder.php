<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $agents = User::where('role', User::ROLE_AGENT)->get();

        if ($agents->isEmpty()) {
            $this->command?->warn('No agents found, skipping property seeding.');

            return;
        }

        $sampleImagesPath = database_path('seeders/sample-images');
        $sampleImages = File::exists($sampleImagesPath)
            ? collect(File::files($sampleImagesPath))->map(fn ($file) => $file->getPathname())->all()
            : [];

        Property::factory()
            ->count(24)
            ->make()
            ->each(function (Property $property) use ($agents, $sampleImages) {
                $property->user_id = $agents->random()->id;
                $property->save();

                $imageCount = random_int(1, 3);

                for ($i = 0; $i < $imageCount && count($sampleImages) > 0; $i++) {
                    $source = $sampleImages[array_rand($sampleImages)];
                    $filename = 'properties/'.uniqid('seed_').'.jpg';

                    Storage::disk('public')->put($filename, file_get_contents($source));

                    $property->images()->create([
                        'path' => $filename,
                        'is_primary' => $i === 0,
                        'sort_order' => $i,
                    ]);
                }
            });
    }
}
