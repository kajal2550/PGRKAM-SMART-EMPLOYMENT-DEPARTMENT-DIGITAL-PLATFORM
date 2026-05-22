@extends('layouts.app')
@section('title', 'Create Account – PGRKAM')

@section('content')
<div class="min-h-screen flex" style="margin-top:-64px;padding-top:0">

  {{-- Left Panel --}}
  <div class="hidden lg:flex lg:w-1/2 bg-gradient-primary flex-col items-center justify-center p-12 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-400/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
    <div class="relative z-10 text-center max-w-sm">
      <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/>
        </svg>
      </div>
      <h1 class="text-3xl font-extrabold text-white mb-2">PGRKAM</h1>
      <p class="text-primary-200 text-sm mb-8">Employment Portal</p>
      <h2 class="text-xl font-bold text-white mb-3">Join Punjab's Smart Employment Network</h2>
      <p class="text-primary-200 text-sm leading-relaxed">Register today and get access to thousands of job opportunities, skill training, and career guidance — completely free.</p>
      <ul class="mt-6 space-y-3 text-left">
        @foreach(['Free access to all employment services','Personalized job recommendations','Government-verified opportunities','Direct application tracking'] as $b)
        <li class="flex items-center gap-2 text-primary-100 text-sm">
          <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          {{ $b }}
        </li>
        @endforeach
      </ul>
    </div>
    <p class="absolute bottom-6 text-primary-300 text-xs">© {{ date('Y') }} Government of Punjab</p>
  </div>

  {{-- Right Panel --}}
  <div class="flex-1 bg-gray-50 flex items-center justify-center p-6 sm:p-12 overflow-y-auto">
    <div class="w-full max-w-md py-8">
      <div class="flex items-center gap-2 mb-8 lg:hidden">
        <div class="w-9 h-9 bg-gradient-to-br from-primary-700 to-blue-500 rounded-xl flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/></svg>
        </div>
        <span class="font-bold text-gray-900">PGRKAM</span>
      </div>

      <div class="glass-card p-8">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Create Account</h2>
        <p class="text-gray-500 text-sm mb-6">Fill in your details to get started</p>

        @if($errors->any())
          <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600">
            {{ $errors->first() }}
          </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
          @csrf
          {{-- Full Name --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
            <div class="relative">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
              <input type="text" name="name" value="{{ old('name') }}" required placeholder="Your full name"
                     class="input-field pl-10" />
            </div>
          </div>
          {{-- Email --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
            <div class="relative">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
              <input type="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com"
                     class="input-field pl-10" />
            </div>
          </div>
          {{-- Phone --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
            <div class="relative">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
              <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="10-digit mobile number"
                     class="input-field pl-10" />
            </div>
          </div>
          {{-- Password --}}
          <div x-data="{ show: false }">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
            <div class="relative">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
              <input :type="show ? 'text' : 'password'" name="password" required placeholder="Min. 8 characters"
                     class="input-field pl-10 pr-10" />
              <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
              </button>
            </div>
          </div>
          {{-- Confirm Password --}}
          <div x-data="{ show2: false }">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
            <div class="relative">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
              <input :type="show2 ? 'text' : 'password'" name="password_confirmation" required placeholder="Repeat password"
                     class="input-field pl-10 pr-10" />
              <button type="button" @click="show2 = !show2" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg x-show="!show2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <svg x-show="show2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
              </button>
            </div>
          </div>

          {{-- Terms --}}
          <label class="flex items-start gap-2 cursor-pointer">
            <input type="checkbox" name="agree" value="1" class="w-4 h-4 mt-0.5 rounded border-gray-300 text-primary-600 flex-shrink-0" />
            <span class="text-xs text-gray-500">I agree to the <a href="#" class="text-primary-600 hover:underline">Terms of Service</a> and <a href="#" class="text-primary-600 hover:underline">Privacy Policy</a></span>
          </label>

          <button type="submit" class="btn-primary w-full justify-center mt-2">
            Create Account
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
          Already have an account?
          <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-semibold">Sign In</a>
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
