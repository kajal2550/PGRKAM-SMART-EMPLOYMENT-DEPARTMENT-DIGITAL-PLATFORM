@extends('layouts.app')
@section('title', 'Enroll – {{ $training->title }} – PGRKAM')

@section('content')
<div class="min-h-screen bg-gray-50">

  {{-- ── Hero Banner ── --}}
  <div class="relative py-12 px-6 overflow-hidden"
       style="background:linear-gradient(135deg,#1e3a8a 0%,#1d4ed8 50%,#2563eb 100%)">
    <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle at 70% 30%,white 1px,transparent 1px);background-size:28px 28px"></div>
    <div class="absolute -top-16 -right-16 w-80 h-80 rounded-full bg-white/5 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-60 h-60 rounded-full bg-white/5 pointer-events-none"></div>

    <div class="relative z-10 max-w-screen-lg mx-auto">
      <a href="{{ route('training.index') }}"
         class="inline-flex items-center gap-2 text-white/70 hover:text-white text-sm font-semibold mb-6 transition group">
        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Training Programs
      </a>

      <div class="flex flex-col md:flex-row md:items-start gap-5">
        <div class="w-16 h-16 bg-white/15 rounded-2xl flex items-center justify-center flex-shrink-0 border border-white/20">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
          </svg>
        </div>
        <div class="flex-1">
          <p class="text-white/60 text-xs font-bold uppercase tracking-widest mb-1">Course Enrollment — Government of Punjab</p>
          <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight mb-2">{{ $training->title }}</h1>
          <p class="text-white/75 text-lg font-medium">{{ $training->provider }}</p>

          <div class="flex flex-wrap gap-2 mt-4">
            @if($training->category)
              <span class="bg-white/20 text-white text-xs px-3 py-1.5 rounded-full font-semibold border border-white/15">{{ $training->category }}</span>
            @endif
            @if($training->duration)
              <span class="bg-white/20 text-white text-xs px-3 py-1.5 rounded-full font-semibold border border-white/15">
                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $training->duration }}
              </span>
            @endif
            @if($training->certificate_type)
              <span class="bg-yellow-400/25 text-yellow-100 text-xs px-3 py-1.5 rounded-full font-semibold border border-yellow-300/20">🏆 {{ $training->certificate_type }}</span>
            @endif
            @if($training->fee)
              <span class="bg-green-400/25 text-green-100 text-xs px-3 py-1.5 rounded-full font-semibold border border-green-300/20">₹ {{ $training->fee }}</span>
            @endif
            <span class="{{ $seatsLeft <= 0 ? 'bg-red-400/25 text-red-100 border-red-300/20' : ($seatsLeft <= 5 ? 'bg-orange-400/25 text-orange-100 border-orange-300/20' : 'bg-white/20 text-white border-white/15') }} text-xs px-3 py-1.5 rounded-full font-semibold border">
              👥 {{ $seatsLeft <= 0 ? 'All seats filled' : $seatsLeft.' seats left' }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Body ── --}}
  <div class="max-w-screen-lg mx-auto px-6 py-10">

    {{-- Flash messages --}}
    @if(session('success'))
      <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-2xl">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="font-semibold text-sm">{{ session('success') }}</p>
      </div>
    @endif
    @if(session('error'))
      <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-2xl">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="font-semibold text-sm">{{ session('error') }}</p>
      </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

      {{-- ── Left: Program Details ── --}}
      <div class="lg:col-span-1 space-y-5">

        {{-- Overview card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="px-5 py-4 border-b border-gray-50">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Program Overview</p>
          </div>
          <div class="grid grid-cols-2 divide-x divide-y divide-gray-50">
            <div class="p-4">
              <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Duration</p>
              <p class="text-sm font-bold text-gray-800">{{ $training->duration ?? '—' }}</p>
            </div>
            <div class="p-4">
              <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Total Seats</p>
              <p class="text-sm font-bold text-gray-800">{{ $training->enrolled_count }}/{{ $training->total_seats }}</p>
            </div>
            <div class="p-4">
              <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Start Date</p>
              <p class="text-sm font-bold text-gray-800">{{ $training->start_date ? \Carbon\Carbon::parse($training->start_date)->format('d M Y') : '—' }}</p>
            </div>
            <div class="p-4">
              <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">End Date</p>
              <p class="text-sm font-bold text-gray-800">{{ $training->end_date ? \Carbon\Carbon::parse($training->end_date)->format('d M Y') : '—' }}</p>
            </div>
          </div>
          @if($training->fee)
          <div class="mx-4 mb-4 bg-green-50 border border-green-100 rounded-xl px-4 py-3 flex items-center gap-3">
            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
              <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div>
              <p class="text-[10px] font-bold text-green-600 uppercase">Program Fee</p>
              <p class="text-sm font-extrabold text-green-800">{{ $training->fee }}</p>
            </div>
          </div>
          @endif
        </div>

        {{-- Description --}}
        @if($training->description)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">About This Program</p>
          <p class="text-sm text-gray-600 leading-relaxed">{{ $training->description }}</p>
        </div>
        @endif

        {{-- Syllabus --}}
        @if($training->syllabus)
        @php($syllabus = is_array($training->syllabus) ? $training->syllabus : (is_string($training->syllabus) ? json_decode($training->syllabus, true) : []))
        @if($syllabus)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">What You Will Learn</p>
          <ul class="space-y-2">
            @foreach($syllabus as $s)
            <li class="flex items-start gap-2.5 text-sm text-gray-700">
              <div class="w-5 h-5 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-3 h-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
              </div>
              {{ $s }}
            </li>
            @endforeach
          </ul>
        </div>
        @endif
        @endif

      </div>

      {{-- ── Right: Enrollment Form ── --}}
      <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

          {{-- Form header --}}
          <div class="px-7 py-5 border-b border-gray-50">
            <h2 class="text-lg font-extrabold text-gray-900">Your Enrollment Details</h2>
            <p class="text-sm text-gray-500 mt-0.5">Fill in the details below to confirm your spot</p>
          </div>

          <div class="px-7 py-7">

            @if($isEnrolled)
              {{-- Already enrolled state --}}
              <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center mb-5">
                  <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-2">Already Enrolled!</h3>
                <p class="text-gray-500 text-sm max-w-sm">You are already enrolled in <strong>{{ $training->title }}</strong>. Check your enrollments page for status updates.</p>
                <a href="{{ route('enrollments') }}" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition text-sm">
                  View My Enrollments →
                </a>
              </div>

            @elseif($seatsLeft <= 0)
              {{-- Full --}}
              <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-5">
                  <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-2">All Seats Filled</h3>
                <p class="text-gray-500 text-sm max-w-sm">This program is currently full. Check back later for new batches.</p>
                <a href="{{ route('training.index') }}" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition text-sm">
                  ← Browse Other Programs
                </a>
              </div>

            @else
              {{-- Enrollment form --}}
              @if($errors->any())
              <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3">
                <ul class="text-xs space-y-1 list-disc list-inside">
                  @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
              </div>
              @endif

              <form action="{{ route('training.enroll', $training->id) }}" method="POST" class="space-y-6">
                @csrf

                {{-- Personal info --}}
                <div>
                  <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Personal Information</p>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                      <label class="block text-xs font-semibold text-gray-600 mb-1.5">Full Name</label>
                      <input type="text" value="{{ auth()->user()->name }}" disabled
                             class="input-field bg-gray-50 text-gray-500 cursor-not-allowed" />
                    </div>
                    <div>
                      <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email</label>
                      <input type="email" value="{{ auth()->user()->email }}" disabled
                             class="input-field bg-gray-50 text-gray-500 cursor-not-allowed" />
                    </div>
                    <div>
                      <label class="block text-xs font-semibold text-gray-600 mb-1.5">Phone <span class="text-red-500">*</span></label>
                      <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                               class="input-field pl-9 @error('phone') border-red-300 @enderror" placeholder="10-digit mobile" />
                      </div>
                      @error('phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                      <label class="block text-xs font-semibold text-gray-600 mb-1.5">Highest Qualification <span class="text-red-500">*</span></label>
                      <select name="qualification" required class="input-field @error('qualification') border-red-300 @enderror">
                        <option value="">Select your qualification</option>
                        @foreach(['Below 10th','10th Pass','12th Pass','ITI / Diploma','Graduate','Post Graduate'] as $q)
                          <option {{ old('qualification') == $q ? 'selected' : '' }}>{{ $q }}</option>
                        @endforeach
                      </select>
                      @error('qualification')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                  </div>
                </div>

                {{-- Batch timing --}}
                <div>
                  <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Preferred Batch Timing <span class="text-red-500">*</span></p>
                  <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach([
                      ['val'=>'Morning',   'icon'=>'🌅', 'sub'=>'9 AM – 12 PM'],
                      ['val'=>'Afternoon', 'icon'=>'☀️',  'sub'=>'1 PM – 4 PM' ],
                      ['val'=>'Evening',   'icon'=>'🌆', 'sub'=>'5 PM – 8 PM' ],
                      ['val'=>'Weekend',   'icon'=>'📅', 'sub'=>'Sat & Sun'   ],
                    ] as $slot)
                    <label class="relative flex flex-col items-center gap-1.5 py-4 px-3 rounded-2xl border-2 cursor-pointer transition
                                  {{ old('preferred_timing', 'Morning') == $slot['val'] ? 'border-primary-500 bg-primary-50' : 'border-gray-200 hover:border-primary-300 hover:bg-gray-50' }}">
                      <input type="radio" name="preferred_timing" value="{{ $slot['val'] }}"
                             {{ old('preferred_timing', 'Morning') == $slot['val'] ? 'checked' : '' }}
                             class="sr-only" onchange="this.closest('form').querySelectorAll('[data-timing]').forEach(e=>e.classList.remove('border-primary-500','bg-primary-50'));this.closest('label').classList.add('border-primary-500','bg-primary-50')" />
                      <span class="text-2xl">{{ $slot['icon'] }}</span>
                      <span class="text-xs font-bold text-gray-800">{{ $slot['val'] }}</span>
                      <span class="text-[10px] text-gray-400">{{ $slot['sub'] }}</span>
                    </label>
                    @endforeach
                  </div>
                  @error('preferred_timing')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Notes --}}
                <div>
                  <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Additional Notes <span class="text-gray-400 font-normal">(Optional)</span>
                  </label>
                  <textarea name="notes" rows="4"
                            placeholder="Any special requirements, questions, or additional information…"
                            class="input-field resize-none">{{ old('notes') }}</textarea>
                </div>

                {{-- Confirmation box --}}
                <div class="bg-gradient-to-r from-primary-50 to-blue-50 border border-primary-100 rounded-2xl p-5 flex items-start gap-4">
                  <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                  </div>
                  <div class="text-sm text-gray-600 leading-relaxed space-y-1">
                    <p>Enrolling in <strong class="text-primary-700">{{ $training->title }}</strong> by <strong class="text-primary-700">{{ $training->provider }}</strong>.</p>
                    @if($training->start_date)
                      <p class="text-primary-600 font-semibold">📅 Program starts: {{ \Carbon\Carbon::parse($training->start_date)->format('d F Y') }}</p>
                    @endif
                    <p class="text-orange-600 font-semibold">👥 {{ $seatsLeft }} seats remaining — confirm your spot now!</p>
                    <p class="text-gray-500 text-xs mt-1">You will be contacted on your registered phone to confirm the batch details.</p>
                  </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-3 pt-2">
                  <a href="{{ route('training.index') }}"
                     class="flex-1 py-3.5 rounded-xl border-2 border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition text-sm text-center">
                    ← Back
                  </a>
                  <button type="submit"
                          class="flex-[3] py-3.5 rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold transition text-sm shadow-lg shadow-primary-200">
                    🎓 Confirm Enrollment
                  </button>
                </div>

              </form>
            @endif

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
