{{-- Floating AI Property Assistant Widget --}}
<div x-data="{ scrollToBottom() { const el = $refs.messages; if (el) el.scrollTop = el.scrollHeight; } }"
     x-init="$watch('$wire.messages', () => $nextTick(() => scrollToBottom()))"
     class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3">

    {{-- Chat Panel --}}
    @if($open)
    <div
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="w-[370px] sm:w-[420px] bg-white rounded-2xl shadow-2xl shadow-indigo-900/20 border border-slate-200/80 flex flex-col overflow-hidden"
        style="height: 540px; max-height: calc(100vh - 120px);"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3.5 bg-gradient-to-r from-indigo-600 to-violet-600 shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3-3-3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white leading-none">Property AI</p>
                    <p class="text-[11px] text-indigo-200 mt-0.5">Your smart property assistant</p>
                </div>
            </div>
            <div class="flex items-center gap-1">
                @if(count($messages) > 0)
                <button wire:click="clearHistory"
                    class="p-1.5 rounded-lg hover:bg-white/20 text-indigo-200 hover:text-white transition-colors"
                    title="Clear chat">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                @endif
                <button wire:click="toggle"
                    class="p-1.5 rounded-lg hover:bg-white/20 text-indigo-200 hover:text-white transition-colors"
                    title="Close">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Messages Area --}}
        <div x-ref="messages" class="flex-1 overflow-y-auto p-4 space-y-3 scroll-smooth bg-slate-50/50">

            {{-- Empty / Welcome State --}}
            @if(count($messages) === 0)
            <div class="flex flex-col items-center justify-center h-full text-center px-4 gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-100 to-violet-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-slate-800 text-sm">Ask me anything about properties</p>
                    <p class="text-xs text-slate-500 mt-1">I can search listings, compare prices, and answer questions about any property.</p>
                </div>
                <div class="flex flex-wrap justify-center gap-2 mt-1">
                    @foreach([
                        '3 BHK under ₹80L in Pune',
                        'Villas for sale in Goa',
                        '2 BHK apartments for rent',
                    ] as $suggestion)
                    <button
                        wire:click="$set('input', '{{ $suggestion }}')"
                        class="px-3 py-1.5 text-xs font-medium bg-white border border-slate-200 text-slate-600 rounded-full hover:border-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all shadow-sm">
                        {{ $suggestion }}
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Message Bubbles --}}
            @foreach ($messages as $m)
            <div class="flex {{ $m['role'] === 'user' ? 'justify-end' : 'justify-start' }} gap-2">
                @if($m['role'] === 'assistant')
                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                @endif
                <div class="max-w-[80%]">
                    <div class="px-3.5 py-2.5 rounded-2xl text-sm leading-relaxed
                        {{ $m['role'] === 'user'
                            ? 'bg-gradient-to-br from-indigo-600 to-violet-600 text-white rounded-br-sm shadow-md shadow-indigo-500/20'
                            : 'bg-white text-slate-800 rounded-bl-sm border border-slate-200 shadow-sm' }}">
                        {!! nl2br(e($m['content'])) !!}
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Typing Indicator --}}
            <div wire:loading wire:target="send" class="flex justify-start gap-2">
                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl rounded-bl-sm px-4 py-3 shadow-sm">
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                        <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                        <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Input Bar --}}
        <div class="px-3 py-3 border-t border-slate-200 bg-white shrink-0">
            <form wire:submit="send" class="flex items-center gap-2">
                <input
                    id="chat-input"
                    type="text"
                    wire:model="input"
                    placeholder="Ask about properties…"
                    autocomplete="off"
                    class="flex-1 text-sm bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all placeholder:text-slate-400"
                    wire:loading.attr="disabled" wire:target="send"
                />
                <button type="submit"
                    class="w-9 h-9 shrink-0 flex items-center justify-center rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm shadow-indigo-500/30 transition-all hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled" wire:target="send">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
            <p class="text-[10px] text-slate-400 text-center mt-2">AI-powered · Prices in INR · Results may vary</p>
        </div>
    </div>
    @endif

    {{-- FAB Toggle Button --}}
    <button
        wire:click="toggle"
        class="group relative w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white shadow-xl shadow-indigo-500/40 hover:shadow-indigo-500/60 hover:scale-110 transition-all duration-300 flex items-center justify-center"
        title="{{ $open ? 'Close assistant' : 'Open AI assistant' }}">

        {{-- Pulse ring when closed --}}
        @if(!$open)
        <span class="absolute inset-0 rounded-2xl bg-indigo-500 animate-ping opacity-20"></span>
        @endif

        {{-- Unread badge when there are messages and closed --}}
        @if(!$open && count($messages) > 0)
        <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-emerald-500 text-white text-[10px] font-bold flex items-center justify-center border-2 border-white">
            {{ count($messages) > 9 ? '9+' : count($messages) }}
        </span>
        @endif

        <svg class="w-6 h-6 transition-transform duration-300 {{ $open ? 'rotate-180' : '' }}"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            @if($open)
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            @else
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3-3-3z" />
            @endif
        </svg>
    </button>
</div>