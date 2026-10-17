@props([
    'model',
    'ratio' => '1/1',
    'width' => 1080,
    'height' => 1080,
    'label' => 'Gambar',
    'existingUrl' => null,
])

<div
    x-data="adminImageCropper({
        model: @js($model),
        ratio: @js($ratio),
        outputWidth: {{ (int) $width }},
        outputHeight: {{ (int) $height }},
        maxBytes: 2 * 1024 * 1024,
        existingUrl: @js($existingUrl),
    })"
    class="w-full"
>
    <label class="mb-2 block text-sm font-bold text-gray-600">{{ $label }}</label>

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
        <template x-if="previewUrl">
            <img :src="previewUrl" alt="Preview" class="h-24 w-24 shrink-0 rounded-2xl object-cover shadow-sm ring-4 ring-gray-50">
        </template>

        <div class="w-full">
            <input type="file" accept="image/jpeg,image/png,image/webp" @change="open($event)" class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 px-4 py-2.5 text-sm text-gray-600 transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-bold file:text-[var(--color-wfsc-coral)] file:shadow-sm hover:file:bg-rose-50 focus:bg-white focus:border-[var(--color-wfsc-coral)] focus:ring-1 focus:ring-[var(--color-wfsc-coral)]">
            <p class="mt-2 text-xs font-medium text-gray-400">JPG, PNG, atau WebP · {{ $width }} × {{ $height }} px · maksimal 2 MB · rasio {{ $ratio }}.</p>
            @error($model) <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
        </div>
    </div>

    <div x-show="openModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 p-4" @keydown.escape.window="close()">
        <div class="w-full max-w-xl rounded-2xl bg-white p-5 shadow-2xl" @click.stop>
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-black text-gray-900">Sesuaikan {{ strtolower($label) }}</h3>
                    <p class="text-xs text-gray-500">Geser gambar di dalam kotak untuk menyesuaikan posisi, lalu gunakan slider untuk memperbesar atau memperkecil.</p>
                </div>
                <button type="button" @click="close()" class="text-2xl leading-none text-gray-400 hover:text-gray-700">&times;</button>
            </div>

            <div x-ref="viewport" class="relative mx-auto max-h-[60vh] max-w-full overflow-hidden rounded-xl bg-gray-900" :style="`aspect-ratio: ${ratio.replace('/', ' / ')}`" @pointerdown="startDrag($event)" @pointermove="drag($event)" @pointerup="endDrag()" @pointercancel="endDrag()">
                <img x-ref="source" :src="sourceUrl" alt="Crop preview" class="absolute max-w-none select-none" draggable="false" :style="`width:${imageWidth}px;height:${imageHeight}px;left:${offsetX}px;top:${offsetY}px`">
                <div class="pointer-events-none absolute inset-0 border-2 border-white/90 shadow-[0_0_0_9999px_rgba(0,0,0,0.45)]">
                    <div class="absolute inset-y-0 left-1/3 border-l border-white/50"></div>
                    <div class="absolute inset-y-0 left-2/3 border-l border-white/50"></div>
                    <div class="absolute inset-x-0 top-1/3 border-t border-white/50"></div>
                    <div class="absolute inset-x-0 top-2/3 border-t border-white/50"></div>
                </div>
            </div>

            <div class="mt-4 flex items-center gap-3">
                <span class="text-xs text-gray-500">Zoom</span>
                <input type="range" min="1" max="3" step="0.01" x-model.number="zoom" @input="applyZoom()" class="w-full accent-[var(--color-wfsc-coral)]">
            </div>

            <div class="mt-5 flex justify-end gap-2">
                <button type="button" @click="close()" class="rounded-xl px-4 py-2.5 text-sm font-bold text-gray-500 hover:bg-gray-100">Batal</button>
                <button type="button" @click="cropAndUpload()" class="rounded-xl bg-[var(--color-wfsc-coral)] px-5 py-2.5 text-sm font-bold text-white hover:opacity-90">Gunakan Gambar</button>
            </div>
        </div>
    </div>
</div>

