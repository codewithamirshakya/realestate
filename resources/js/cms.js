/**
 * Inline content editing for admins.
 *
 * Every element rendered by <x-editable> carries a data-cms-key and is made
 * contenteditable while edit mode is on; blurring it saves the new text. Image
 * fields get a "Change image" button that uploads straight from the page.
 */

const bar = document.querySelector('[data-cms-bar]');

if (bar) {
    const status = bar.querySelector('[data-cms-status]');
    const token = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    let statusTimer;

    const flash = (message, tone = 'ok') => {
        if (!status) return;

        status.textContent = message;
        status.dataset.tone = tone;

        clearTimeout(statusTimer);
        statusTimer = setTimeout(() => {
            status.textContent = '';
            delete status.dataset.tone;
        }, 4000);
    };

    const post = async (url, body, headers = {}) => {
        const response = await fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json', ...headers },
            body,
            credentials: 'same-origin',
        });

        const payload = await response.json().catch(() => ({}));

        if (!response.ok) {
            throw new Error(payload.message || 'Could not save. Please try again.');
        }

        return payload;
    };

    /* ---------------------------------------------------------------- text */

    const fields = document.querySelectorAll('[data-cms-key][contenteditable]');

    fields.forEach((field) => {
        field.addEventListener('focus', () => {
            field.dataset.cmsOriginal = field.innerText;
        });

        field.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                field.blur();
            }

            if (event.key === 'Escape') {
                event.preventDefault();
                field.innerText = field.dataset.cmsOriginal ?? field.innerText;
                field.blur();
            }
        });

        field.addEventListener('paste', (event) => {
            event.preventDefault();
            const text = (event.clipboardData || window.clipboardData).getData('text/plain');
            document.execCommand('insertText', false, text);
        });

        field.addEventListener('blur', async () => {
            const original = field.dataset.cmsOriginal;
            const value = field.innerText.trim();

            if (original === undefined || value === original.trim()) {
                return;
            }

            field.classList.add('is-saving');

            try {
                const saved = await post(
                    bar.dataset.cmsInlineUrl,
                    JSON.stringify({ key: field.dataset.cmsKey, value }),
                    { 'Content-Type': 'application/json' },
                );

                field.innerText = saved.value ?? value;
                field.dataset.cmsOriginal = field.innerText;
                field.classList.add('is-saved');
                setTimeout(() => field.classList.remove('is-saved'), 1200);

                flash(`Saved “${field.dataset.cmsLabel || field.dataset.cmsKey}”.`);
            } catch (error) {
                field.innerText = original;
                flash(error.message, 'error');
            } finally {
                field.classList.remove('is-saving');
            }
        });
    });

    /* -------------------------------------------------------------- images */

    const picker = document.createElement('input');
    picker.type = 'file';
    picker.accept = 'image/jpeg,image/png,image/webp';
    picker.hidden = true;
    document.body.appendChild(picker);

    let pendingButton = null;

    document.querySelectorAll('[data-cms-image]').forEach((button) => {
        button.addEventListener('click', () => {
            pendingButton = button;
            picker.value = '';
            picker.click();
        });
    });

    picker.addEventListener('change', async () => {
        const file = picker.files?.[0];

        if (!file || !pendingButton) return;

        const button = pendingButton;
        const key = button.dataset.cmsImage;
        const body = new FormData();

        body.append('key', key);
        body.append('image', file);
        button.disabled = true;
        flash('Uploading…');

        try {
            const saved = await post(bar.dataset.cmsUploadUrl, body);
            const target = button.closest('[data-cms-image-target]') ?? button.parentElement;
            const image = target?.querySelector('img');

            if (image) {
                image.src = `${saved.url}?v=${Date.now()}`;
            } else {
                window.location.reload();
            }

            flash(`Updated “${button.dataset.cmsLabel || key}”.`);
        } catch (error) {
            flash(error.message, 'error');
        } finally {
            button.disabled = false;
            pendingButton = null;
        }
    });
}
