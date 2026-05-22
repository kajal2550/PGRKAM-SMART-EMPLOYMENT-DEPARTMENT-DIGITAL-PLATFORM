@extends('layouts.app')
@section('title', 'Job Applications – Admin')
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
        <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
          <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
          Job Applications
        </h1>
        <p class="text-gray-400 mt-1 text-sm">{{ $applications->total() }} total applications — shortlist, schedule interviews & select candidates</p>
      </div>
      <a href="{{ route('admin.dashboard') }}" class="bg-white/10 border border-white/20 text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-white/20 transition">← Dashboard</a>
    </div>
  </div>

  <div class="max-w-screen-xl mx-auto px-4 md:px-6 -mt-14 pb-16 space-y-5">

    {{-- Status Pipeline --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
      @foreach([
        ['label'=>'Pending',     'status'=>'pending',     'color'=>'bg-yellow-500', 'text'=>'text-yellow-700', 'bg'=>'bg-yellow-50'],
        ['label'=>'Shortlisted', 'status'=>'shortlisted', 'color'=>'bg-blue-500',   'text'=>'text-blue-700',   'bg'=>'bg-blue-50'],
        ['label'=>'Interview',   'status'=>'interview',   'color'=>'bg-purple-500', 'text'=>'text-purple-700', 'bg'=>'bg-purple-50'],
        ['label'=>'Selected',    'status'=>'selected',    'color'=>'bg-emerald-500','text'=>'text-emerald-700','bg'=>'bg-emerald-50'],
        ['label'=>'Rejected',    'status'=>'rejected',    'color'=>'bg-red-500',    'text'=>'text-red-700',    'bg'=>'bg-red-50'],
      ] as $stage)
      <a href="{{ route('admin.applications', ['status' => $stage['status']]) }}"
         class="bg-white dark:bg-gray-800 rounded-2xl border {{ request('status') == $stage['status'] ? 'border-2 border-primary-400 shadow-lg' : 'border-gray-100 dark:border-gray-700' }} shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all p-4 text-center">
        <div class="w-3 h-3 rounded-full {{ $stage['color'] }} mx-auto mb-2"></div>
        <p class="text-sm font-bold {{ $stage['text'] }}">{{ $stage['label'] }}</p>
      </a>
      @endforeach
    </div>

    {{-- Filter + Search --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-4">
      <form method="GET" class="flex flex-col sm:flex-row gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by applicant name or job title..."
          class="flex-1 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"/>
        <select name="status" class="rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400">
          <option value="all">All Status</option>
          @foreach(['pending','shortlisted','interview','selected','rejected'] as $s)
            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
        <button class="bg-primary-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-700 transition">Filter</button>
        @if(request('search') || request('status'))
          <a href="{{ route('admin.applications') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">Clear</a>
        @endif
      </form>
    </div>

    {{-- Applications Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr style="background:#1e293b;">
              <th class="text-left px-5 py-3.5 text-xs font-bold text-gray-300 uppercase tracking-wide">Applicant</th>
              <th class="text-left px-5 py-3.5 text-xs font-bold text-gray-300 uppercase tracking-wide">Job Applied</th>
              <th class="text-left px-5 py-3.5 text-xs font-bold text-gray-300 uppercase tracking-wide">Reference</th>
              <th class="text-left px-5 py-3.5 text-xs font-bold text-gray-300 uppercase tracking-wide">Applied</th>
              <th class="text-left px-5 py-3.5 text-xs font-bold text-gray-300 uppercase tracking-wide">Current Status</th>
              <th class="text-left px-5 py-3.5 text-xs font-bold text-gray-300 uppercase tracking-wide">Update Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
            @forelse($applications as $app)
            @php
              $sc = match($app->status) {
                'shortlisted' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                'interview'   => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                'selected'    => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                'rejected'    => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                default       => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
              };
            @endphp
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
              <td class="px-5 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-600 to-blue-400 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr($app->user_name, 0, 1)) }}
                  </div>
                  <div>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $app->user_name }}</p>
                    <p class="text-xs text-gray-400">{{ $app->user_email }}</p>
                  </div>
                </div>
              </td>
              <td class="px-5 py-4">
                <p class="font-medium text-gray-700 dark:text-gray-300">{{ $app->job_title }}</p>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full {{ $app->job_type === 'government' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                  {{ ucfirst($app->job_type) }}
                </span>
              </td>
              <td class="px-5 py-4 text-xs font-mono text-gray-500 dark:text-gray-400">{{ $app->application_ref ?? '—' }}</td>
              <td class="px-5 py-4 text-xs text-gray-400">{{ \Carbon\Carbon::parse($app->created_at)->format('d M Y') }}</td>
              <td class="px-5 py-4">
                <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $sc }}">{{ ucfirst($app->status) }}</span>
              </td>
              <td class="px-5 py-4">
                <form action="{{ route('admin.applications.status', $app->id) }}" method="POST" class="flex items-center gap-2">
                  @csrf
                  <select name="status" class="rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-2.5 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary-400">
                    @foreach(['pending','shortlisted','interview','selected','rejected'] as $opt)
                      <option value="{{ $opt }}" {{ $app->status == $opt ? 'selected' : '' }}>{{ ucfirst($opt) }}</option>
                    @endforeach
                  </select>
                  <button class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition whitespace-nowrap">
                    Update
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="px-5 py-16 text-center">
                <div class="w-14 h-14 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mx-auto mb-3">
                  <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <p class="text-gray-500 dark:text-gray-400 font-semibold">No applications found</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="p-5 border-t border-gray-100 dark:border-gray-700">{{ $applications->links() }}</div>
    </div>

  </div>
</div>
@endsection
