@extends('layouts.app')
@section('title', 'My Profile – PGRKAM')

@section('content')
<div class="pt-16 min-h-screen bg-gray-50 dark:bg-gray-900">

  {{-- ═══════════════════════ HERO ═══════════════════════ --}}
  <div class="bg-gradient-to-br from-primary-800 via-primary-700 to-blue-600 pt-10 pb-24 px-6">
    <div class="max-w-screen-xl mx-auto">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
          <p class="text-blue-200 text-xs font-semibold uppercase tracking-widest mb-1">Punjab Govt. Rozgar Kendra</p>
          <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight flex items-center gap-3">
            <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            My Profile
          </h1>
          <p class="text-blue-100 mt-2 text-sm">Keep your information up to date</p>
        </div>

        {{-- Hero stat cards --}}
        <div class="flex gap-3 flex-wrap">
          <div class="bg-white/15 backdrop-blur-sm border border-white/25 rounded-2xl px-5 py-3 text-center min-w-[90px]">
            <p class="text-lg font-black text-white leading-none">{{ $user->name }}</p>
            <p class="text-blue-100 text-xs mt-0.5 font-semibold">Name</p>
          </div>
          <div class="bg-white/15 backdrop-blur-sm border border-white/25 rounded-2xl px-5 py-3 text-center min-w-[90px]">
            <p class="text-lg font-black text-white leading-none capitalize">{{ $user->gender ?? '—' }}</p>
            <p class="text-blue-100 text-xs mt-0.5 font-semibold">Gender</p>
          </div>
          <div class="bg-emerald-400/30 backdrop-blur-sm border border-emerald-300/40 rounded-2xl px-5 py-3 text-center min-w-[90px]">
            <p class="text-lg font-black text-white leading-none">{{ $user->created_at->format('M Y') }}</p>
            <p class="text-emerald-100 text-xs mt-0.5 font-semibold">Member Since</p>
          </div>
        </div>

      </div>
    </div>
  </div>

  {{-- ═══════════════════════ MAIN ═══════════════════════ --}}
  <div class="max-w-screen-xl mx-auto px-4 md:px-6 -mt-14 pb-16">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

      {{-- ─────────── LEFT: Avatar Card ─────────── --}}
      <div class="lg:col-span-2">
        <div class="sticky top-24 space-y-4">

          {{-- Avatar Card --}}
          <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            {{-- Card header bar --}}
            <div class="bg-primary-700 px-5 py-3.5 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-white text-sm font-bold">Account Overview</span>
              </div>
              <span class="bg-emerald-400/30 text-emerald-100 text-xs font-bold px-2.5 py-1 rounded-full border border-emerald-300/40">Active</span>
            </div>

            <div class="p-6 flex flex-col items-center text-center">
              {{-- Avatar --}}
              <div class="relative mb-4">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-600 to-blue-400 flex items-center justify-center text-white text-4xl font-extrabold shadow-lg shadow-primary-200/50 dark:shadow-none">
                  {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="absolute bottom-0 right-0 w-6 h-6 bg-emerald-400 rounded-full border-2 border-white dark:border-gray-800 flex items-center justify-center">
                  <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                  </svg>
                </div>
              </div>

              <p class="font-extrabold text-gray-900 dark:text-white text-xl">{{ $user->name }}</p>
              <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ $user->email }}</p>

              @if($user->district)
                <span class="mt-3 inline-flex items-center gap-1 text-xs font-semibold bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 px-3 py-1 rounded-full border border-primary-100 dark:border-primary-800">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  </svg>
                  {{ $user->district }}
                </span>
              @endif
            </div>

            {{-- Info rows --}}
            <div class="border-t border-gray-100 dark:border-gray-700 divide-y divide-gray-50 dark:divide-gray-700">
              @foreach([
                ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'label' => 'Phone', 'value' => $user->phone ?? '—'],
                ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'Date of Birth', 'value' => $user->dob ? \Carbon\Carbon::parse($user->dob)->format('d M Y') : '—'],
                ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'label' => 'Gender', 'value' => $user->gender ?? '—'],
              ] as $info)
              <div class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
                <div class="w-8 h-8 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center flex-shrink-0">
                  <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $info['icon'] }}"/>
                  </svg>
                </div>
                <div>
                  <p class="text-[11px] text-gray-400 dark:text-gray-500 font-medium">{{ $info['label'] }}</p>
                  <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $info['value'] }}</p>
                </div>
              </div>
              @endforeach

              <div class="px-6 py-3">
                <p class="text-[11px] text-gray-400 dark:text-gray-500 flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Member since {{ $user->created_at->format('d M Y') }}
                </p>
              </div>
            </div>
          </div>

          {{-- Quick tip --}}
          <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-2xl p-4 flex items-start gap-3">
            <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
              <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
              Keep your profile <strong class="text-emerald-700 dark:text-emerald-400">complete and up to date</strong> to get better job matches and training recommendations.
            </p>
          </div>

        </div>
      </div>

      {{-- ─────────── RIGHT: Forms ─────────── --}}
      <div class="lg:col-span-3 space-y-5">

        {{-- Personal Information --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-primary-50/50 dark:bg-primary-900/10 flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
              <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <div>
              <h2 class="font-bold text-gray-800 dark:text-gray-100 text-sm">Personal Information</h2>
              <p class="text-xs text-gray-400">Update your basic details</p>
            </div>
          </div>

          <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 transition placeholder-gray-400" />
                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Phone</label>
                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 transition placeholder-gray-400"
                  placeholder="e.g. 9876543210" />
                @error('phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Date of Birth</label>
                <input type="date" name="dob" value="{{ old('dob', $user->dob) }}"
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 transition" />
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Gender</label>
                <select name="gender"
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 transition">
                  <option value="">Select gender</option>
                  @foreach(['Male','Female','Other'] as $g)
                    <option {{ old('gender', $user->gender) == $g ? 'selected' : '' }}>{{ $g }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">District</label>
              <select name="district"
                class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 transition">
                <option value="">Select district</option>
                @foreach(['Amritsar','Barnala','Bathinda','Faridkot','Fatehgarh Sahib','Fazilka','Ferozepur','Gurdaspur','Hoshiarpur','Jalandhar','Kapurthala','Ludhiana','Mansa','Moga','Mohali (SAS Nagar)','Muktsar','Nawanshahr','Pathankot','Patiala','Rupnagar','Sangrur','Tarn Taran'] as $d)
                  <option {{ old('district', $user->district) == $d ? 'selected' : '' }}>{{ $d }}</option>
                @endforeach
              </select>
            </div>

            <button type="submit"
              class="w-full bg-gradient-to-r from-primary-700 to-blue-600 hover:from-primary-800 hover:to-blue-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-primary-200/50 dark:shadow-none flex items-center justify-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
              Save Changes
            </button>
          </form>
        </div>

        {{-- Change Password --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-orange-50/50 dark:bg-orange-900/10 flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
              <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </div>
            <div>
              <h2 class="font-bold text-gray-800 dark:text-gray-100 text-sm">Change Password</h2>
              <p class="text-xs text-gray-400">Keep your account secure</p>
            </div>
          </div>

          <form action="{{ route('profile.password') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div>
              <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Current Password <span class="text-red-500">*</span></label>
              <input type="password" name="current_password" required
                class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 transition"
                placeholder="Enter current password" />
              @error('current_password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">New Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 transition"
                  placeholder="Min. 8 characters" />
                @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Confirm Password <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" required
                  class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 transition"
                  placeholder="Repeat new password" />
              </div>
            </div>

            {{-- Security notice --}}
            <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-100 dark:border-orange-800 rounded-xl p-3.5 flex items-start gap-3">
              <div class="w-7 h-7 bg-orange-100 dark:bg-orange-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-3.5 h-3.5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
              </div>
              <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                Use a <strong class="text-orange-700 dark:text-orange-400">strong password</strong> with at least 8 characters, including numbers and symbols.
              </p>
            </div>

            <button type="submit"
              class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-orange-200/50 dark:shadow-none flex items-center justify-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
              Update Password
            </button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
