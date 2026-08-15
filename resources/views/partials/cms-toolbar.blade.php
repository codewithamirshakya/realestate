@php($cms = app(\App\Support\Cms::class))

@if ($cms->canEdit())
    <div class="cms-bar"
         data-cms-bar
         data-cms-inline-url="{{ route('admin.content.inline') }}"
         data-cms-upload-url="{{ route('admin.content.upload') }}">

        <span class="cms-bar-title">Content</span>

        <form method="POST" action="{{ route('admin.content.edit-mode') }}">
            @csrf
            <button type="submit" class="cms-bar-button {{ $cms->editing() ? 'is-on' : '' }}">
                {{ $cms->editing() ? 'Editing on' : 'Edit this page' }}
            </button>
        </form>

        <a href="{{ route('admin.content.index') }}" class="cms-bar-link">Manage all content</a>

        <span class="cms-bar-status" data-cms-status role="status" aria-live="polite">
            {{ $cms->editing() ? 'Click any highlighted text to edit it.' : '' }}
        </span>
    </div>
@endif
