@props([
    'id',
    'name',
    'value' => '',
    'required' => false,
    'minHeight' => '320px',
])

<div class="rich-editor rounded-lg border border-input bg-background shadow-sm" data-rich-editor>
    <div class="flex flex-wrap items-center gap-1 border-b border-border bg-muted/40 p-2">
        <select data-rich-format class="h-9 rounded-md border border-input bg-background px-2 text-xs font-semibold text-foreground focus:outline-none focus:ring-2 focus:ring-ring">
            <option value="P">Paragraph</option>
            <option value="H2">Heading 2</option>
            <option value="H3">Heading 3</option>
            <option value="H4">Heading 4</option>
        </select>

        <span class="mx-1 h-6 w-px bg-border"></span>

        <button type="button" data-rich-command="bold" class="rich-editor-btn" title="Bold">B</button>
        <button type="button" data-rich-command="italic" class="rich-editor-btn italic" title="Italic">I</button>
        <button type="button" data-rich-command="underline" class="rich-editor-btn underline" title="Underline">U</button>

        <span class="mx-1 h-6 w-px bg-border"></span>

        <button type="button" data-rich-command="insertUnorderedList" class="rich-editor-btn" title="Bulleted list">List</button>
        <button type="button" data-rich-command="insertOrderedList" class="rich-editor-btn" title="Numbered list">1. List</button>
        <button type="button" data-rich-command="formatBlock" data-rich-value="BLOCKQUOTE" class="rich-editor-btn" title="Quote">Quote</button>

        <span class="mx-1 h-6 w-px bg-border"></span>

        <button type="button" data-rich-link class="rich-editor-btn" title="Add link">Link</button>
        <button type="button" data-rich-command="removeFormat" class="rich-editor-btn" title="Clear formatting">Clear</button>
        <button type="button" data-rich-source-toggle class="rich-editor-btn ml-auto" title="Edit HTML source">HTML</button>
    </div>

    <div
        id="{{ $id }}_visual"
        class="rich-editor-surface prose prose-slate dark:prose-invert max-w-none overflow-auto bg-background px-4 py-3 text-sm leading-relaxed text-foreground focus:outline-none"
        style="min-height: {{ $minHeight }};"
        contenteditable="true"
        data-rich-surface
    >{!! $value !!}</div>

    <textarea
        id="{{ $id }}_source"
        class="hidden w-full border-0 bg-background p-4 font-mono text-xs text-foreground focus:outline-none focus:ring-0"
        style="min-height: {{ $minHeight }};"
        data-rich-source
    >{{ $value }}</textarea>

    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        class="sr-only"
        data-rich-target
        @if($required) required @endif
    >{{ $value }}</textarea>
</div>
