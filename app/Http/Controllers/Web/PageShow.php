<?php

namespace App\Http\Controllers\Web;

use App\Models\Page;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')]
class PageShow extends Component
{
    public Page $page;

    public function mount(string $slug)
    {
        $this->page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.page-show')
            ->title($this->page->getTranslation('title'));
    }
}
