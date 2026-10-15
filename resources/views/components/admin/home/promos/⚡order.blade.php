<?php

use App\Models\Promo;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Renderless;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    #[Renderless]
    public function saveOrder(array $orderedIds): void
    {
        $validIds = Promo::query()
            ->whereIn('id', $orderedIds)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $orderedIds = array_values(array_intersect(array_map('intval', $orderedIds), $validIds));

        DB::transaction(function () use ($orderedIds): void {
            foreach ($orderedIds as $index => $promoId) {
                DB::table('promos')
                    ->where('id', $promoId)
                    ->update(['sort_order' => $index + 1]);
            }
        });
    }

    public function with(): array
    {
        return [
            'promos' => Promo::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(['id', 'title', 'slug', 'sort_order', 'start_date', 'end_date']),
        ];
    }
};
?>

<div class="mx-auto max-w-5xl space-y-6 pb-10">
    <div class="flex flex-col gap-4 rounded-2xl border border-gray-100/50 bg-white p-6 elegant-shadow sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="hidden h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 sm:flex">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-[var(--color-wfsc-dark)]">Atur Urutan Promo</h1>
                <p class="mt-1 text-sm font-medium text-gray-500">Urutan ini digunakan di Home dan halaman publik Promo.</p>
            </div>
        </div>
        <a href="{{ route('admin.home.promos.index') }}" wire:navigate class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-50 px-4 py-2.5 text-sm font-bold text-gray-600 transition-colors hover:bg-rose-50 hover:text-[var(--color-wfsc-coral)]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Daftar Promo
        </a>
    </div>

    <div class="rounded-2xl border border-amber-100 bg-amber-50/70 px-5 py-4 text-sm leading-relaxed text-amber-800">
        <strong>Petunjuk:</strong> tekan dan tahan kartu promo, lalu geser ke posisi yang diinginkan. Perubahan tersimpan otomatis setelah kartu dilepas.
    </div>

    <section x-data="{
        items: @js($promos->map(fn ($promo) => ['id' => $promo->id, 'title' => $promo->title, 'slug' => $promo->slug, 'period' => $promo->start_date?->format('d M Y') . ' - ' . ($promo->end_date?->format('d M Y') ?? 'Tanpa batas')])->values()),
        dragging: null,
        dragOver: null,
        justMoved: null,
        saveStatus: 'idle',
        startDrag(id, event) {
            this.dragging = id;
            this.dragOver = null;
            event.dataTransfer.effectAllowed = 'move';
            event.dataTransfer.setData('text/plain', String(id));
        },
        move(target) {
            const from = this.items.findIndex(item => item.id === this.dragging);
            const to = this.items.findIndex(item => item.id === target);
            if (from === -1 || to === -1 || from === to) return this.cancelDrag();
            const [moved] = this.items.splice(from, 1);
            this.items.splice(to, 0, moved);
            this.justMoved = moved.id;
            this.dragging = null;
            this.dragOver = null;
            setTimeout(() => this.justMoved = null, 700);
            this.persist();
        },
        persist() {
            this.saveStatus = 'saving';
            $wire.saveOrder(this.items.map(item => item.id))
                .then(() => {
                    this.saveStatus = 'saved';
                    setTimeout(() => this.saveStatus = 'idle', 1800);
                })
                .catch(() => this.saveStatus = 'error');
        },
        cancelDrag() {
            this.dragging = null;
            this.dragOver = null;
        },
        moveBy(index, offset) {
            const target = index + offset;
            if (target < 0 || target >= this.items.length) return;
            [this.items[index], this.items[target]] = [this.items[target], this.items[index]];
            this.justMoved = this.items[target].id;
            setTimeout(() => this.justMoved = null, 700);
            this.persist();
        }
    }" class="overflow-hidden rounded-2xl border border-gray-100/50 bg-white elegant-shadow">
        <div class="flex items-center justify-between border-b border-gray-100 bg-gray-50/70 px-5 py-4">
            <div>
                <h2 class="text-lg font-black text-[var(--color-wfsc-dark)]">Semua Promo Aktif</h2>
                <p class="mt-0.5 text-xs font-medium text-gray-500">{{ $promos->count() }} promo</p>
            </div>
            <div class="flex items-center gap-3">
                <span x-show="saveStatus === 'saving'" x-transition class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-500"><svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>Menyimpan</span>
                <span x-show="saveStatus === 'saved'" x-transition class="text-xs font-bold text-emerald-600">✓ Tersimpan</span>
                <span x-show="saveStatus === 'error'" x-transition class="text-xs font-bold text-red-500">Gagal menyimpan</span>
                <svg class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </div>
        </div>

        <div class="divide-y divide-gray-100 p-3">
            <template x-for="(promo, index) in items" :key="promo.id">
                <div draggable="true" @dragstart="startDrag(promo.id, $event)" @dragover.prevent.stop="dragOver = promo.id" @dragleave="if (dragOver === promo.id) dragOver = null" @drop.prevent.stop="move(promo.id)" @dragend="cancelDrag()" :class="{
                    'scale-[0.98] opacity-40 shadow-inner ring-2 ring-amber-400': dragging === promo.id,
                    'border-t-2 border-amber-400 bg-amber-50/70': dragOver === promo.id && dragging !== promo.id,
                    'ring-2 ring-emerald-400 bg-emerald-50/60': justMoved === promo.id
                }" class="group flex cursor-grab items-center gap-3 rounded-xl border border-transparent px-3 py-3 transition-all duration-200 hover:bg-amber-50/60 active:cursor-grabbing">
                    <svg class="h-5 w-5 shrink-0 text-gray-300 group-hover:text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 6h.01M8 12h.01M8 18h.01M16 6h.01M16 12h.01M16 18h.01"/></svg>
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-xs font-black text-gray-500" x-text="index + 1"></span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-bold text-gray-800" x-text="promo.title"></p>
                        <p class="truncate text-xs text-gray-400" x-text="promo.period"></p>
                    </div>
                    <div class="flex items-center gap-1 sm:hidden">
                        <button type="button" @click="moveBy(index, -1)" class="rounded-lg px-2 py-1 text-xs font-bold text-gray-400 hover:bg-gray-100" aria-label="Naikkan">↑</button>
                        <button type="button" @click="moveBy(index, 1)" class="rounded-lg px-2 py-1 text-xs font-bold text-gray-400 hover:bg-gray-100" aria-label="Turunkan">↓</button>
                    </div>
                </div>
            </template>
            @if ($promos->isEmpty())
                <div class="px-6 py-16 text-center text-sm text-gray-500">Belum ada promo aktif.</div>
            @endif
        </div>
    </section>
</div>
