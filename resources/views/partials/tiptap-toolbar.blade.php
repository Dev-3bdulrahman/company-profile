<div class="flex flex-wrap gap-1 p-2 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    @foreach([
        ['cmd' => 'bold',          'icon' => 'bold',          'title' => 'Bold'],
        ['cmd' => 'italic',        'icon' => 'italic',        'title' => 'Italic'],
        ['cmd' => 'underline',     'icon' => 'underline',     'title' => 'Underline'],
        ['cmd' => 'strike',        'icon' => 'strikethrough', 'title' => 'Strike'],
        ['cmd' => 'h2',            'icon' => 'heading-2',     'title' => 'H2'],
        ['cmd' => 'h3',            'icon' => 'heading-3',     'title' => 'H3'],
        ['cmd' => 'bulletList',    'icon' => 'list',          'title' => 'Bullet List'],
        ['cmd' => 'orderedList',   'icon' => 'list-ordered',  'title' => 'Ordered List'],
        ['cmd' => 'blockquote',    'icon' => 'quote',         'title' => 'Blockquote'],
        ['cmd' => 'link',          'icon' => 'link',          'title' => 'Link'],
        ['cmd' => 'undo',          'icon' => 'undo-2',        'title' => 'Undo'],
        ['cmd' => 'redo',          'icon' => 'redo-2',        'title' => 'Redo'],
    ] as $btn)
    <button type="button"
        @click="editor?.chain().focus()['{{ $btn['cmd'] === 'h2' ? 'toggleHeading' : ($btn['cmd'] === 'h3' ? 'toggleHeading' : 'toggle' . ucfirst($btn['cmd'])) }}']({{ $btn['cmd'] === 'h2' ? '{level: 2}' : ($btn['cmd'] === 'h3' ? '{level: 3}' : '') }}).run()"
        class="p-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 transition-colors"
        title="{{ $btn['title'] }}">
        <i data-lucide="{{ $btn['icon'] }}" class="w-4 h-4"></i>
    </button>
    @endforeach
</div>
