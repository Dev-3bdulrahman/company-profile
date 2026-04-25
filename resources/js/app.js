import './bootstrap';
import { createIcons, icons } from 'lucide';
import { Editor, Node, mergeAttributes } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import TextAlign from '@tiptap/extension-text-align';
import Underline from '@tiptap/extension-underline';
import Link from '@tiptap/extension-link';

function initLucide() {
  createIcons({ icons, attrs: { 'stroke-width': 2 } });
}
document.addEventListener('DOMContentLoaded', initLucide);
document.addEventListener('livewire:navigated', initLucide);
window.initLucide = initLucide;

// Resizable Image Extension
const ResizableImage = Node.create({
    name: 'resizableImage',
    group: 'block',
    atom: true,
    draggable: true,

    addAttributes() {
        return {
            src:    { default: null },
            alt:    { default: null },
            width:  { default: '100%' },
            height: { default: 'auto' },
            align:  { default: 'center' },
        };
    },

    parseHTML() {
        return [{ tag: 'figure[data-image]', getAttrs: el => ({
            src:    el.querySelector('img')?.src,
            alt:    el.querySelector('img')?.alt,
            width:  el.querySelector('img')?.style.width || '100%',
            height: el.querySelector('img')?.style.height || 'auto',
            align:  el.dataset.align || 'center',
        }) }];
    },

    renderHTML({ HTMLAttributes }) {
        const alignMap = { left: 'margin-right:auto;', center: 'margin-left:auto; margin-right:auto;', right: 'margin-left:auto;' };
        return ['figure', {
            'data-image': '',
            'data-align': HTMLAttributes.align,
            style: `display:block; ${alignMap[HTMLAttributes.align] || alignMap.center}`,
        }, ['img', {
            src: HTMLAttributes.src,
            alt: HTMLAttributes.alt || '',
            style: `width:${HTMLAttributes.width}; height:${HTMLAttributes.height}; max-width:100%; display:block; border-radius:0.5rem; object-fit:contain;`,
        }]];
    },

    addNodeView() {
        return ({ node, updateAttributes }) => {
            const outer = document.createElement('div');
            outer.style.cssText = 'display:flex; width:100%; user-select:none;';

            const wrapper = document.createElement('div');
            wrapper.style.cssText = 'position:relative; display:inline-block; max-width:100%; line-height:0;';
            wrapper.style.width  = node.attrs.width;
            wrapper.style.height = node.attrs.height !== 'auto' ? node.attrs.height : '';

            const applyAlign = (align) => {
                const map = { left: 'flex-start', center: 'center', right: 'flex-end' };
                outer.style.justifyContent = map[align] || 'center';
            };
            applyAlign(node.attrs.align);

            const img = document.createElement('img');
            img.src = node.attrs.src;
            img.alt = node.attrs.alt || '';
            img.style.cssText = 'width:100%; height:100%; display:block; border-radius:0.5rem; pointer-events:none; object-fit:contain;';

            // Corner resize handles: se, sw, ne, nw
            const corners = [
                { id: 'se', bottom: '-5px', right: '-5px',  cursor: 'se-resize' },
                { id: 'sw', bottom: '-5px', left:  '-5px',  cursor: 'sw-resize' },
                { id: 'ne', top:    '-5px', right: '-5px',  cursor: 'ne-resize' },
                { id: 'nw', top:    '-5px', left:  '-5px',  cursor: 'nw-resize' },
            ];

            corners.forEach(({ id, cursor, ...pos }) => {
                const h = document.createElement('div');
                const posStr = Object.entries(pos).map(([k,v]) => `${k}:${v}`).join(';');
                h.style.cssText = `position:absolute; ${posStr}; width:12px; height:12px; background:#3b82f6; border-radius:2px; cursor:${cursor}; opacity:0; transition:opacity 0.15s; z-index:10;`;

                let startX, startY, startW, startH, isResizing = false;
                h.addEventListener('mousedown', e => {
                    e.preventDefault(); e.stopPropagation();
                    isResizing = true;
                    startX = e.clientX;
                    startY = e.clientY;
                    startW = wrapper.offsetWidth;
                    startH = wrapper.offsetHeight;
                    document.body.style.cursor = cursor;
                    document.body.style.userSelect = 'none';

                    const onMove = e => {
                        if (!isResizing) return;
                        const dx = e.clientX - startX;
                        const dy = e.clientY - startY;
                        const maxW = outer.offsetWidth || 9999;

                        let newW = startW, newH = startH;
                        if (id === 'se') { newW = startW + dx; newH = startH + dy; }
                        if (id === 'sw') { newW = startW - dx; newH = startH + dy; }
                        if (id === 'ne') { newW = startW + dx; newH = startH - dy; }
                        if (id === 'nw') { newW = startW - dx; newH = startH - dy; }

                        newW = Math.max(80, Math.min(newW, maxW));
                        newH = Math.max(60, newH);

                        wrapper.style.width  = newW + 'px';
                        wrapper.style.height = newH + 'px';
                    };
                    const onUp = () => {
                        if (!isResizing) return;
                        isResizing = false;
                        
                        const currentWidth = wrapper.style.width;
                        const currentHeight = wrapper.style.height;

                        updateAttributes({ 
                            width: currentWidth, 
                            height: currentHeight 
                        });

                        document.body.style.cursor = '';
                        document.body.style.userSelect = '';
                        document.removeEventListener('mousemove', onMove);
                        document.removeEventListener('mouseup', onUp);
                    };
                    document.addEventListener('mousemove', onMove);
                    document.addEventListener('mouseup', onUp);
                });

                wrapper.appendChild(h);
                // store handle ref for show/hide
                wrapper['_h_' + id] = h;
            });

            wrapper.addEventListener('mouseenter', () => corners.forEach(({ id }) => { wrapper['_h_' + id].style.opacity = '1'; }));
            wrapper.addEventListener('mouseleave', () => corners.forEach(({ id }) => { wrapper['_h_' + id].style.opacity = '0'; }));

            wrapper.appendChild(img);
            outer.appendChild(wrapper);

            return {
                dom: outer,
                // Called when tiptap updates node attrs (e.g. align change)
                update(updatedNode) {
                    if (updatedNode.type.name !== node.type.name) return false;
                    applyAlign(updatedNode.attrs.align);
                    return true;
                },
            };
        };
    },

    addCommands() {
        return {
            setImage: attrs => ({ commands }) => commands.insertContent({ type: this.name, attrs }),
        };
    },
});

