<?php

namespace App\Support;

use App\Models\SiteContent;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * Reads and writes the editable site copy.
 *
 * The schema (which keys exist, their labels, types and defaults) lives in
 * config/cms.php. The `site_contents` table only holds the values an admin has
 * actually changed, so a key with no row simply falls back to its default.
 */
class Cms
{
    public const CACHE_KEY = 'cms.overrides';

    public const SESSION_KEY = 'cms.edit_mode';

    /** @var array<string, string|null>|null */
    protected ?array $overrides = null;

    /** @var array<string, array<string, mixed>>|null */
    protected ?array $fields = null;

    /** @var array<string, mixed>|null */
    protected ?array $companyDefaults = null;

    /**
     * All content groups as declared in config/cms.php.
     *
     * @return array<string, array<string, mixed>>
     */
    public function groups(): array
    {
        return config('cms.groups', []);
    }

    /**
     * Every editable key, flattened, keyed by content key.
     *
     * @return array<string, array<string, mixed>>
     */
    public function fields(): array
    {
        if ($this->fields === null) {
            $this->fields = [];

            foreach ($this->groups() as $group => $definition) {
                foreach ($definition['fields'] ?? [] as $key => $field) {
                    $this->fields[$key] = $field + ['group' => $group, 'type' => 'text'];
                }
            }
        }

        return $this->fields;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function field(string $key): ?array
    {
        return $this->fields()[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return $this->field($key) !== null;
    }

    /**
     * The resolved value: admin override first, then the default from config.
     */
    public function value(string $key, ?string $fallback = null): ?string
    {
        $override = $this->override($key);

        if ($override !== null && $override !== '') {
            return $override;
        }

        return $this->default($key) ?? $fallback;
    }

    /**
     * The default for a key, ignoring any admin override.
     */
    public function default(string $key): ?string
    {
        $field = $this->field($key);

        if ($field === null) {
            return null;
        }

        if (isset($field['config'])) {
            $configured = config($field['config']);

            if (filled($configured)) {
                return (string) $configured;
            }
        }

        if (isset($field['default_asset'])) {
            return asset($field['default_asset']);
        }

        return $field['default'] ?? null;
    }

    /**
     * The stored value for a key, or null when it has never been edited.
     */
    public function override(string $key): ?string
    {
        return $this->overrides()[$key] ?? null;
    }

    public function isOverridden(string $key): bool
    {
        return array_key_exists($key, $this->overrides());
    }

    /**
     * A URL for an image field — the uploaded file, or the packaged default.
     */
    public function imageUrl(string $key): ?string
    {
        $override = $this->override($key);

        if (filled($override)) {
            return Storage::disk('public')->url($override);
        }

        return $this->default($key);
    }

    /**
     * @return array<string, string|null>
     */
    public function overrides(): array
    {
        if ($this->overrides !== null) {
            return $this->overrides;
        }

        try {
            $this->overrides = Cache::rememberForever(
                self::CACHE_KEY,
                fn () => SiteContent::query()->pluck('value', 'key')->all(),
            );
        } catch (Throwable) {
            // Table or cache store not available yet (fresh install, migrations
            // still running) — fall back to the defaults in config/cms.php.
            $this->overrides = [];
        }

        return $this->overrides;
    }

    public function set(string $key, ?string $value, ?User $user = null): SiteContent
    {
        $content = SiteContent::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'updated_by' => $user?->id],
        );

        $this->flush();

        return $content;
    }

    /**
     * Let edited company details win over the defaults in config/company.php,
     * so every existing `config('company.*')` call picks them up.
     */
    public function applyToConfig(): void
    {
        $this->companyDefaults ??= config('company', []);

        $company = $this->companyDefaults;

        foreach ($this->overrides() as $key => $value) {
            if (str_starts_with($key, 'company.') && filled($value)) {
                $company[substr($key, strlen('company.'))] = $value;
            }
        }

        config(['company' => $company]);
    }

    /**
     * Drop an override so the key falls back to its default again.
     */
    public function forget(string $key): void
    {
        $content = SiteContent::query()->where('key', $key)->first();

        if ($content === null) {
            return;
        }

        if (($this->field($key)['type'] ?? null) === 'image') {
            $this->deleteImage($content->value);
        }

        $content->delete();

        $this->flush();
    }

    public function deleteImage(?string $path): void
    {
        if (filled($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function flush(): void
    {
        $this->overrides = null;

        Cache::forget(self::CACHE_KEY);

        $this->applyToConfig();
    }

    /**
     * Is the current request being made by an admin with inline editing on?
     */
    public function editing(): bool
    {
        return $this->canEdit() && (bool) session(self::SESSION_KEY, false);
    }

    public function canEdit(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }
}
