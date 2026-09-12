@props([
    'placeholder' => 'Tulis konten di sini...',
])

<div
    wire:ignore
    x-data="{
        value: @entangle($attributes->wire('model')),
        editor: null,

        init() {
            this.editor = this.$refs.editor;

            // Set initial value
            if (this.value) {
                this.editor.innerHTML = this.value;
            }

            this.editor.addEventListener('input', () => {
                this.sync();
            });

            this.editor.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    setTimeout(() => {
                        this.normalizeBlocks();
                        this.sync();
                    }, 0);
                }
            });

            this.editor.addEventListener('paste', (e) => {
                this.cleanPaste(e);
            });

            this.$watch('value', (newVal) => {
                if (newVal !== this.editor.innerHTML) {
                    this.editor.innerHTML = newVal || '';
                }
            });
        },

        sync() {
            this.value = this.editor.innerHTML;
        },

        command(cmd, val = null) {
            this.editor.focus();
            document.execCommand(cmd, false, val);
            this.normalizeBlocks();
            this.sync();
        },

        formatBlock(tag) {
            this.editor.focus();
            document.execCommand('formatBlock', false, tag);
            this.normalizeBlocks();
            this.sync();
        },

        makeParagraph() {
            this.editor.focus();
            document.execCommand('formatBlock', false, 'p');
            this.normalizeBlocks();
            this.sync();
        },

        createLink() {
            const url = window.prompt('Masukkan URL:', 'https://');
            if (!url) return;
            this.editor.focus();
            document.execCommand('createLink', false, url);
            this.sync();
        },

        cleanPaste(event) {
            event.preventDefault();
            const clipboard = event.clipboardData || window.clipboardData;
            if (!clipboard) return;

            const text = clipboard.getData('text/plain');
            if (!text) return;

            const lines = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n').split('\n');
            const fragment = document.createDocumentFragment();

            lines.forEach((line) => {
                const paragraph = document.createElement('p');
                if (line.trim() === '') {
                    paragraph.appendChild(document.createElement('br'));
                } else {
                    paragraph.textContent = line;
                }
                fragment.appendChild(paragraph);
            });

            const selection = window.getSelection();
            if (!selection || selection.rangeCount === 0) return;

            const range = selection.getRangeAt(0);
            range.deleteContents();
            range.insertNode(fragment);

            this.normalizeBlocks();
            this.sync();
        },

        normalizeBlocks() {
            const allowed = ['P', 'H2', 'H3', 'UL', 'OL', 'BLOCKQUOTE'];
            const children = Array.from(this.editor.children);

            children.forEach((element) => {
                // Bersihkan nested <p><p>...</p></p>
                const nestedPs = Array.from(element.querySelectorAll('p'));
                if (nestedPs.length > 0 && element.tagName === 'P') {
                    nestedPs.forEach((nested) => {
                        while (nested.firstChild) {
                            nested.parentNode.insertBefore(nested.firstChild, nested);
                        }
                        nested.remove();
                    });
                }

                if (allowed.includes(element.tagName)) {
                    return;
                }

                if (element.tagName === 'DIV') {
                    const paragraph = document.createElement('p');
                    while (element.firstChild) {
                        paragraph.appendChild(element.firstChild);
                    }
                    element.replaceWith(paragraph);
                }
            });
        }
    }"
    class="overflow-hidden rounded-xl border border-neutral-200 bg-white"
>
    {{-- TOOLBAR --}}
    <div class="flex flex-wrap items-center gap-1 border-b border-neutral-200 bg-neutral-50 p-2">
        {{-- Formatting --}}
        <button
            type="button"
            @click="command('bold')"
            class="rounded-lg px-3 py-1.5 text-sm font-bold text-neutral-700 transition hover:bg-neutral-200"
            title="Bold"
        >
            B
        </button>

        <button
            type="button"
            @click="command('italic')"
            class="rounded-lg px-3 py-1.5 text-sm italic text-neutral-700 transition hover:bg-neutral-200"
            title="Italic"
        >
            I
        </button>

        <button
            type="button"
            @click="command('underline')"
            class="rounded-lg px-3 py-1.5 text-sm underline text-neutral-700 transition hover:bg-neutral-200"
            title="Underline"
        >
            U
        </button>

        <div class="mx-1 h-5 w-px bg-neutral-200"></div>

        {{-- Headings & Paragraph --}}
        <button
            type="button"
            @click="makeParagraph()"
            class="rounded-lg px-3 py-1.5 text-xs font-bold text-neutral-700 transition hover:bg-neutral-200"
            title="Paragraph"
        >
            P
        </button>

        <button
            type="button"
            @click="formatBlock('h2')"
            class="rounded-lg px-3 py-1.5 text-xs font-bold text-neutral-700 transition hover:bg-neutral-200"
            title="Heading 2"
        >
            H2
        </button>

        <button
            type="button"
            @click="formatBlock('h3')"
            class="rounded-lg px-3 py-1.5 text-xs font-bold text-neutral-700 transition hover:bg-neutral-200"
            title="Heading 3"
        >
            H3
        </button>

        <div class="mx-1 h-5 w-px bg-neutral-200"></div>

        {{-- Lists --}}
        <button
            type="button"
            @click="command('insertUnorderedList')"
            class="rounded-lg px-3 py-1.5 text-sm text-neutral-700 transition hover:bg-neutral-200"
            title="Bullet List"
        >
            • List
        </button>

        <button
            type="button"
            @click="command('insertOrderedList')"
            class="rounded-lg px-3 py-1.5 text-sm text-neutral-700 transition hover:bg-neutral-200"
            title="Numbered List"
        >
            1. List
        </button>

        <div class="mx-1 h-5 w-px bg-neutral-200"></div>

        {{-- Blockquote & Link --}}
        <button
            type="button"
            @click="formatBlock('blockquote')"
            class="rounded-lg px-3 py-1.5 text-sm text-neutral-700 transition hover:bg-neutral-200"
            title="Blockquote"
        >
            “
        </button>

        <button
            type="button"
            @click="createLink()"
            class="rounded-lg px-3 py-1.5 text-sm text-neutral-700 transition hover:bg-neutral-200"
            title="Insert Link"
        >
            🔗
        </button>
    </div>

    {{-- CONTENTEDITABLE AREA --}}
    <div
        x-ref="editor"
        contenteditable="true"
        class="min-h-[360px] px-5 py-4 text-base leading-8 text-neutral-800 outline-none
               [&_p]:my-4
               [&_h2]:my-6
               [&_h2]:text-2xl
               [&_h2]:font-bold
               [&_h3]:my-5
               [&_h3]:text-xl
               [&_h3]:font-semibold
               [&_blockquote]:my-5
               [&_blockquote]:border-l-4
               [&_blockquote]:border-neutral-300
               [&_blockquote]:pl-4
               [&_ul]:my-4
               [&_ul]:list-disc
               [&_ul]:pl-6
               [&_ol]:my-4
               [&_ol]:list-decimal
               [&_ol]:pl-6"
        data-placeholder="{{ $placeholder }}"
    ></div>
</div>