// Global editors store
const editors = {};

window.initRichEditor = function(containerId, wireId, contentKey, uploadRoute, initialAr, initialEn, initialLang, useFlat) {
    if (editors[containerId]) return;

    const container = document.getElementById(containerId);
    if (!container) return;

    const state = {
        contents: { ar: initialAr || '', en: initialEn || '' },
        currentLang: initialLang || 'ar',
    };

    const editor = new Editor({
        extensions: [
            StarterKit,
            Underline,
            Link.configure({ openOnClick: false }),
            ResizableImage,
            TextAlign.configure({ types: ['heading', 'paragraph'] }),
        ],
        content: state.contents[state.currentLang] || '',
        editorProps: {
            attributes: {
                class: 'outline-none min-h-[280px] p-4',
                dir: state.currentLang === 'ar' ? 'rtl' : 'ltr',
            }
        },
        onUpdate: ({ editor }) => {
            state.contents[state.currentLang] = editor.getHTML();
            const wire = window.Livewire?.find(wireId);
            if (wire) {
                const wireKey = useFlat
                    ? contentKey + '_' + state.currentLang
                    : contentKey + '.' + state.currentLang;
                wire.set(wireKey, editor.getHTML(), false);
            }
        },
        onSelectionUpdate: ({ editor }) => {
            const imgAlignBtns = container.closest('.tiptap-editor-wrap')
                ?.querySelector('.img-align-btns');
            if (!imgAlignBtns) return;
            imgAlignBtns.style.display = editor.isActive('resizableImage') ? 'flex' : 'none';
        },
    });

    container.appendChild(editor.options.element);
    editors[containerId] = { editor, state, uploadRoute, wireId, contentKey };
};

