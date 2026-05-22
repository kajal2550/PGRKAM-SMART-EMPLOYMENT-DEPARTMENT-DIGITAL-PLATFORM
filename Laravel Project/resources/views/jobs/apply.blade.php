@extends('layouts.app')
@section('title', 'Apply – {{ $job->title }} – PGRKAM')

@section('content')
<div class="min-h-screen bg-gray-50 pb-16">

  {{-- ── Hero Banner ── --}}
  <div class="bg-gradient-to-r from-primary-700 via-primary-800 to-primary-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle at 70% 50%, white 1px, transparent 1px);background-size:28px 28px"></div>
    <div class="max-w-screen-lg mx-auto px-6 py-8 relative">
      <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 text-white/70 hover:text-white text-sm font-medium mb-5 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Jobs
      </a>
      <div class="flex items-start gap-5">
        <div class="w-14 h-14 bg-white/15 rounded-2xl flex items-center justify-center flex-shrink-0 border border-white/20">
          <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/></svg>
        </div>
        <div>
          <p class="text-white/60 text-xs font-bold uppercase tracking-widest mb-1">Job Application</p>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">{{ $job->title }}</h1>
          <p class="text-white/70 mt-1 font-medium">{{ $job->department }}</p>
          <div class="flex flex-wrap gap-3 mt-4">
            @if($job->location)
              <span class="flex items-center gap-1.5 text-white/80 text-sm bg-white/10 px-3 py-1.5 rounded-full border border-white/15">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $job->location }}
              </span>
            @endif
            @if($job->salary_range)
              <span class="flex items-center gap-1.5 text-white/80 text-sm bg-white/10 px-3 py-1.5 rounded-full border border-white/15">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $job->salary_range }}
              </span>
            @endif
            @if($job->vacancies)
              <span class="flex items-center gap-1.5 text-yellow-200 text-sm bg-yellow-400/20 px-3 py-1.5 rounded-full border border-yellow-300/20 font-semibold">
                👥 {{ $job->vacancies }} Vacancies
              </span>
            @endif
            @if($job->application_deadline)
              <span class="flex items-center gap-1.5 text-orange-200 text-sm bg-orange-400/20 px-3 py-1.5 rounded-full border border-orange-300/20 font-semibold">
                ⏰ Deadline: {{ \Carbon\Carbon::parse($job->application_deadline)->format('d M Y') }}
              </span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Main Content ── --}}
  <div class="max-w-screen-lg mx-auto px-6 py-10">

    {{-- Flash Messages --}}
    @if(session('success'))
      <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4 flex items-center gap-3">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="font-semibold">{{ session('success') }}</p>
      </div>
    @endif
    @if(session('error'))
      <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 flex items-center gap-3">
        <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="font-semibold">{{ session('error') }}</p>
      </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

      {{-- ── Left: Job Info ── --}}
      <div class="lg:col-span-1 space-y-5">

        {{-- Key details card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Job Details</p>
          <div class="space-y-3">
            <div class="flex justify-between text-sm">
              <span class="text-gray-500 font-medium">Job Type</span>
              <span class="font-semibold text-gray-800 capitalize">{{ $job->type ?? '—' }}</span>
            </div>
            <div class="h-px bg-gray-50"></div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-500 font-medium">Location</span>
              <span class="font-semibold text-gray-800">{{ $job->location ?? '—' }}</span>
            </div>
            <div class="h-px bg-gray-50"></div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-500 font-medium">Vacancies</span>
              <span class="font-semibold text-primary-700">{{ $job->vacancies ?? '—' }}</span>
            </div>
            <div class="h-px bg-gray-50"></div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-500 font-medium">Posted On</span>
              <span class="font-semibold text-gray-800">{{ $job->posted_on ? \Carbon\Carbon::parse($job->posted_on)->format('d M Y') : '—' }}</span>
            </div>
            <div class="h-px bg-gray-50"></div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-500 font-medium">Last Date</span>
              <span class="font-semibold text-orange-600">{{ $job->application_deadline ? \Carbon\Carbon::parse($job->application_deadline)->format('d M Y') : '—' }}</span>
            </div>
          </div>
          @if($job->salary_range)
          <div class="mt-4 bg-green-50 border border-green-100 rounded-xl px-4 py-3 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
              <p class="text-[10px] font-bold text-green-600 uppercase tracking-wide">Salary Range</p>
              <p class="text-sm font-extrabold text-green-800">{{ $job->salary_range }}</p>
            </div>
          </div>
          @endif
        </div>

        {{-- Description --}}
        @if($job->description)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">About This Role</p>
          <p class="text-sm text-gray-600 leading-relaxed">{{ $job->description }}</p>
        </div>
        @endif

        {{-- Qualifications --}}
        @php($quals = is_array($job->qualifications) ? $job->qualifications : (is_string($job->qualifications) ? json_decode($job->qualifications, true) : []))
        @if(!empty($quals))
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
          <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Required Qualifications</p>
          <ul class="space-y-2">
            @foreach($quals as $q)
            <li class="flex items-start gap-2.5 text-sm text-gray-700">
              <div class="w-5 h-5 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-3 h-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              </div>
              {{ $q }}
            </li>
            @endforeach
          </ul>
        </div>
        @endif

      </div>

      {{-- ── Right: Application Form ── --}}
      <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

          {{-- Form header --}}
          <div class="bg-gray-50 border-b border-gray-100 px-7 py-5">
            <h2 class="text-lg font-extrabold text-gray-900">Your Application</h2>
            <p class="text-sm text-gray-500 mt-0.5">Fill in the details below to apply for this position</p>
          </div>

          @if($isApplied)
          <div class="px-7 py-16 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-xl font-extrabold text-gray-900 mb-2">Already Applied!</h3>
            <p class="text-gray-500 mb-6">You have already submitted an application for this position.</p>
            <a href="{{ route('applications') }}" class="btn-primary">View My Applications</a>
          </div>
          @else
          <form action="{{ route('jobs.apply', $job->id) }}" method="POST" enctype="multipart/form-data" class="px-7 py-6 space-y-5">
            @csrf

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
              <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="applicant_name" value="{{ old('applicant_name', auth()->user()->name) }}" required
                       class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 bg-white transition"
                       placeholder="Your full name" />
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                       class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 bg-white transition"
                       placeholder="10-digit mobile" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Work Experience <span class="text-red-500">*</span></label>
                <select name="experience" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 bg-white transition">
                  @foreach(['Fresher','Less than 1 year','1-2 years','2-5 years','5-10 years','10+ years'] as $exp)
                    <option {{ old('experience') == $exp ? 'selected' : '' }}>{{ $exp }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Highest Qualification <span class="text-red-500">*</span></label>
                <select name="qualification" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 bg-white transition">
                  <option value="">Select qualification</option>
                  @foreach(['10th Pass','12th Pass','ITI / Diploma','Graduate (B.A/B.Sc/B.Com)','Graduate (B.Tech/BE)','Post Graduate','PhD'] as $q)
                    <option {{ old('qualification') == $q ? 'selected' : '' }}>{{ $q }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                Upload CV
                <span class="text-gray-400 font-normal">(Optional · PDF/DOC · max 2MB)</span>
              </label>
              <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-primary-300 transition bg-gray-50">
                <input type="file" name="cv" id="cv-input" accept=".pdf,.doc,.docx" class="hidden"
                       onchange="document.getElementById('cv-label').textContent = this.files[0]?.name || 'No file chosen'" />
                <label for="cv-input" class="cursor-pointer">
                  <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                  <p class="text-sm text-gray-500"><span class="font-semibold text-primary-600">Click to upload</span> or drag and drop</p>
                  <p id="cv-label" class="text-xs text-gray-400 mt-1">No file chosen</p>
                </label>
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                Cover Letter
                <span class="text-gray-400 font-normal">(Optional)</span>
              </label>
              <textarea name="cover_letter" rows="4"
                        placeholder="Briefly describe why you are a good fit for this position, your relevant experience, and what you bring to the role…"
                        class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 bg-white transition resize-none">{{ old('cover_letter') }}</textarea>
            </div>

            {{-- Info notice --}}
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
              <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              <p class="text-sm text-blue-700">
                Your application will be reviewed by <strong>{{ $job->department }}</strong>.
                You will receive a reference number after submission.
                @if($job->application_deadline)
                  <span class="block mt-1 text-orange-600 font-semibold">⏰ Apply before {{ \Carbon\Carbon::parse($job->application_deadline)->format('d F Y') }}</span>
                @endif
              </p>
            </div>

            <div class="flex gap-4 pt-2">
              <a href="{{ route('jobs.index') }}"
                 class="flex-1 py-3 rounded-xl border-2 border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition text-sm text-center">
                ← Back to Jobs
              </a>
              <button type="submit"
                      class="flex-[2] py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold transition text-sm shadow-md shadow-primary-200">
                Submit Application →
              </button>
            </div>
          </form>
          @endif

        </div>
      </div>

    </div>
  </div>
</div>
@endsection
