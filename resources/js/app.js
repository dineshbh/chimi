

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

function syncRichEditor(editor) {
    const surface = editor.querySelector('[data-rich-surface]');
    const source = editor.querySelector('[data-rich-source]');
    const target = editor.querySelector('[data-rich-target]');

    if (!surface || !source || !target) {
        return;
    }

    if (editor.dataset.sourceMode === 'true') {
        target.value = source.value;
        surface.innerHTML = source.value;
    } else {
        target.value = surface.innerHTML.trim();
        source.value = target.value;
    }
}

function initRichEditor(editor) {
    if (editor.dataset.initialized === 'true') {
        return;
    }

    editor.dataset.initialized = 'true';

    const surface = editor.querySelector('[data-rich-surface]');
    const source = editor.querySelector('[data-rich-source]');
    const target = editor.querySelector('[data-rich-target]');
    const format = editor.querySelector('[data-rich-format]');
    const sourceToggle = editor.querySelector('[data-rich-source-toggle]');

    if (!surface || !source || !target) {
        return;
    }

    const runCommand = (command, value = null) => {
        surface.focus();
        document.execCommand(command, false, value);
        syncRichEditor(editor);
    };

    editor.querySelectorAll('[data-rich-command]').forEach((button) => {
        button.addEventListener('click', () => {
            runCommand(button.dataset.richCommand, button.dataset.richValue || null);
        });
    });

    if (format) {
        format.addEventListener('change', () => {
            runCommand('formatBlock', format.value);
            format.value = 'P';
        });
    }

    editor.querySelectorAll('[data-rich-link]').forEach((button) => {
        button.addEventListener('click', () => {
            const url = window.prompt('Enter URL');
            if (url) {
                runCommand('createLink', url);
            }
        });
    });

    if (sourceToggle) {
        sourceToggle.addEventListener('click', () => {
            const sourceMode = editor.dataset.sourceMode === 'true';

            if (sourceMode) {
                surface.innerHTML = source.value;
                surface.classList.remove('hidden');
                source.classList.add('hidden');
                editor.dataset.sourceMode = 'false';
                sourceToggle.textContent = 'HTML';
            } else {
                source.value = surface.innerHTML.trim();
                source.classList.remove('hidden');
                surface.classList.add('hidden');
                editor.dataset.sourceMode = 'true';
                sourceToggle.textContent = 'Visual';
            }

            syncRichEditor(editor);
        });
    }

    surface.addEventListener('input', () => syncRichEditor(editor));
    source.addEventListener('input', () => syncRichEditor(editor));

    const form = editor.closest('form');
    if (form) {
        form.addEventListener('submit', () => syncRichEditor(editor));
    }

    syncRichEditor(editor);
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-rich-editor]').forEach(initRichEditor);
});