@once
    <script>
            function adminImageCropper(config) {
                return {
                    ...config,
                    openModal: false,
                    sourceUrl: null,
                    previewUrl: config.existingUrl,
                    image: null,
                    imageWidth: 0,
                    imageHeight: 0,
                    offsetX: 0,
                    offsetY: 0,
                    zoom: 1,
                    dragging: false,
                    pointerX: 0,
                    pointerY: 0,
                    baseScale: 1,
                    viewportWidth: 0,
                    viewportHeight: 0,
                    open(event) {
                        const file = event.target.files?.[0];
                        if (!file) return;
                        this.image = file;
                        this.sourceUrl = URL.createObjectURL(file);
                        this.openModal = true;
                        this.$nextTick(() => {
                            this.$refs.source.onload = () => this.fitImage();
                        });
                    },
                    fitImage() {
                        const viewport = this.$refs.viewport.getBoundingClientRect();
                        this.viewportWidth = viewport.width;
                        this.viewportHeight = viewport.height;
                        this.baseScale = Math.max(this.viewportWidth / this.$refs.source.naturalWidth, this.viewportHeight / this.$refs.source.naturalHeight);
                        this.zoom = 1;
                        this.applyZoom(true);
                    },
                    applyZoom(resetPosition = false) {
                        const scale = this.baseScale * Number(this.zoom);
                        this.imageWidth = this.$refs.source.naturalWidth * scale;
                        this.imageHeight = this.$refs.source.naturalHeight * scale;
                        if (resetPosition) {
                            this.offsetX = (this.viewportWidth - this.imageWidth) / 2;
                            this.offsetY = (this.viewportHeight - this.imageHeight) / 2;
                        }
                        this.constrainPosition();
                    },
                    constrainPosition() {
                        if (this.imageWidth <= this.viewportWidth) {
                            this.offsetX = (this.viewportWidth - this.imageWidth) / 2;
                        } else {
                            this.offsetX = Math.min(0, Math.max(this.viewportWidth - this.imageWidth, this.offsetX));
                        }

                        if (this.imageHeight <= this.viewportHeight) {
                            this.offsetY = (this.viewportHeight - this.imageHeight) / 2;
                        } else {
                            this.offsetY = Math.min(0, Math.max(this.viewportHeight - this.imageHeight, this.offsetY));
                        }
                    },
                    startDrag(event) {
                        event.preventDefault();
                        this.dragging = true;
                        this.pointerX = event.clientX;
                        this.pointerY = event.clientY;
                        event.currentTarget.setPointerCapture?.(event.pointerId);
                    },
                    drag(event) {
                        if (!this.dragging) return;
                        this.offsetX += event.clientX - this.pointerX;
                        this.offsetY += event.clientY - this.pointerY;
                        this.constrainPosition();
                        this.pointerX = event.clientX;
                        this.pointerY = event.clientY;
                    },
                    endDrag() {
                        this.dragging = false;
                    },
                    async cropAndUpload() {
                        const scale = this.imageWidth / this.$refs.source.naturalWidth;
                        const sx = Math.max(0, -this.offsetX / scale);
                        const sy = Math.max(0, -this.offsetY / scale);
                        const sw = Math.min(this.$refs.source.naturalWidth - sx, this.viewportWidth / scale);
                        const sh = Math.min(this.$refs.source.naturalHeight - sy, this.viewportHeight / scale);
                        const canvas = document.createElement('canvas');
                        canvas.width = this.outputWidth;
                        canvas.height = this.outputHeight;
                        canvas.getContext('2d').drawImage(this.$refs.source, sx, sy, sw, sh, 0, 0, canvas.width, canvas.height);

                        let blob = await this.canvasBlob(canvas, 0.92);

                        if (blob.size > this.maxBytes) {
                            for (const quality of [0.84, 0.76, 0.68, 0.60, 0.52]) {
                                blob = await this.canvasBlob(canvas, quality);
                                if (blob.size <= this.maxBytes) break;
                            }
                        }

                        if (blob.size > this.maxBytes) {
                            alert('Gambar hasil crop masih lebih dari 2 MB. Silakan gunakan gambar yang lebih sederhana atau kurangi detailnya.');
                            return;
                        }

                        const file = new File([blob], this.image.name.replace(/\.[^/.]+$/, '') + '.jpg', { type: 'image/jpeg' });
                        this.$wire.upload(this.model, file, () => {
                            this.previewUrl = URL.createObjectURL(blob);
                            this.close();
                        }, () => alert('Gagal mengunggah gambar.'), () => {});
                    },
                    canvasBlob(canvas, quality) {
                        return new Promise((resolve) => {
                            canvas.toBlob(resolve, 'image/jpeg', quality);
                        });
                    },
                    close() {
                        this.openModal = false;
                        if (this.sourceUrl) URL.revokeObjectURL(this.sourceUrl);
                        this.sourceUrl = null;
                    },
                };
            }
    </script>
@endonce
