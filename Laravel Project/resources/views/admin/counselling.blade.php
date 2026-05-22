@extends('layouts.app')
@section('title', 'Counselling Sessions – Admin')
@section('content')
<div class="pt-16 min-h-screen bg-gray-50 dark:bg-gray-900">
  <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-gray-900 pt-10 pb-24 px-6">
    <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <p class="text-orange-400 text-xs font-semibold uppercase tracking-widest mb-1">Admin Panel</p>
        <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
          <svg class="w-7 h-7 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
          Counselling Sessions
        </h1>
        <p class="text-primary-200 mt-1 text-sm">{{ $sessions->total() }} total sessions</p>
      </div>
      <a href="{{ route('admin.dashboard') }}" class="bg-white/15 border border-white/20 text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-white/25 transition">← Dashboard</a>
    </div>
  </div>

  <div class="max-w-screen-xl mx-auto px-4 md:px-6 -mt-14 pb-16">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
      <div class="p-5 border-b border-gray-100 dark:border-gray-700">
        <form method="GET" class="flex gap-2">
          <select name="status" class="rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400">
            <option value="all">All Status</option>
            @foreach(['pending','confirmed','completed','cancelled'] as $s)
              <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
          </select>
          <button class="bg-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-700 transition">Filter</button>
        </form>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-gray-50 dark:bg-gray-700/50">
            <tr>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">User</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Topic</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Date & Time</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Status</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Update</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
            @forelse($sessions as $s)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
              <td class="px-5 py-3">
                <p class="font-semibold text-gray-800 dark:text-white">{{ $s->user?->name ?? '—' }}</p>
                <p class="text-xs text-gray-400">{{ $s->user?->email ?? '' }}</p>
              </td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300 font-medium">{{ $s->topic }}</td>
              <td class="px-5 py-3">
                <p class="text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($s->preferred_date)->format('d M Y') }}</p>
                <p class="text-xs text-gray-400">{{ $s->preferred_time }}</p>
              </td>
              <td class="px-5 py-3">
                @php
                  $sc = match($s->status) {
                    'confirmed'  => 'bg-emerald-100 text-emerald-700',
                    'completed'  => 'bg-blue-100 text-blue-700',
                    'cancelled'  => 'bg-red-100 text-red-700',
                    default      => 'bg-yellow-100 text-yellow-700',
                  };
                @endphp
                <span class="text-[11px] font-bold px-2 py-0.5 rounded-full {{ $sc }}">{{ ucfirst($s->status) }}</span>
              </td>
              <td class="px-5 py-3">
                <form action="{{ route('admin.counselling.status', $s->id) }}" method="POST" class="flex gap-2">
                  @csrf
                  <select name="status" class="rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-primary-400">
                    @foreach(['pending','confirmed','completed','cancelled'] as $opt)
                      <option value="{{ $opt }}" {{ $s->status == $opt ? 'selected' : '' }}>{{ ucfirst($opt) }}</option>
                    @endforeach
                  </select>
                  <button class="bg-primary-600 text-white px-2 py-1 rounded-lg text-xs font-bold hover:bg-primary-700 transition">Save</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">No sessions found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="p-5 border-t border-gray-100 dark:border-gray-700">{{ $sessions->links() }}</div>
    </div>
  </div>
</div>
@endsection
