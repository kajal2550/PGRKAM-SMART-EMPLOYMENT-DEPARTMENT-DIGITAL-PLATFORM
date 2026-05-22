@extends('layouts.app')
@section('title', 'My Resume â€“ PGRKAM')

@section('content')
@php
  $user = auth()->user();
  $pFilled = 0;
  foreach (['father_name','dob','gender','category'] as $f) { if (!empty($user->$f)) $pFilled++; }
  $rFilled = 0;
  if ($resume) { foreach (['objective','skills','education','experience','certifications','languages'] as $f) { if (!empty($resume->$f)) $rFilled++; } }
  $completeness = ($pFilled + $rFilled) * 10;
  $barColor = $completeness < 40 ? 'bg-red-500' : ($completeness < 70 ? 'bg-yellow-500' : 'bg-green-500');
@endphp

<div class="pt-16 min-h-screen bg-gray-50 dark:bg-gray-900">

  {{-- Hero --}}
  <div class="bg-gradient-to-br from-blue-800 via-blue-700 to-primary-600 pt-10 pb-24 px-6">
    <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <p class="text-blue-200 text-xs font-semibold uppercase tracking-widest mb-1">Punjab Govt. Rozgar Kendra</p>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">My Resume</h1>
        <p class="text-blue-100 mt-2 text-sm">Complete your profile to get better job matches</p>
      </div>
      <div class="self-start sm:self-auto bg-white/15 backdrop-blur-sm border border-white/25 rounded-2xl px-5 py-3 text-center min-w-[130px]">
        <p class="text-4xl font-black text-white leading-none">{{ $completeness }}%</p>
        <p class="text-blue-100 text-xs mt-1 font-semibold uppercase tracking-wide">Complete</p>
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

    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6" x-data="{ tab: 'personal' }">

      {{-- LEFT: Tabs + Form --}}
      <div class="xl:col-span-3 space-y-5">

        {{-- Completeness bar --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-5">
          <div class="flex items-center justify-between mb-2">
            <p class="text-sm font-bold text-gray-700 dark:text-gray-200">Resume Completeness</p>
            <span class="text-sm font-black {{ $completeness === 100 ? 'text-green-600' : 'text-blue-600' }}">{{ $completeness }}/100</span>
          </div>
          <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 mb-3">
            <div class="{{ $barColor }} h-2.5 rounded-full transition-all" style="width:{{ $completeness }}%"></div>
          </div>
          <div class="flex flex-wrap gap-1.5">
            @foreach(['Father Name'=>!empty($user->father_name),'DOB'=>!empty($user->dob),'Gender'=>!empty($user->gender),'Category'=>!empty($user->category),'Objective'=>$resume&&!empty($resume->objective),'Skills'=>$resume&&!empty($resume->skills),'Education'=>$resume&&!empty($resume->education),'Experience'=>$resume&&!empty($resume->experience),'Certifications'=>$resume&&!empty($resume->certifications),'Languages'=>$resume&&!empty($resume->languages)] as $lbl=>$done)
              <span class="inline-flex items-center gap-1 text-[11px] px-2.5 py-1 rounded-full font-semibold {{ $done ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-400 dark:bg-gray-700 dark:text-gray-500' }}">
                @if($done)<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@else<span class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 inline-block"></span>@endif
                {{ $lbl }}
              </span>
            @endforeach
          </div>
        </div>

        {{-- Tabs --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

          {{-- Tab buttons --}}
          <div class="flex border-b border-gray-100 dark:border-gray-700">
            <button type="button" @click="tab='personal'"
              :class="tab==='personal' ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400 bg-blue-50/60 dark:bg-blue-900/10' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
              class="flex-1 flex items-center justify-center gap-2 py-3.5 px-4 text-sm font-bold transition">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
              Personal Details
            </button>
            <button type="button" @click="tab='professional'"
              :class="tab==='professional' ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400 bg-blue-50/60 dark:bg-blue-900/10' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
              class="flex-1 flex items-center justify-center gap-2 py-3.5 px-4 text-sm font-bold transition">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
              Professional Info
            </button>
          </div>

          <form action="{{ route('resume.save') }}" method="POST">
            @csrf

            {{-- â”€â”€ TAB 1: Personal Details â”€â”€ --}}
            <div x-show="tab==='personal'" class="p-6 space-y-4">

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                  <label class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide">Full Name</label>
                  <input type="text" value="{{ $user->name }}" disabled
                    class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-400 px-4 py-2.5 text-sm cursor-not-allowed" />
                  <p class="text-[11px] text-gray-400 mt-1">Edit from Account Settings</p>
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1.5 uppercase tracking-wide">Father's Name</label>
                  <input type="text" name="father_name" value="{{ old('father_name', $user->father_name ?? '') }}"
                    placeholder="Father's full name"
                    class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1.5 uppercase tracking-wide">Date of Birth</label>
                  <input type="date" name="dob" value="{{ old('dob', $user->dob ?? '') }}"
                    class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1.5 uppercase tracking-wide">Gender</label>
                  <select name="gender"
                    class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    <option value="">Select</option>
                    @foreach(['Male','Female','Other','Prefer not to say'] as $g)
                      <option value="{{ $g }}" {{ old('gender',$user->gender??'') === $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                  </select>
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1.5 uppercase tracking-wide">Category</label>
                  <select name="category"
                    class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    <option value="">Select</option>
                    @foreach(['General','SC','ST','BC','OBC','EWS','Ex-Serviceman','PWD'] as $c)
                      <option value="{{ $c }}" {{ old('category',$user->category??'') === $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                  </select>
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1.5 uppercase tracking-wide">Phone Number</label>
                  <input type="tel" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                    placeholder="10-digit mobile number"
                    class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1.5 uppercase tracking-wide">District</label>
                  <input type="text" name="district" value="{{ old('district', $user->district ?? '') }}"
                    placeholder="e.g. Ludhiana"
                    class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
                </div>

              </div>

              <div>
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-1.5 uppercase tracking-wide">Permanent Address</label>
                <textarea name="address" rows="2" placeholder="House No., Street, City, District, PIN"
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none transition">{{ old('address', $user->address ?? '') }}</textarea>
              </div>

              <div class="flex gap-3 pt-1">
                <button type="submit"
                  class="flex-1 bg-gradient-to-r from-blue-600 to-primary-600 hover:from-blue-700 hover:to-primary-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                  Save
                </button>
                <button type="button" @click="tab='professional'"
                  class="flex-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                  Next: Professional Info
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
              </div>

            </div>

            {{-- â”€â”€ TAB 2: Professional Info â”€â”€ --}}
            <div x-show="tab==='professional'" class="p-6 space-y-5">

              {{-- Career Objective --}}
              <div>
                <label class="flex items-center gap-1.5 text-xs font-bold text-purple-600 dark:text-blue-400 mb-2 uppercase tracking-wide">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                  Career Objective
                </label>
                <textarea name="objective" rows="3" placeholder="Write your career goal in 2-3 sentences..."
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none transition">{{ old('objective', $resume->objective ?? '') }}</textarea>
              </div>

              {{-- Education --}}
              <div>
                <label class="flex items-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400 mb-2 uppercase tracking-wide">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                  Education
                  <span class="text-gray-400 font-normal normal-case tracking-normal ml-1">(one entry per line)</span>
                </label>
                <textarea name="education" rows="4" placeholder="Degree, Institution, Year, Marks"
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 resize-none transition">{{ old('education', $resume->education ?? '') }}</textarea>
              </div>

              {{-- Work Experience --}}
              <div>
                <label class="flex items-center gap-1.5 text-xs font-bold text-orange-600 dark:text-orange-400 mb-2 uppercase tracking-wide">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                  Work Experience
                  <span class="text-gray-400 font-normal normal-case tracking-normal ml-1">(write 'Fresher' if none)</span>
                </label>
                <textarea name="experience" rows="4" placeholder="Job Title, Company, Duration, Key Responsibilities"
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none transition">{{ old('experience', $resume->experience ?? '') }}</textarea>
              </div>

              {{-- Skills --}}
              <div>
                <label class="flex items-center gap-1.5 text-xs font-bold text-blue-600 dark:text-blue-400 mb-2 uppercase tracking-wide">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                  Skills
                  <span class="text-gray-400 font-normal normal-case tracking-normal ml-1">(comma-separated)</span>
                </label>
                <input type="text" name="skills" value="{{ old('skills', $resume->skills ?? '') }}"
                  placeholder="MS Office, Tally, Typing, Communication..."
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
              </div>

              {{-- Certifications --}}
              <div>
                <label class="flex items-center gap-1.5 text-xs font-bold text-yellow-600 dark:text-yellow-400 mb-2 uppercase tracking-wide">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                  Certifications
                  <span class="text-gray-400 font-normal normal-case tracking-normal ml-1">(one per line)</span>
                </label>
                <textarea name="certifications" rows="3" placeholder="Course name, Institute, Year"
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 resize-none transition">{{ old('certifications', $resume->certifications ?? '') }}</textarea>
              </div>

              {{-- Languages --}}
              <div>
                <label class="flex items-center gap-1.5 text-xs font-bold text-pink-600 dark:text-pink-400 mb-2 uppercase tracking-wide">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                  Languages Known
                  <span class="text-gray-400 font-normal normal-case tracking-normal ml-1">(comma-separated)</span>
                </label>
                <input type="text" name="languages" value="{{ old('languages', $resume->languages ?? '') }}"
                  placeholder="Punjabi, Hindi, English"
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-400 transition" />
              </div>

              <div class="flex gap-3 pt-1">
                <button type="button" @click="tab='personal'"
                  class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-bold py-3 px-5 rounded-xl transition flex items-center gap-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                  Back
                </button>
                <button type="submit"
                  class="flex-1 bg-gradient-to-r from-blue-600 to-primary-600 hover:from-blue-700 hover:to-primary-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                  Save Resume
                </button>
              </div>

            </div>

          </form>
        </div>
      </div>

      {{-- RIGHT: CV Preview --}}
      <div class="xl:col-span-2">
        <div class="sticky top-24">
          <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

            <div class="bg-blue-600 px-5 py-2.5 flex items-center justify-between">
              <span class="text-white text-xs font-bold uppercase tracking-widest">CV Preview</span>
              @if($resume && $resume->updated_at)
                <span class="text-blue-200 text-[11px]">Saved {{ \Carbon\Carbon::parse($resume->updated_at)->diffForHumans() }}</span>
              @endif
            </div>

            <div class="p-5 space-y-4">

              {{-- Header --}}
              <div class="border-b-2 border-blue-600 pb-4">
                <div class="flex items-start gap-3 mb-3">
                  <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-primary-600 flex items-center justify-center text-white font-black text-xl flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                  </div>
                  <div>
                    <h3 class="font-black text-gray-900 dark:text-white text-base leading-tight">{{ $user->name }}</h3>
                    @if($user->father_name)
                      <p class="text-gray-500 dark:text-gray-400 text-xs">S/o Â· D/o {{ $user->father_name }}</p>
                    @endif
                    @if($user->dob || $user->gender || $user->category)
                      <p class="text-gray-400 text-xs mt-0.5">
                        {{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('d M Y') : '' }}
                        {{ $user->gender ? ' Â· '.$user->gender : '' }}
                        {{ $user->category ? ' Â· '.$user->category : '' }}
                      </p>
                    @endif
                  </div>
                </div>
                <div class="space-y-1">
                  <div class="flex flex-wrap gap-x-4 gap-y-1">
                    @if($user->phone)
                    <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                      <svg class="w-3 h-3 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                      {{ $user->phone }}
                    </span>
                    @endif
                    <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                      <svg class="w-3 h-3 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                      {{ $user->email }}
                    </span>
                  </div>
                  @if($user->address || $user->district)
                  <p class="text-xs text-gray-500 dark:text-gray-400 flex items-start gap-1">
                    <svg class="w-3 h-3 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    {{ implode(', ', array_filter([$user->address, $user->district, 'Punjab'])) }}
                  </p>
                  @endif
                </div>
              </div>

              @if($resume)

                @if($resume->objective)
                <div>
                  <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1 pb-1 border-b border-gray-100 dark:border-gray-700">Objective</p>
                  <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">{{ $resume->objective }}</p>
                </div>
                @endif

                @if($resume->education)
                <div>
                  <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 pb-1 border-b border-gray-100 dark:border-gray-700">Education</p>
                  @foreach(array_filter(array_map('trim', explode("\n", $resume->education))) as $line)
                    <div class="flex items-start gap-1.5 mb-1">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mt-1.5 flex-shrink-0"></span>
                      <p class="text-xs text-gray-600 dark:text-gray-400">{{ $line }}</p>
                    </div>
                  @endforeach
                </div>
                @endif

                @if($resume->experience)
                <div>
                  <p class="text-[10px] font-black text-orange-600 uppercase tracking-widest mb-1 pb-1 border-b border-gray-100 dark:border-gray-700">Experience</p>
                  @foreach(array_filter(array_map('trim', explode("\n", $resume->experience))) as $line)
                    <div class="flex items-start gap-1.5 mb-1">
                      <span class="w-1.5 h-1.5 rounded-full bg-orange-400 mt-1.5 flex-shrink-0"></span>
                      <p class="text-xs text-gray-600 dark:text-gray-400">{{ $line }}</p>
                    </div>
                  @endforeach
                </div>
                @endif

                @if($resume->skills)
                <div>
                  <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1.5 pb-1 border-b border-gray-100 dark:border-gray-700">Skills</p>
                  <div class="flex flex-wrap gap-1">
                    @foreach(array_slice(explode(',', $resume->skills), 0, 12) as $sk)
                      <span class="text-[11px] bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded-full font-medium">{{ trim($sk) }}</span>
                    @endforeach
                  </div>
                </div>
                @endif

                @if($resume->certifications)
                <div>
                  <p class="text-[10px] font-black text-yellow-600 uppercase tracking-widest mb-1 pb-1 border-b border-gray-100 dark:border-gray-700">Certifications</p>
                  @foreach(array_filter(array_map('trim', explode("\n", $resume->certifications))) as $line)
                    <div class="flex items-start gap-1.5 mb-1">
                      <svg class="w-3 h-3 text-yellow-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                      <p class="text-xs text-gray-600 dark:text-gray-400">{{ $line }}</p>
                    </div>
                  @endforeach
                </div>
                @endif

                @if($resume->languages)
                <div>
                  <p class="text-[10px] font-black text-pink-600 uppercase tracking-widest mb-1.5 pb-1 border-b border-gray-100 dark:border-gray-700">Languages</p>
                  <div class="flex flex-wrap gap-1">
                    @foreach(explode(',', $resume->languages) as $lang)
                      <span class="text-[11px] bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2.5 py-0.5 rounded-full font-medium">{{ trim($lang) }}</span>
                    @endforeach
                  </div>
                </div>
                @endif

              @else
              <div class="py-8 text-center">
                <svg class="w-10 h-10 mx-auto text-gray-200 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="text-xs text-gray-400">Fill the form to see your CV preview</p>
              </div>
              @endif

            </div>

            <div class="mx-5 mb-5 px-4 py-2.5 bg-gray-50 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700 rounded-xl flex items-center justify-between">
              <p class="text-xs text-gray-400 font-medium">Resume Score</p>
              <span class="text-sm font-black px-3 py-1 rounded-full
                {{ $completeness >= 80 ? 'bg-green-100 text-green-700' : ($completeness >= 50 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-600') }}">
                {{ $completeness }}/100
              </span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

