<?php

namespace App\Http\Controllers\Web\Admin\Pages;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
#[Title('إدارة الصفحات')]
class Index extends Component
{
    use WithPagination;

    public function delete($id): void
    {
        $targetId = is_array($id) ? ($id['id'] ?? null) : $id;
        if (!$targetId) return;
        $page = Page::findOrFail($targetId);
        $page->delete();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'تم حذف الصفحة']);
    }

    public function toggleStatus($id): void
    {
        $targetId = is_array($id) ? ($id['id'] ?? null) : $id;
        if (!$targetId) return;
        $page = Page::findOrFail($targetId);
        $page->is_active = !$page->is_active;
        $page->save();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'تم تحديث حالة الصفحة']);
    }

    public function render()
    {
        return view('livewire.admin.pages.index', [
            'pages' => Page::orderBy('sort_order')->paginate(10)
        ]);
    }
}
