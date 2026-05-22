@extends('layouts.app')
@section('title', 'Career Counselling â€“ PGRKAM')

@section('content')
<div class="pt-16 min-h-screen bg-gray-50 dark:bg-gray-900">

  {{-- Hero --}}
  <div class="bg-gradient-to-br from-primary-800 via-primary-700 to-blue-600 pt-10 pb-24 px-6">
    <div class="max-w-screen-xl mx-auto">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <p class="text-blue-200 text-xs font-semibold uppercase tracking-widest mb-1">Punjab Govt. Rozgar Kendra</p>
          <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">Career Counselling</h1>
          <p class="text-blue-100 mt-2 text-sm">Free one-on-one sessions with certified Punjab Government advisors</p>
        </div>
        <div class="flex gap-3 flex-wrap">
          <div class="bg-white/15 backdrop-blur-sm border border-white/25 rounded-2xl px-4 py-3 text-center">
            <p class="text-2xl font-black text-white leading-none">{{ $sessions->count() }}</p>
            <p class="text-blue-100 text-xs mt-0.5 font-semibold">My Sessions</p>
          </div>
          <div class="bg-white/15 backdrop-blur-sm border border-white/25 rounded-2xl px-4 py-3 text-center">
            <p class="text-2xl font-black text-white leading-none">{{ $sessions->where('status','completed')->count() }}</p>
            <p class="text-blue-100 text-xs mt-0.5 font-semibold">Completed</p>
          </div>
          <div class="bg-emerald-400/30 backdrop-blur-sm border border-emerald-300/40 rounded-2xl px-4 py-3 text-center">
            <p class="text-xl font-black text-white leading-none">FREE</p>
            <p class="text-emerald-100 text-xs mt-0.5 font-semibold">Always</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="max-w-screen-xl mx-auto px-4 md:px-6 -mt-14 pb-16">

    @if(session('success'))
    <div class="mb-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 rounded-2xl px-5 py-3 text-sm font-semibold flex items-center gap-2">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
      {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

      {{-- LEFT: Booking Form --}}
      <div class="lg:col-span-3 space-y-5">

        {{-- Info strip --}}
        <div class="grid grid-cols-3 gap-3">
          @foreach([
            ['icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'label'=>'Certified Advisors', 'color'=>'text-primary-600 bg-primary-50 dark:bg-primary-900/20'],
            ['icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label'=>'Flexible Timings', 'color'=>'text-blue-600 bg-blue-50 dark:bg-blue-900/20'],
            ['icon'=>'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'label'=>'Phone Confirmed', 'color'=>'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20'],
          ] as $info)
          <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-3 flex items-center gap-2.5 shadow-sm">
            <div class="w-8 h-8 rounded-xl {{ $info['color'] }} flex items-center justify-center flex-shrink-0">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $info['icon'] }}"/></svg>
            </div>
            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 leading-tight">{{ $info['label'] }}</p>
          </div>
          @endforeach
        </div>

        {{-- Form card --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-primary-50/50 dark:bg-primary-900/10 flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
              <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
              <h2 class="font-bold text-gray-800 dark:text-gray-100 text-sm">Book a New Session</h2>
              <p class="text-xs text-gray-400">Select topic, date and time</p>
            </div>
          </div>

          <form action="{{ route('counselling.book') }}" method="POST" class="p-6 space-y-5">
            @csrf

            {{-- Topic --}}
            <div>
              <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Topic / Area of Concern <span class="text-red-500">*</span></label>
              <div class="grid grid-cols-2 gap-2">
                @foreach(['Career Guidance','Resume Review','Interview Preparation','Govt. Job Preparation','Skill Development','Self-Employment','Higher Education','Other'] as $t)
                <label class="relative cursor-pointer">
                  <input type="radio" name="topic" value="{{ $t }}" class="peer sr-only" required />
                  <div class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-400 text-center transition peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/30 peer-checked:text-primary-700 dark:peer-checked:text-primary-400 hover:border-primary-300">
                    {{ $t }}
                  </div>
                </label>
                @endforeach
              </div>
              @error('topic')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Date & Time --}}
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Preferred Date <span class="text-red-500">*</span></label>
                <input type="date" name="preferred_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 transition" />
                @error('preferred_date')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Preferred Time <span class="text-red-500">*</span></label>
                <select name="preferred_time" required
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 transition">
                  <option value="">Select time</option>
                  @foreach(['9:00 AM','10:00 AM','11:00 AM','12:00 PM','2:00 PM','3:00 PM','4:00 PM','5:00 PM'] as $ti)
                    <option>{{ $ti }}</option>
                  @endforeach
                </select>
                @error('preferred_time')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
              </div>
            </div>

            {{-- Notes --}}
            <div>
              <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Additional Notes <span class="text-gray-400 font-normal normal-case">(Optional)</span></label>
              <textarea name="notes" rows="3" placeholder="Describe your situation, goals, or questions..."
                class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400 resize-none transition"></textarea>
            </div>

            {{-- Free notice --}}
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl p-4 flex items-start gap-3">
              <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              </div>
              <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">Sessions are <strong class="text-emerald-700 dark:text-emerald-400">completely free</strong> and conducted by certified career advisors from the Punjab Government. You'll be contacted on your registered phone number to confirm.</p>
            </div>

            <button type="submit"
              class="w-full bg-gradient-to-r from-primary-700 to-blue-600 hover:from-primary-800 hover:to-blue-700 text-white font-bold py-3.5 rounded-xl transition shadow-lg shadow-primary-200/50 dark:shadow-none flex items-center justify-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
              Book Session
            </button>
          </form>
        </div>
      </div>

      {{-- RIGHT: My Sessions --}}
      <div class="lg:col-span-2">
        <div class="sticky top-24">
          <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="bg-primary-700 px-5 py-3 flex items-center justify-between">
              <span class="text-white text-sm font-bold">My Sessions</span>
              <span class="bg-white/20 text-white text-xs font-bold px-2.5 py-1 rounded-full">{{ $sessions->count() }}</span>
            </div>

            @forelse($sessions as $s)
            @php
              $statusConfig = match($s->status) {
                'confirmed'  => ['bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400', 'Confirmed'],
                'completed'  => ['bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400', 'Completed'],
                'cancelled'  => ['bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400', 'Cancelled'],
                default      => ['bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400', 'Pending'],
              };
              $topicInitial = strtoupper(substr($s->topic, 0, 2));
              $colors = ['bg-primary-600','bg-blue-500','bg-indigo-500','bg-blue-700','bg-primary-500','bg-sky-600'];
              $color = $colors[crc32($s->topic) % count($colors)];
            @endphp
            <div class="px-5 py-4 border-b border-gray-50 dark:border-gray-700 last:border-0 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
              <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl {{ $color }} flex items-center justify-center text-white font-black text-xs flex-shrink-0">
                  {{ $topicInitial }}
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-start justify-between gap-2">
                    <p class="font-semibold text-gray-900 dark:text-white text-sm leading-tight">{{ $s->topic }}</p>
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-full flex-shrink-0 {{ $statusConfig[0] }}">{{ $statusConfig[1] }}</span>
                  </div>
                  <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                    <span class="text-[11px] text-gray-400 flex items-center gap-1">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                      {{ \Carbon\Carbon::parse($s->preferred_date)->format('d M Y') }}
                    </span>
                    <span class="text-[11px] text-gray-400 flex items-center gap-1">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                      {{ $s->preferred_time }}
                    </span>
                  </div>
                  @if($s->notes)
                  <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-1.5 line-clamp-2 italic">"{{ $s->notes }}"</p>
                  @endif
                  <p class="text-[11px] text-gray-300 dark:text-gray-600 mt-1">Booked {{ \Carbon\Carbon::parse($s->created_at)->diffForHumans() }}</p>
                </div>
              </div>
            </div>
            @empty
            <div class="py-12 text-center px-5">
              <div class="w-14 h-14 mx-auto mb-3 bg-primary-50 dark:bg-primary-900/20 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
              </div>
              <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">No sessions booked yet</p>
              <p class="text-xs text-gray-400 mt-1">Book your first free session today</p>
            </div>
            @endforelse
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
