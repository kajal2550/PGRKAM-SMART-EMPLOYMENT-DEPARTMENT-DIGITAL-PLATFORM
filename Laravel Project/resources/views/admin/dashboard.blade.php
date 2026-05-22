@extends('layouts.app')
@section('title', 'Admin Dashboard – PGRKAM')

@section('content')
<div class="pt-16 min-h-screen bg-gray-100 dark:bg-gray-900">

  {{-- Hero --}}
  <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #111827 100%); border-bottom: 4px solid #f97316;" class="pt-10 pb-24 px-6">
    <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <p class="text-orange-400 text-xs font-semibold uppercase tracking-widest mb-2 flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
          Admin Panel · PGRKAM
        </p>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight flex items-center gap-3">
          <svg class="w-9 h-9 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
          </svg>
          Admin Dashboard
        </h1>
        <p class="text-gray-400 mt-2 text-sm">Manage users, jobs, applications & counselling sessions</p>
      </div>
      <div class="flex gap-3 flex-wrap">
        <a href="{{ route('admin.jobs.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold px-5 py-2.5 rounded-xl flex items-center gap-2 transition shadow-lg">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          Add Job
        </a>
        <a href="{{ route('admin.applications') }}" class="bg-white/10 hover:bg-white/20 text-white text-sm font-bold px-5 py-2.5 rounded-xl flex items-center gap-2 transition border border-white/20">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
          Applications
        </a>
      </div>
    </div>
  </div>

  <div class="max-w-screen-xl mx-auto px-4 md:px-6 -mt-14 pb-16 space-y-5">

    {{-- Top Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      @foreach([
        ['label'=>'Total Users',        'value'=>$stats['total_users'],        'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'ibg'=>'bg-blue-100 dark:bg-blue-900/30',   'ic'=>'text-blue-600',   'vc'=>'text-blue-700 dark:text-blue-400',   'link'=>route('admin.users')],
        ['label'=>'Active Jobs',         'value'=>$stats['active_jobs'],        'icon'=>'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2', 'ibg'=>'bg-emerald-100 dark:bg-emerald-900/30','ic'=>'text-emerald-600','vc'=>'text-emerald-700 dark:text-emerald-400','link'=>route('admin.jobs')],
        ['label'=>'Applications',        'value'=>$stats['total_applications'], 'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'ibg'=>'bg-purple-100 dark:bg-purple-900/30', 'ic'=>'text-purple-600', 'vc'=>'text-purple-700 dark:text-purple-400', 'link'=>route('admin.applications')],
        ['label'=>'Pending Counselling', 'value'=>$stats['pending_counselling'],'icon'=>'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'ibg'=>'bg-orange-100 dark:bg-orange-900/30', 'ic'=>'text-orange-600', 'vc'=>'text-orange-700 dark:text-orange-400', 'link'=>route('admin.counselling')],
      ] as $s)
      <a href="{{ $s['link'] }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl {{ $s['ibg'] }} flex items-center justify-center flex-shrink-0">
          <svg class="w-6 h-6 {{ $s['ic'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"/></svg>
        </div>
        <div>
          <p class="text-2xl font-black {{ $s['vc'] }}">{{ $s['value'] }}</p>
          <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5">{{ $s['label'] }}</p>
        </div>
      </a>
      @endforeach
    </div>

    {{-- Second row --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      @foreach([
        ['label'=>'Total Jobs',       'value'=>$stats['total_jobs'],        'color'=>'text-gray-800 dark:text-white'],
        ['label'=>'Trainings',        'value'=>$stats['total_trainings'],   'color'=>'text-gray-800 dark:text-white'],
        ['label'=>'Enrollments',      'value'=>$stats['total_enrollments'], 'color'=>'text-gray-800 dark:text-white'],
        ['label'=>'Total Counselling','value'=>$stats['total_counselling'], 'color'=>'text-gray-800 dark:text-white'],
      ] as $s)
      <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-4 text-center">
        <p class="text-3xl font-black {{ $s['color'] }}">{{ $s['value'] }}</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">{{ $s['label'] }}</p>
      </div>
      @endforeach
    </div>

    {{-- Recent Users + Recent Applications --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

      {{-- Recent Users --}}
      <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-5 py-3.5 flex items-center justify-between" style="background:#ea580c;">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-orange-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="text-white text-sm font-bold">Recent Registrations</span>
          </div>
          <a href="{{ route('admin.users') }}" class="text-orange-200 text-xs hover:text-white transition font-semibold">View all →</a>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-gray-700">
          @forelse($recentUsers as $u)
          <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-600 to-blue-400 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
              {{ strtoupper(substr($u->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ $u->name }}</p>
              <p class="text-xs text-gray-400 truncate">{{ $u->email }}</p>
            </div>
            <span class="text-[11px] text-gray-400 whitespace-nowrap">{{ $u->created_at->diffForHumans() }}</span>
          </div>
          @empty
          <div class="p-10 text-center text-gray-400 text-sm">No users yet</div>
          @endforelse
        </div>
      </div>

      {{-- Recent Applications --}}
      <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-5 py-3.5 flex items-center justify-between" style="background:#059669;">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            <span class="text-white text-sm font-bold">Recent Applications</span>
          </div>
          <a href="{{ route('admin.applications') }}" class="text-emerald-200 text-xs hover:text-white transition font-semibold">View all →</a>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-gray-700">
          @forelse($recentApps as $app)
          <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
            <div class="w-9 h-9 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-700 font-bold text-sm flex-shrink-0">
              {{ strtoupper(substr($app->user_name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ $app->user_name }}</p>
              <p class="text-xs text-gray-400 truncate">{{ $app->job_title }}</p>
            </div>
            @php
              $sc = match($app->status) {
                'shortlisted' => 'bg-blue-100 text-blue-700',
                'interview'   => 'bg-purple-100 text-purple-700',
                'selected'    => 'bg-emerald-100 text-emerald-700',
                'rejected'    => 'bg-red-100 text-red-700',
                default       => 'bg-yellow-100 text-yellow-700',
              };
            @endphp
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $sc }} whitespace-nowrap">{{ ucfirst($app->status) }}</span>
          </div>
          @empty
          <div class="p-10 text-center text-gray-400 text-sm">No applications yet</div>
          @endforelse
        </div>
      </div>

    </div>

    {{-- Quick Nav --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
      @foreach([
        ['label'=>'Users',        'route'=>route('admin.users'),        'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color'=>'#2563eb'],
        ['label'=>'Jobs',         'route'=>route('admin.jobs'),         'icon'=>'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2', 'color'=>'#059669'],
        ['label'=>'Trainings',    'route'=>route('admin.trainings'),    'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color'=>'#7c3aed'],
        ['label'=>'Applications', 'route'=>route('admin.applications'), 'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'color'=>'#ea580c'],
        ['label'=>'Counselling',  'route'=>route('admin.counselling'),  'icon'=>'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'color'=>'#db2777'],
      ] as $link)
      <a href="{{ $link['route'] }}" style="background:{{ $link['color'] }};"
         class="hover:opacity-90 text-white rounded-2xl p-4 flex flex-col items-center gap-2 transition shadow-sm hover:shadow-lg hover:-translate-y-0.5">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/>
        </svg>
        <span class="text-xs font-bold">{{ $link['label'] }}</span>
      </a>
      @endforeach
    </div>

  </div>
</div>
@endsection
