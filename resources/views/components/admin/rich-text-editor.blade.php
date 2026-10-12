@props([
    'placeholder' => 'Tulis konten di sini...',
])

<div
    wire:ignore
    x-data="{
        value: @entangle($attributes->wire('model')),
        editor: null,
        activeFormats: {},
        activeBlock: 'p',
        activeLineHeight: 'normal',
        savedRange: null,

        init() {
            this.editor = this.$refs.editor;

            // Set initial value
            if (this.value) {
                this.editor.innerHTML = this.value;
            }

            this.normalizeBlocks();
            this.sync();

            this.editor.addEventListener('input', () => {
                this.refreshToolbar();
                this.sync();
            });

            this.editor.addEventListener('keyup', () => this.refreshToolbar());
            this.editor.addEventListener('mouseup', () => this.refreshToolbar());
            document.addEventListener('selectionchange', () => {
                if (document.activeElement === this.editor || this.editor.contains(document.activeElement)) {
                    this.saveSelection();
                    this.refreshToolbar();
                }
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
                    this.refreshToolbar();
                }
            });

            this.refreshToolbar();
        },

        sync() {
            this.value = this.editor.innerHTML;
        },

        command(cmd, val = null) {
            this.editor.focus();
            document.execCommand(cmd, false, val);
            this.normalizeBlocks();
            this.refreshToolbar();
            this.sync();
        },

        formatBlock(tag) {
            this.editor.focus();
            document.execCommand('formatBlock', false, tag);
            this.normalizeBlocks();
            this.refreshToolbar();
            this.sync();
        },

        makeParagraph() {
            this.editor.focus();
            document.execCommand('formatBlock', false, 'p');
            this.normalizeBlocks();
            this.refreshToolbar();
            this.sync();
        },

        createLink() {
            const url = window.prompt('Masukkan URL:', 'https://');
            if (!url) return;
            this.editor.focus();
            document.execCommand('createLink', false, url);
            this.refreshToolbar();
            this.sync();
        },

        refreshToolbar() {
            if (!this.editor) return;

            this.activeFormats = {
                bold: document.queryCommandState('bold'),
                italic: document.queryCommandState('italic'),
                underline: document.queryCommandState('underline'),
                insertUnorderedList: document.queryCommandState('insertUnorderedList'),
                insertOrderedList: document.queryCommandState('insertOrderedList'),
                createLink: document.queryCommandState('createLink'),
            };

            const selection = window.getSelection();
            let node = selection?.anchorNode;
            if (node?.nodeType === Node.TEXT_NODE) node = node.parentElement;
            const block = node?.closest?.('p,h2,h3,blockquote,li');
            this.activeBlock = block?.tagName?.toLowerCase() || 'p';
            this.activeFormats.createLink = Boolean(node?.closest?.('a')) || this.activeFormats.createLink;
            this.activeLineHeight = block?.style?.lineHeight || 'normal';
        },

        isActive(command) {
            return Boolean(this.activeFormats[command]);
        },

        isBlock(tag) {
            return this.activeBlock === tag;
        },

        saveSelection() {
            const selection = window.getSelection();
            if (!selection || selection.rangeCount === 0) return;

            const range = selection.getRangeAt(0);
            if (this.editor?.contains(range.commonAncestorContainer)) {
                this.savedRange = range.cloneRange();
            }
        },

        restoreSelection() {
            if (!this.savedRange) return;

            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(this.savedRange);
        },

        selectedBlocks() {
            const selection = window.getSelection();
            const range = selection?.rangeCount ? selection.getRangeAt(0) : this.savedRange;
            if (!range) return [];

            const blocks = Array.from(this.editor.querySelectorAll('p,h2,h3,blockquote,li'));
            const selected = blocks.filter((block) => {
                try {
                    return range.intersectsNode(block);
                } catch (error) {
                    return false;
                }
            });

            if (selected.length > 0) return selected;

            let node = range.startContainer;
            if (node?.nodeType === Node.TEXT_NODE) node = node.parentElement;
            const block = node?.closest?.('p,h2,h3,blockquote,li');

            return block && this.editor.contains(block) ? [block] : [];
        },

        setLineHeight(value) {
            this.editor.focus();

            this.restoreSelection();

            const blocks = this.selectedBlocks();
            if (!blocks.length) return;

            blocks.forEach((block) => {
                if (value === 'normal') {
                    block.style.removeProperty('line-height');
                    block.style.removeProperty('margin-block');
                } else {
                    block.style.lineHeight = value;
                    if (block.tagName === 'LI') {
                        block.style.marginBlock = value === '1.5' ? '0.1rem' : '0.4rem';
                    }
                }
            });

            this.activeLineHeight = value;
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

            // Bungkus konten lama yang masih berupa plain text menjadi satu paragraf.
            const hasElementChild = Array.from(this.editor.childNodes)
                .some((node) => node.nodeType === Node.ELEMENT_NODE);

            if (!hasElementChild && this.editor.textContent.trim() !== '') {
                const paragraph = document.createElement('p');
                while (this.editor.firstChild) {
                    paragraph.appendChild(this.editor.firstChild);
                }
                this.editor.appendChild(paragraph);
            }

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
            :class="isActive('bold') ? 'bg-neutral-800 text-white' : 'text-neutral-700 hover:bg-neutral-200'"
            class="rounded-lg px-3 py-1.5 text-sm font-bold transition"
            title="Bold"
        >
            B
        </button>

        <button
            type="button"
            @click="command('italic')"
            :class="isActive('italic') ? 'bg-neutral-800 text-white' : 'text-neutral-700 hover:bg-neutral-200'"
            class="rounded-lg px-3 py-1.5 text-sm italic transition"
            title="Italic"
        >
            I
        </button>

        <button
            type="button"
            @click="command('underline')"
            :class="isActive('underline') ? 'bg-neutral-800 text-white' : 'text-neutral-700 hover:bg-neutral-200'"
            class="rounded-lg px-3 py-1.5 text-sm underline transition"
            title="Underline"
        >
            U
        </button>

        <div class="mx-1 h-5 w-px bg-neutral-200"></div>

        {{-- Headings & Paragraph --}}
        <button
            type="button"
            @click="makeParagraph()"
            :class="isBlock('p') ? 'bg-neutral-800 text-white' : 'text-neutral-700 hover:bg-neutral-200'"
            class="rounded-lg px-3 py-1.5 text-xs font-bold transition"
            title="Paragraph"
        >
            P
        </button>

        <button
            type="button"
            @click="formatBlock('h2')"
            :class="isBlock('h2') ? 'bg-neutral-800 text-white' : 'text-neutral-700 hover:bg-neutral-200'"
            class="rounded-lg px-3 py-1.5 text-xs font-bold transition"
            title="Heading 2"
        >
            H2
        </button>

        <button
            type="button"
            @click="formatBlock('h3')"
            :class="isBlock('h3') ? 'bg-neutral-800 text-white' : 'text-neutral-700 hover:bg-neutral-200'"
            class="rounded-lg px-3 py-1.5 text-xs font-bold transition"
            title="Heading 3"
        >
            H3
        </button>

        <div class="mx-1 h-5 w-px bg-neutral-200"></div>

        {{-- Lists --}}
        <button
            type="button"
            @click="command('insertUnorderedList')"
            :class="isActive('insertUnorderedList') ? 'bg-neutral-800 text-white' : 'text-neutral-700 hover:bg-neutral-200'"
            class="rounded-lg px-3 py-1.5 text-sm transition"
            title="Bullet List"
        >
            • List
        </button>

        <button
            type="button"
            @click="command('insertOrderedList')"
            :class="isActive('insertOrderedList') ? 'bg-neutral-800 text-white' : 'text-neutral-700 hover:bg-neutral-200'"
            class="rounded-lg px-3 py-1.5 text-sm transition"
            title="Numbered List"
        >
            1. List
        </button>

        <div class="mx-1 h-5 w-px bg-neutral-200"></div>

        {{-- Blockquote & Link --}}
        <button
            type="button"
            @click="formatBlock('blockquote')"
            :class="isBlock('blockquote') ? 'bg-neutral-800 text-white' : 'text-neutral-700 hover:bg-neutral-200'"
            class="rounded-lg px-3 py-1.5 text-sm transition"
            title="Blockquote"
        >
            “
        </button>

        <button
            type="button"
            @click="createLink()"
            :class="isActive('createLink') ? 'bg-blue-600 text-white' : 'text-neutral-700 hover:bg-neutral-200'"
            class="rounded-lg px-3 py-1.5 text-sm transition"
            title="Insert Link"
        >
            🔗
        </button>

        <div class="mx-1 h-5 w-px bg-neutral-200"></div>

        <label class="flex items-center gap-1.5 rounded-lg px-2 py-1 text-xs text-neutral-500" title="Spasi baris pada blok aktif">
            <span class="hidden sm:inline">Spasi</span>
            <select
                :value="activeLineHeight"
                @change="setLineHeight($event.target.value)"
                class="rounded-md border border-neutral-200 bg-white px-1.5 py-1 text-xs text-neutral-700 outline-none focus:border-neutral-400 focus:ring-1 focus:ring-neutral-300"
                aria-label="Atur spasi baris"
            >
                <option value="1.5">Rapat</option>
                <option value="normal">Normal</option>
                <option value="2">Longgar</option>
            </select>
        </label>
    </div>

    {{-- CONTENTEDITABLE AREA --}}
    <div
        x-ref="editor"
        contenteditable="true"
        class="min-h-[360px] px-5 py-4 text-base leading-7 text-neutral-800 outline-none
               [&_p]:my-2
               [&_p]:leading-7
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
               [&_ul]:my-2
               [&_ul]:list-disc
               [&_ul]:pl-6
               [&_ol]:my-2
               [&_ol]:list-decimal
               [&_ol]:pl-6"
        data-placeholder="{{ $placeholder }}"
    ></div>
</div>
