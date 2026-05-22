{{-- Reusable notification row --}}
{{-- Variables: $n (notification), $cfg (type config array) --}}

<div class="flex-1 flex gap-4 p-5">

  {{-- Icon bubble --}}
  <div class="flex-shrink-0 w-12 h-12 rounded-2xl {{ $cfg['bg'] }} flex items-center justify-center shadow-sm mt-0.5">
    <svg class="w-5 h-5 {{ $cfg['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cfg['icon'] }}"/>
    </svg>
  </div>

  {{-- Content --}}
  <div class="flex-1 min-w-0">

    {{-- Top row: title + badge + dot + time --}}
    <div class="flex items-start justify-between gap-3">
      <div class="flex items-center gap-2 flex-wrap">
        <p class="text-sm font-bold leading-snug {{ $n->is_read ? 'text-gray-500 dark:text-gray-400' : 'text-gray-900 dark:text-white' }}">
          {{ $n->title ?? 'Notification' }}
        </p>
        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $cfg['badge'] }}">
          {{ $cfg['label'] }}
        </span>
        @if(!$n->is_read)
          <span class="w-2 h-2 rounded-full bg-primary-500 shadow shadow-primary-300 inline-block flex-shrink-0"></span>
        @endif
      </div>
      <span class="text-[11px] text-gray-400 whitespace-nowrap flex-shrink-0 mt-0.5 font-medium">
        {{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}
      </span>
    </div>

    {{-- Message --}}
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5 leading-relaxed">
      {{ $n->message }}
    </p>

    {{-- Bottom row: read status label --}}
    <div class="mt-2.5 flex items-center gap-1.5">
      @if($n->is_read)
        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span class="text-[11px] text-emerald-500 font-semibold">Read</span>
      @else
        <span class="w-1.5 h-1.5 rounded-full bg-primary-500 inline-block"></span>
        <span class="text-[11px] text-primary-500 font-semibold">New</span>
      @endif
    </div>

  </div>
</div>

{{-- Right accent bar for unread --}}
@if(!$n->is_read)
  <div class="w-1 self-stretch {{ str_replace('border-l-', 'bg-', $cfg['border']) }} rounded-r-2xl flex-shrink-0 opacity-60"></div>
@endif
