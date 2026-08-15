<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Cms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function __construct(protected Cms $cms) {}

    /**
     * The full content manager — every editable key, grouped by page.
     */
    public function index(Request $request): View
    {
        $groups = $this->cms->groups();
        $group = (string) $request->query('group', '');

        if (! array_key_exists($group, $groups)) {
            $group = array_key_first($groups);
        }

        return view('admin.content.index', [
            'groups' => $groups,
            'current' => $group,
            'definition' => $groups[$group],
            'cms' => $this->cms,
        ]);
    }

    /**
     * Save every field of one group at once.
     */
    public function update(Request $request): RedirectResponse
    {
        $values = $request->input('values', []);
        $files = $request->file('files', []);
        $resets = array_keys($request->input('reset', []));
        $saved = 0;

        foreach ($resets as $key) {
            if ($this->cms->has($key)) {
                $this->cms->forget($key);
                $saved++;
            }
        }

        foreach ($values as $key => $value) {
            if (in_array($key, $resets, true) || ! $this->cms->has($key)) {
                continue;
            }

            $field = $this->cms->field($key);

            if ($field['type'] === 'image') {
                continue;
            }

            $value = $this->clean($key, $value);

            if ($value === $this->cms->override($key)) {
                continue;
            }

            $this->cms->set($key, $value, $request->user());
            $saved++;
        }

        foreach ($files as $key => $file) {
            if (in_array($key, $resets, true) || ! $this->cms->has($key) || $file === null) {
                continue;
            }

            $this->storeImage($key, $file, $request);
            $saved++;
        }

        return back()->with('status', $saved === 0
            ? 'Nothing to save — the content was unchanged.'
            : 'Content updated. '.$saved.' '.str('field')->plural($saved).' saved.');
    }

    /**
     * Save a single field edited in place on the public site.
     */
    public function inline(Request $request): JsonResponse
    {
        $key = (string) $request->input('key');

        if (! $this->cms->has($key)) {
            return response()->json(['message' => 'Unknown content key.'], 422);
        }

        if (($this->cms->field($key)['type'] ?? null) === 'image') {
            return response()->json(['message' => 'Use the image uploader for this field.'], 422);
        }

        try {
            $value = $this->clean($key, $request->input('value'));
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->validator->errors()->first()], 422);
        }

        $this->cms->set($key, $value, $request->user());

        return response()->json([
            'key' => $key,
            'value' => $this->cms->value($key),
        ]);
    }

    /**
     * Upload (or replace) the image behind an image field.
     */
    public function upload(Request $request): JsonResponse
    {
        $key = (string) $request->input('key');

        if (! $this->cms->has($key) || ($this->cms->field($key)['type'] ?? null) !== 'image') {
            return response()->json(['message' => 'Unknown image key.'], 422);
        }

        try {
            $this->storeImage($key, $request->file('image'), $request);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->validator->errors()->first()], 422);
        }

        return response()->json([
            'key' => $key,
            'url' => $this->cms->imageUrl($key),
        ]);
    }

    /**
     * Put a single key back to the default shipped with the site.
     */
    public function destroy(Request $request, string $key): RedirectResponse
    {
        abort_unless($this->cms->has($key), 404);

        $this->cms->forget($key);

        return back()->with('status', 'Reset to the default text.');
    }

    /**
     * Turn click-to-edit on the public pages on or off for this admin.
     */
    public function toggleEditMode(Request $request): RedirectResponse
    {
        $enabled = ! $request->session()->get(Cms::SESSION_KEY, false);

        $request->session()->put(Cms::SESSION_KEY, $enabled);

        return back()->with('status', $enabled
            ? 'Inline editing is on — click any highlighted text to change it.'
            : 'Inline editing is off.');
    }

    /**
     * Validate a single text value against its declared type.
     */
    protected function clean(string $key, mixed $value): ?string
    {
        $field = $this->cms->field($key);
        $value = is_string($value) ? trim(str_replace(["\r\n", "\r"], "\n", $value)) : null;

        $rules = match ($field['type']) {
            'textarea' => ['nullable', 'string', 'max:5000'],
            'url' => ['nullable', 'string', 'max:255'],
            default => ['nullable', 'string', 'max:255'],
        };

        validator(['value' => $value], ['value' => $rules], [], ['value' => $field['label']])->validate();

        return $value === '' ? null : $value;
    }

    protected function storeImage(string $key, mixed $file, Request $request): void
    {
        validator(
            ['image' => $file],
            ['image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096']],
            [],
            ['image' => $this->cms->field($key)['label'] ?? 'image'],
        )->validate();

        $previous = $this->cms->override($key);

        $path = $file->store(config('cms.image_path', 'cms'), 'public');

        $this->cms->set($key, $path, $request->user());
        $this->cms->deleteImage($previous);
    }
}