window.editorCmd = function(containerId, action) {
    const inst = editors[containerId];
    if (!inst) return;
    const e = inst.editor;
    const c = e.chain().focus();

    // Unified alignment logic
    if (action.startsWith('align') && action !== 'alignJustify') {
        if (e.isActive('resizableImage')) {
            const align = action.replace('align', '').toLowerCase();
            c.updateAttributes('resizableImage', { align }).run();
            return;
        }
    }

    if (action === 'bold')              c.toggleBold().run();
    else if (action === 'italic')       c.toggleItalic().run();
    else if (action === 'underline')    c.toggleUnderline().run();
    else if (action === 'strike')       c.toggleStrike().run();
    else if (action === 'h2')           c.toggleHeading({ level: 2 }).run();
    else if (action === 'h3')           c.toggleHeading({ level: 3 }).run();
    else if (action === 'bulletList')   c.toggleBulletList().run();
    else if (action === 'orderedList')  c.toggleOrderedList().run();
    else if (action === 'blockquote')   c.toggleBlockquote().run();
    else if (action === 'undo')         c.undo().run();
    else if (action === 'redo')         c.redo().run();
    else if (action === 'alignLeft')    c.setTextAlign('left').run();
    else if (action === 'alignCenter')  c.setTextAlign('center').run();
    else if (action === 'alignRight')   c.setTextAlign('right').run();
    else if (action === 'alignJustify') c.setTextAlign('justify').run();
    else if (action === 'link') {
        const url = prompt('Enter URL');
        if (url) e.chain().focus().setLink({ href: url }).run();
    }
};

window.editorSwitchLang = function(containerId, newLang) {
    const inst = editors[containerId];
    if (!inst) return;
    const { editor, state } = inst;
    state.contents[state.currentLang] = editor.getHTML();
    state.currentLang = newLang;
    editor.commands.setContent(state.contents[newLang] || '', false);
    const dom = editor.view.dom;
    dom.setAttribute('dir', newLang === 'ar' ? 'rtl' : 'ltr');
};

window.editorUploadImg = async function(containerId, file) {
    const inst = editors[containerId];
    if (!inst || !file || !inst.uploadRoute) return;
    const token = document.querySelector('meta[name=csrf-token]')?.content || '';
    const fd = new FormData();
    fd.append('image', file);
    fd.append('_token', token);
    try {
        const res = await fetch(inst.uploadRoute, {
            method: 'POST',
            body: fd,
            headers: { 'X-CSRF-TOKEN': token },
        });
        const data = await res.json();
        if (data.url) inst.editor.chain().focus().setImage({ src: data.url }).run();
    } catch (err) {
        console.error('Upload failed:', err);
    }
};

document.addEventListener('livewire:navigating', () => {
    Object.keys(editors).forEach(id => {
        editors[id].editor.destroy();
        delete editors[id];
    });
});

const tailwindSafelist = `
    fixed inset-0 z-50 overflow-y-auto flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0
    bg-gray-500 bg-opacity-75 transition-opacity inline-block align-middle bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:max-w-4xl sm:max-w-5xl sm:w-full border dark:border-gray-800
    ease-out duration-300 opacity-0 opacity-100 scale-95 scale-100 translate-y-4 sm:translate-y-0 ease-in duration-200
    text-xl font-bold text-gray-900 dark:text-white text-gray-700 dark:text-gray-300 text-sm font-medium mb-1 mb-2 mb-4 mb-6 mb-8
    w-full px-6 py-6 px-4 py-2 border-b border-gray-100 dark:border-gray-800 gap-3 gap-4 gap-6 grid grid-cols-2
    bg-blue-50 bg-blue-100 bg-blue-500 bg-blue-600 bg-blue-900/20 text-blue-400 text-blue-600 ring-blue-500
    bg-purple-50 bg-purple-500 bg-purple-600 bg-purple-900/20 text-purple-400 text-purple-600 ring-purple-500
    bg-green-50 bg-green-500 bg-green-600 bg-green-900/20 text-green-400 text-green-600 ring-green-500
    bg-red-50 bg-red-500 bg-red-600 bg-red-900/20 text-red-400 text-red-600 ring-red-500
    bg-gray-50 bg-gray-100 bg-gray-500 bg-gray-600 bg-gray-700 bg-gray-800 bg-gray-900 bg-gray-900/20 text-gray-400 text-gray-600
    w-4 h-4 w-5 h-5 w-6 h-6 w-12 h-12
`;
