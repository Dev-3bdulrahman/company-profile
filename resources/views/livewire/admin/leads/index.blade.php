<div>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Contact Messages') }}</h2>
        <p class="text-gray-500 text-sm">{{ __('Manage leads and inquiries') }}</p>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
        <table class="w-full text-right">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                    <th class="px-6 py-4 text-sm font-bold text-gray-500">{{ __('Sender') }}</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-500">{{ __('Subject') }}</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-500">{{ __('Location') }}</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-500">{{ __('Date') }}</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-500">{{ __('Status') }}</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-500">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                @foreach($leads as $lead)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 dark:text-white">{{ $lead['name'] }}</div>
                        <div class="text-xs text-gray-400" dir="ltr">{{ $lead['email'] }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 font-medium">
                        {{ $lead['subject'] }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-gray-600 dark:text-gray-400">
                            @if($lead['country'] || $lead['city'])
                                <div class="flex items-center gap-1">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i>
                                    <span>{{ $lead['city'] ?? '' }}{{ $lead['city'] && $lead['country'] ? ', ' : '' }}{{ $lead['country'] ?? '' }}</span>
                                </div>
                            @endif
                            @if($lead['ip_address'])
                                <div class="text-gray-400 mt-1" dir="ltr">{{ $lead['ip_address'] }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($lead['created_at'])->format('Y/m/d H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'new'     => 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400',
                                'read'    => 'bg-gray-50 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                                'replied' => 'bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400',
                            ];
                            $statusLabels = [
                                'new'     => __('New'),
                                'read'    => __('Read'),
                                'replied' => __('Replied'),
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $statusColors[$lead['status']] ?? $statusColors['read'] }}">
                            {{ $statusLabels[$lead['status']] ?? $lead['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1">
                            <button wire:click="viewLead({{ $lead['id'] }})" title="{{ __('View') }}"
                                class="p-2 text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                            <button wire:click="openReply({{ $lead['id'] }})" title="{{ __('Reply via Email') }}"
                                class="p-2 text-gray-500 hover:text-orange-600 dark:hover:text-orange-400 rounded-lg hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </button>
                            <button 
                                wire:click="$dispatch('swal:confirm', { 
                                    title: 'Delete Message',
                                    text: 'Are you sure you want to delete this message?',
                                    onConfirm: 'delete',
                                    params: { id: {{ $lead['id'] }} }
                                })"
                                title="{{ __('Delete Message') }}"
                                class="p-2 text-gray-500 hover:text-red-600 dark:hover:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- View Lead Modal -->
    <div x-data="{ open: @entangle('showModal') }" x-show="open" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="relative flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div @click="open = false" class="absolute inset-0 bg-gray-500/75 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-middle bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-gray-100 dark:border-gray-800">
                @if($selectedLead)
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Message Details') }}</h3>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-500">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                    <div class="space-y-6 text-right">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-400 mb-1">{{ __('Sender') }}</p>
                                <p class="font-bold text-gray-900 dark:text-white">{{ $selectedLead['name'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-1">{{ __('Email Address') }}</p>
                                <p class="font-bold text-gray-900 dark:text-white" dir="ltr">{{ $selectedLead['email'] }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-400 mb-1">{{ __('IP Address') }}</p>
                                <p class="font-mono text-sm text-gray-900 dark:text-white" dir="ltr">{{ $selectedLead['ip_address'] ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-1">{{ __('Location') }}</p>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $selectedLead['city'] ?? '' }}{{ $selectedLead['city'] && $selectedLead['country'] ? ', ' : '' }}{{ $selectedLead['country'] ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">{{ __('Subject') }}</p>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $selectedLead['subject'] }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            <p class="text-xs text-gray-400 mb-2">{{ __('Message') }}</p>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $selectedLead['message'] }}</p>
                        </div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-3">
                        <button @click="open = false"
                            class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            {{ __('Cancel') }}
                        </button>
                        @if($selectedLead['status'] === 'new')
                        <button wire:click="markAsRead({{ $selectedLead['id'] }})"
                            class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                            {{ __('Mark as Read') }}
                        </button>
                        @endif
                        <button wire:click="openReply({{ $selectedLead['id'] }})" @click="open = false"
                            class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors flex items-center gap-2">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            <span>{{ __('Reply via Email') }}</span>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reply Modal -->
    <div x-data="{ open: @entangle('showReplyModal') }" x-show="open" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div @click="open = false" class="absolute inset-0 bg-gray-900/80 backdrop-blur-sm"></div>
            <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-lg border border-gray-100 dark:border-gray-800 z-10">

                @if($replySent)
                <div class="p-10 text-center">
                    <div class="w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="check-circle" class="w-8 h-8 text-green-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Message Sent!') }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">{{ __('Your reply has been sent successfully.') }}</p>
                    <button @click="open = false"
                        class="px-6 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        {{ __('Close') }}
                    </button>
                </div>

                @else
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Reply via Email') }}</h3>
                            @if($replyTarget)
                            <p class="text-sm text-gray-400 mt-0.5" dir="ltr">→ {{ $replyTarget['email'] }}</p>
                            @endif
                        </div>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1 rounded-lg">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <!-- Error -->
                    @if($replyError)
                    <div class="mb-4 px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-sm text-red-600 dark:text-red-400">
                        {{ $replyError }}
                    </div>
                    @endif

                    <!-- Message -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('Message') }}</label>
                        <textarea wire:model="replyMessage" rows="7"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none"
                            placeholder="{{ __('Write your reply...') }}"></textarea>
                        @error('replyMessage') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Attachments -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('Attach File') }} <span class="text-gray-400 font-normal">({{ __('Optional') }})</span></label>
                        <label class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700 hover:border-orange-400 dark:hover:border-orange-500 cursor-pointer transition-colors group">
                            <i data-lucide="paperclip" class="w-5 h-5 text-gray-400 group-hover:text-orange-500 transition-colors"></i>
                            <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-orange-500 transition-colors">{{ __('Click to upload') }}</span>
                            <input type="file" wire:model="replyAttachments" multiple class="hidden" accept="*/*">
                        </label>
                        @if($replyAttachments)
                        <div class="mt-2 space-y-1">
                            @foreach($replyAttachments as $file)
                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                <i data-lucide="file" class="w-3 h-3"></i>
                                <span>{{ $file->getClientOriginalName() }}</span>
                                <span class="text-gray-400">({{ round($file->getSize() / 1024) }} KB)</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        @error('replyAttachments.*') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <button @click="open = false"
                            class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            {{ __('Cancel') }}
                        </button>
                        <button wire:click="sendReply" wire:loading.attr="disabled"
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-red-600 text-white text-sm font-bold hover:scale-105 transition-all disabled:opacity-60">
                            <span wire:loading.remove wire:target="sendReply">
                                <i data-lucide="send" class="w-4 h-4 inline-block me-1"></i>
                                {{ __('Send Reply') }}
                            </span>
                            <span wire:loading wire:target="sendReply" class="flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                </svg>
                                {{ __('Sending...') }}
                            </span>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    </div>
</div>
