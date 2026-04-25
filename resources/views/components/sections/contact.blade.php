@props(['contactEmail', 'contactPhone', 'whatsapp' => null, 'showTitle' => true])

<section id="contact" class="py-24 px-4 sm:px-6 lg:px-8 border-t border-border bg-surface/10">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16">
        <div>
            @if($showTitle)
            <h2 class="text-4xl sm:text-5xl font-black mb-8">{{ __('landing.nav.contact') }}</h2>
            @endif
            <div class="space-y-8">
                @if($contactEmail)
                <div class="flex gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center shrink-0">
                        <i data-lucide="mail" class="w-6 h-6 text-primary"></i>
                    </div>
                    <div>
                        <div class="text-sm font-black text-muted-foreground uppercase tracking-widest mb-1">{{ __('landing.contact.email') }}</div>
                        <a href="mailto:{{ $contactEmail }}" class="text-xl font-bold hover:text-primary transition-colors">{{ $contactEmail }}</a>
                    </div>
                </div>
                @endif
                
                @if($contactPhone)
                <div class="flex gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center shrink-0">
                        <i data-lucide="phone" class="w-6 h-6 text-primary"></i>
                    </div>
                    <div>
                        <div class="text-sm font-black text-muted-foreground uppercase tracking-widest mb-1">{{ __('landing.contact.phone') }}</div>
                        <a href="tel:{{ $contactPhone }}" class="inline-block hover:text-primary transition-colors" dir="ltr">
                            <pre class="text-xl font-bold font-mono m-0 p-0 bg-transparent border-none text-inherit leading-none">{{ $contactPhone }}</pre>
                        </a>
                    </div>
                </div>
                @endif

                @if($whatsapp)
                <div class="flex gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center shrink-0">
                        <i data-lucide="message-circle" class="w-6 h-6 text-emerald-500"></i>
                    </div>
                    <div>
                        <div class="text-sm font-black text-muted-foreground uppercase tracking-widest mb-1">{{ __('landing.contact.whatsapp') }}</div>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" class="hover:text-emerald-500 transition-colors">
                            <span class="text-xl font-bold">{{ __('landing.contact.chat_with_us') }}</span>
                            <pre class="text-sm font-mono m-0 p-0 opacity-60" dir="ltr">{{ $whatsapp }}</pre>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="surface-card rounded-3xl p-8 sm:p-10">
            @if($this->contactSent)
            <div class="flex flex-col items-center justify-center gap-4 py-12 text-center">
                <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-10 h-10 text-primary"></i>
                </div>
                <h3 class="text-2xl font-black">{{ __('landing.contact.message_sent') }}</h3>
                <p class="text-muted-foreground font-medium">{{ __('landing.contact.message_sent_desc') }}</p>
                <button wire:click="$set('contactSent', false)" class="mt-2 text-sm font-black text-primary hover:underline">
                    {{ __('landing.contact.send_another') }}
                </button>
            </div>
            @else
            <form wire:submit="sendMessage" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-widest text-muted-foreground">{{ __('landing.contact.full_name') }}</label>
                        <input wire:model="name" type="text" class="w-full bg-background border border-border rounded-xl px-5 py-3 focus:border-primary outline-none transition-all font-bold" placeholder="John Doe">
                        @error('name') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-widest text-muted-foreground">{{ __('landing.contact.email') }}</label>
                        <input wire:model="email" type="email" class="w-full bg-background border border-border rounded-xl px-5 py-3 focus:border-primary outline-none transition-all font-bold" placeholder="john@example.com">
                        @error('email') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-widest text-muted-foreground">{{ __('landing.contact.message') }}</label>
                    <textarea wire:model="message" rows="5" class="w-full bg-background border border-border rounded-xl px-5 py-3 focus:border-primary outline-none transition-all font-bold resize-none" placeholder="{{ __('landing.contact.how_can_we_help') }}"></textarea>
                    @error('message') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="w-full bg-primary text-primary-foreground py-4 rounded-xl text-lg font-black glow-primary hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                    <span wire:loading.remove wire:target="sendMessage">{{ __('landing.contact.send_message') }}</span>
                    <span wire:loading wire:target="sendMessage" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        {{ __('landing.contact.sending') }}
                    </span>
                </button>
            </form>
            @endif
        </div>
    </div>
</section>
