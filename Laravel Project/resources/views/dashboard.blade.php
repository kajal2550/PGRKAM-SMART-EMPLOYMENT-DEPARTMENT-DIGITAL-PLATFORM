@extends('layouts.app')
@section('title', 'Dashboard – PGRKAM')

@section('content')
@php
  $hour = (int) now()->format('H');
  $greeting = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');
  $resumeDone = $user->resume_headline || $user->skills;
  $quickActions = [
    ['label'=>'Find Jobs',       'link'=>route('jobs.index'),        'icon'=>'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2','bg'=>'bg-primary-100','text'=>'text-primary-700'],
    ['label'=>'Skill Training',  'link'=>route('training.index'),    'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253','bg'=>'bg-blue-100','text'=>'text-blue-700'],
    ['label'=>'Update Resume',   'link'=>route('resume'),            'icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z','bg'=>'bg-primary-100','text'=>'text-primary-700'],
    ['label'=>'Counselling',     'link'=>route('counselling'),       'icon'=>'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z','bg'=>'bg-blue-100','text'=>'text-blue-700'],
    ['label'=>'My Applications', 'link'=>route('applications'),      'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4','bg'=>'bg-primary-100','text'=>'text-primary-700'],
    ['label'=>'Saved Jobs',      'link'=>route('saved-jobs'),        'icon'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z','bg'=>'bg-blue-100','text'=>'text-blue-700'],
    ['label'=>'My Enrollments',  'link'=>route('enrollments'),       'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','bg'=>'bg-primary-100','text'=>'text-primary-700'],
    ['label'=>'Services',        'link'=>route('services.index'),    'icon'=>'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10','bg'=>'bg-blue-100','text'=>'text-blue-700'],
  ];
@endphp

{{-- Hero Banner --}}
<section class="relative overflow-hidden"
         style="background-image:url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1400&q=80&auto=format&fit=crop');background-size:cover;background-position:center">
  <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/85 to-primary-700/80"></div>
  <div class="relative z-10 max-w-screen-xl mx-auto px-6 py-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
      <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-2xl bg-white/20 border-2 border-white/30 flex items-center justify-center text-white text-2xl font-extrabold">
          {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
          <p class="text-primary-200 text-sm">{{ $greeting }} 👋</p>
          <h1 class="text-2xl font-extrabold text-white">{{ $user->name }}</h1>
          <p class="text-primary-200 text-sm">{{ $user->email }}
            @if($user->district) · {{ $user->district }} @endif
          </p>
        </div>
      </div>
      <div class="flex gap-3">
        <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-primary-700 rounded-xl font-semibold text-sm hover:bg-blue-50 transition shadow">
          Browse Jobs
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
        <a href="{{ route('training.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 border border-white/30 text-white rounded-xl font-semibold text-sm hover:bg-white/20 transition">
          Trainings
        </a>
      </div>
    </div>
  </div>
</section>

{{-- Main Dashboard --}}
<div class="max-w-screen-xl mx-auto px-6 py-8">

  {{-- Stats Cards --}}
  <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
    <a href="{{ route('applications') }}" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all text-left group">
      <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center mb-3">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
      </div>
      <p class="text-2xl font-extrabold text-gray-900">{{ $stats['applications'] }}</p>
      <p class="text-xs text-gray-500 mt-0.5 font-medium">Jobs Applied</p>
      <p class="text-xs text-primary-600 mt-2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
        View details <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </p>
    </a>
    <a href="{{ route('saved-jobs') }}" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all text-left group">
      <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center mb-3">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
      </div>
      <p class="text-2xl font-extrabold text-gray-900">{{ $stats['savedJobs'] }}</p>
      <p class="text-xs text-gray-500 mt-0.5 font-medium">Saved Jobs</p>
      <p class="text-xs text-primary-600 mt-2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
        View details <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </p>
    </a>
    <a href="{{ route('enrollments') }}" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all text-left group">
      <div class="w-10 h-10 bg-primary-700 rounded-xl flex items-center justify-center mb-3">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
      </div>
      <p class="text-2xl font-extrabold text-gray-900">{{ $stats['enrollments'] }}</p>
      <p class="text-xs text-gray-500 mt-0.5 font-medium">Trainings Enrolled</p>
      <p class="text-xs text-primary-600 mt-2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
        View details <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </p>
    </a>
    <a href="{{ route('resume') }}" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all text-left group">
      <div class="w-10 h-10 {{ $resumeDone ? 'bg-primary-800' : 'bg-orange-500' }} rounded-xl flex items-center justify-center mb-3">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
      </div>
      <p class="text-2xl font-extrabold text-gray-900">{{ $resumeDone ? 'Done ✓' : 'Pending' }}</p>
      <p class="text-xs text-gray-500 mt-0.5 font-medium">Resume</p>
      <p class="text-xs text-primary-600 mt-2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
        View details <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </p>
    </a>
  </div>

  {{-- Two-column layout --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left 2/3 --}}
    <div class="lg:col-span-2 space-y-6">

      {{-- Recent Job Openings --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
              <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/></svg>
            </div>
            <h2 class="font-bold text-gray-900">Latest Job Openings</h2>
          </div>
          <a href="{{ route('jobs.index') }}" class="text-xs text-primary-600 font-semibold hover:text-primary-700">View All →</a>
        </div>
        <div class="divide-y divide-gray-50">
        @forelse($recentJobs as $job)
        <a href="{{ route('jobs.index') }}" class="flex items-center gap-4 px-6 py-3.5 hover:bg-primary-50/50 transition group">
          <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/></svg>
          </div>
          <div class="flex-1 min-w-0">
            <p class="font-semibold text-gray-800 text-sm group-hover:text-primary-700 truncate">{{ $job->title }}</p>
            <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
              <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              {{ $job->department }}@if($job->location) · {{ $job->location }}@endif
            </p>
          </div>
          <div class="text-right flex-shrink-0 space-y-1">
            @if($job->salary_range)
              <p class="text-xs font-semibold text-gray-600">{{ $job->salary_range }}</p>
            @endif
            @if($job->type)
              <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded-full {{ $job->type === 'government' ? 'bg-primary-100 text-primary-700' : 'bg-blue-50 text-blue-600' }}">
                {{ $job->type === 'government' ? 'Govt' : 'Private' }}
              </span>
            @endif
          </div>
        </a>
        @empty
        <div class="px-6 py-8 text-center text-gray-400 text-sm">No jobs available yet.</div>
        @endforelse
        </div>
      </div>

      {{-- Quick Actions --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
          <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
          Quick Actions
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          @foreach($quickActions as $action)
          <a href="{{ $action['link'] }}" class="flex flex-col items-center gap-2 p-4 rounded-2xl border border-gray-100 hover:border-primary-300 hover:shadow-md transition-all group text-center">
            <div class="w-10 h-10 {{ $action['bg'] }} rounded-xl flex items-center justify-center">
              <svg class="w-5 h-5 {{ $action['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"/></svg>
            </div>
            <span class="text-xs font-semibold text-gray-600 group-hover:text-primary-700 leading-tight">{{ $action['label'] }}</span>
          </a>
          @endforeach
        </div>
      </div>
    </div>

    {{-- Right 1/3 --}}
    <div class="space-y-5">

      {{-- Profile Card --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-primary-600 to-primary-800 px-6 py-5 text-center">
          <div class="w-16 h-16 rounded-2xl bg-white/20 border-2 border-white/40 flex items-center justify-center text-white text-2xl font-extrabold mx-auto mb-2">
            {{ strtoupper(substr($user->name, 0, 1)) }}
          </div>
          <p class="font-bold text-white">{{ $user->name }}</p>
          <p class="text-white/70 text-xs mt-0.5">{{ $user->email }}</p>
          <span class="inline-block mt-2 bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">Active</span>
        </div>
        <div class="px-6 py-4 space-y-3 text-sm">
          <div class="flex justify-between">
            <span class="text-gray-500">District</span>
            <span class="font-medium text-gray-800">{{ $user->district ?? 'Not set' }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-500">Resume</span>
            @if($resumeDone)
              <span class="text-green-600 font-medium">✓ Complete</span>
            @else
              <span class="text-orange-500 font-medium">Pending</span>
            @endif
          </div>
          <div class="flex justify-between">
            <span class="text-gray-500">Enrollments</span>
            <span class="font-medium text-gray-800">{{ $stats['enrollments'] }}</span>
          </div>
          <a href="{{ route('resume') }}" class="w-full mt-2 flex items-center justify-center gap-2 border-2 border-primary-200 text-primary-700 font-semibold py-2.5 rounded-xl hover:bg-primary-50 transition text-sm">
            Update Resume
          </a>
        </div>
      </div>

      {{-- Notifications --}}
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-orange-100 rounded-xl flex items-center justify-center">
              <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <h3 class="font-bold text-gray-900 text-sm">Notifications</h3>
          </div>
          @php $unreadCount = $notifications->where('is_read', false)->count(); @endphp
          @if($unreadCount > 0)
          <span class="bg-primary-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
          @endif
        </div>
        <div class="divide-y divide-gray-50 max-h-72 overflow-y-auto">
        @forelse($notifications->take(4) as $notif)
        <div class="flex items-start gap-3 px-5 py-3 {{ $notif->is_read ? '' : 'bg-blue-50/60' }}">
          <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 {{ $notif->is_read ? 'bg-gray-100' : 'bg-primary-100' }}">
            @if($notif->type === 'job')
              <svg class="w-3.5 h-3.5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/></svg>
            @elseif($notif->type === 'training')
              <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            @elseif($notif->type === 'alert')
              <svg class="w-3.5 h-3.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            @else
              <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @endif
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-xs leading-relaxed {{ $notif->is_read ? 'text-gray-500' : 'text-gray-800 font-medium' }}">{{ $notif->message }}</p>
            @if(!$notif->is_read)
            <div class="w-1.5 h-1.5 bg-primary-500 rounded-full mt-1"></div>
            @endif
          </div>
        </div>
        @empty
        <div class="px-5 py-6 text-center text-gray-400 text-xs">No notifications yet.</div>
        @endforelse
        </div>
      </div>

      {{-- Pro Tip --}}
      <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-5 text-white">
        <div class="flex items-center gap-2 mb-2">
          <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          <p class="font-bold text-sm">Pro Tip</p>
        </div>
        <p class="text-white/80 text-xs leading-relaxed">Apply to jobs <strong class="text-white">at least 7 days</strong> before the deadline. Early applicants get shortlisted faster!</p>
        <a href="{{ route('jobs.index') }}" class="mt-3 flex items-center gap-1 text-xs font-semibold text-white/90 hover:text-white transition">
          Browse open jobs
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
      </div>
    </div>
  </div>
</div>

@endsection
