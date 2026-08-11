<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Treatment;
use App\Models\TreatmentBeforeAfter;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Treatment $treatment;
    public TreatmentBeforeAfter $beforeAfter;

    public $before_media;
    public $after_media;

    public string $caption = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(
        Treatment $treatment,
        TreatmentBeforeAfter $beforeAfter
    ): void {
        $this->treatment = $treatment;

        $this->beforeAfter = $beforeAfter;

        $this->caption = $beforeAfter->caption ?? '';
        $this->sort_order = $beforeAfter->sort_order;
        $this->is_active = (bool) $beforeAfter->is_active;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'before_media' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,mp4,webm,mov',
                'max:51200',
            ],

            'after_media' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,mp4,webm,mov',
                'max:51200',
            ],

            'caption' => [
                'nullable',
                'string',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'boolean',
            ],
        ]);

        /*
         * Replace BEFORE media
         */
        if ($this->before_media) {
            if (
                $this->beforeAfter->before_media &&
                Storage::disk('public')->exists(
                    $this->beforeAfter->before_media
                )
            ) {
                Storage::disk('public')->delete(
                    $this->beforeAfter->before_media
                );
            }

            $validated['before_media'] = $this->before_media->store(
                'treatments/before-after',
                'public'
            );
        }

        /*
         * Replace AFTER media
         */
        if ($this->after_media) {
            if (
                $this->beforeAfter->after_media &&
                Storage::disk('public')->exists(
                    $this->beforeAfter->after_media
                )
            ) {
                Storage::disk('public')->delete(
                    $this->beforeAfter->after_media
                );
            }

            $validated['after_media'] = $this->after_media->store(
                'treatments/before-after',
                'public'
            );
        }

        $this->beforeAfter->update([
            'before_media' => $validated['before_media']
                ?? $this->beforeAfter->before_media,

            'after_media' => $validated['after_media']
                ?? $this->beforeAfter->after_media,

            'caption' => $validated['caption'],
            'sort_order' => $validated['sort_order'],
            'is_active' => $validated['is_active'],
        ]);

        session()->flash(
            'success',
            'Before & After berhasil diperbarui.'
        );

        $this->redirect(
            route(
                'admin.treatments.before-afters.index',
                $this->treatment
            ),
            navigate: true
        );
    }
};
?>