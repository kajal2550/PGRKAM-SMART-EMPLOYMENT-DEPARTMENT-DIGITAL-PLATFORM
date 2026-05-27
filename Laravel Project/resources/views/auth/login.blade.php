@extends('layouts.app')
@section('title', 'Sign In – PGRKAM')

@section('content')
<div class="min-h-screen flex" style="padding-top:64px">

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
      <h2 class="text-xl font-bold text-white mb-3">Welcome back to Punjab's #1 Employment Portal</h2>
      <p class="text-primary-200 text-sm leading-relaxed">Access thousands of job listings, training programs, and career guidance — all in one place.</p>
      <div class="mt-10 flex justify-center gap-6 text-center">
        <div>
          <p class="text-2xl font-extrabold text-white">50K+</p>
          <p class="text-primary-300 text-xs">Jobs Listed</p>
        </div>
        <div class="w-px bg-white/20"></div>
        <div>
          <p class="text-2xl font-extrabold text-white">200+</p>
          <p class="text-primary-300 text-xs">Training Programs</p>
        </div>
        <div class="w-px bg-white/20"></div>
        <div>
          <p class="text-2xl font-extrabold text-white">22</p>
          <p class="text-primary-300 text-xs">Districts</p>
        </div>
      </div>
    </div>
    <p class="absolute bottom-6 text-primary-300 text-xs">© {{ date('Y') }} Government of Punjab</p>
  </div>

  {{-- Right Panel --}}
  <div class="flex-1 bg-gray-50 flex items-center justify-center p-6 sm:p-12">
    <div class="w-full max-w-md">
      {{-- Mobile logo --}}
      <div class="flex items-center gap-2 mb-8 lg:hidden">
        <div class="w-9 h-9 bg-gradient-to-br from-primary-700 to-blue-500 rounded-xl flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/></svg>
        </div>
        <span class="font-bold text-gray-900">PGRKAM</span>
      </div>

      <div class="glass-card p-8">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Sign In</h2>
        <p class="text-gray-500 text-sm mb-6">Enter your credentials to access your account</p>

        @if($errors->any())
          <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600">
            {{ $errors->first() }}
          </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
          @csrf
          {{-- Email --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
            <div class="relative">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
              <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                     placeholder="your@email.com"
                     class="input-field pl-10" />
            </div>
          </div>
          {{-- Password --}}
          <div x-data="{ show: false }">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
            <div class="relative">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
              <input :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                     placeholder="Your password"
                     class="input-field pl-10 pr-10" />
              <button type="button" @click="show = !show"
                      class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
              </button>
            </div>
          </div>

          <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 text-gray-600 cursor-pointer">
              <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-primary-600" />
              Remember me
            </label>
          </div>

          <button type="submit" class="btn-primary w-full justify-center mt-2">
            Sign In
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
          Don't have an account?
          <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-semibold">Create Account</a>
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
