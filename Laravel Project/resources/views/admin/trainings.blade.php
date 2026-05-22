@extends('layouts.app')
@section('title', 'Manage Trainings – Admin')
@section('content')
<div class="pt-16 min-h-screen bg-gray-50 dark:bg-gray-900">
  <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-gray-900 pt-10 pb-24 px-6">
    <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <p class="text-orange-400 text-xs font-semibold uppercase tracking-widest mb-1">Admin Panel</p>
        <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
          <svg class="w-7 h-7 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          Manage Trainings
        </h1>
        <p class="text-primary-200 mt-1 text-sm">{{ $trainings->total() }} training programs</p>
      </div>
      <a href="{{ route('admin.dashboard') }}" class="bg-white/15 border border-white/20 text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-white/25 transition">← Dashboard</a>
    </div>
  </div>

  <div class="max-w-screen-xl mx-auto px-4 md:px-6 -mt-14 pb-16">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
      <div class="p-5 border-b border-gray-100 dark:border-gray-700">
        <form method="GET" class="flex gap-2">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search trainings..."
            class="flex-1 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"/>
          <button class="bg-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-700 transition">Search</button>
        </form>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-gray-50 dark:bg-gray-700/50">
            <tr>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Training</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Category</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Duration</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Seats</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Enrolled</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Status</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
            @forelse($trainings as $t)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
              <td class="px-5 py-3">
                <p class="font-semibold text-gray-800 dark:text-white">{{ $t->title }}</p>
                <p class="text-xs text-gray-400">{{ $t->provider ?? '—' }}</p>
              </td>
              <td class="px-5 py-3"><span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-purple-100 text-purple-700">{{ $t->category }}</span></td>
              <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $t->duration ?? '—' }}</td>
              <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $t->total_seats ?? '—' }}</td>
              <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $t->enrolled_count ?? 0 }}</td>
              <td class="px-5 py-3">
                <span class="text-[11px] font-bold px-2 py-0.5 rounded-full {{ $t->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                  {{ $t->is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-5 py-3">
                <form action="{{ route('admin.trainings.delete', $t->id) }}" method="POST" onsubmit="return confirm('Delete this training?')">
                  @csrf @method('DELETE')
                  <button class="text-xs text-red-500 hover:underline font-semibold">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-5 py-12 text-center text-gray-400">No trainings found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="p-5 border-t border-gray-100 dark:border-gray-700">{{ $trainings->links() }}</div>
    </div>
  </div>
</div>
@endsection
