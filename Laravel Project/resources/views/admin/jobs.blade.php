@extends('layouts.app')
@section('title', 'Manage Jobs – Admin')
@section('content')
<div class="pt-16 min-h-screen bg-gray-50 dark:bg-gray-900">
  <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-gray-900 pt-10 pb-24 px-6">
    <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <p class="text-orange-400 text-xs font-semibold uppercase tracking-widest mb-1">Admin Panel</p>
        <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
          <svg class="w-7 h-7 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/></svg>
          Manage Jobs
        </h1>
        <p class="text-primary-200 mt-1 text-sm">{{ $jobs->total() }} total jobs</p>
      </div>
      <div class="flex gap-3">
        <a href="{{ route('admin.jobs.create') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold px-4 py-2.5 rounded-xl flex items-center gap-2 transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          Add Job
        </a>
        <a href="{{ route('admin.dashboard') }}" class="bg-white/15 border border-white/20 text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-white/25 transition">← Dashboard</a>
      </div>
    </div>
  </div>

  <div class="max-w-screen-xl mx-auto px-4 md:px-6 -mt-14 pb-16">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
      <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row gap-3">
        <form method="GET" class="flex gap-2 flex-1">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs..."
            class="flex-1 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"/>
          <select name="type" class="rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400">
            <option value="all">All Types</option>
            @foreach(['government','private','contract','internship'] as $t)
              <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
            @endforeach
          </select>
          <button class="bg-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-700 transition">Filter</button>
        </form>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-gray-50 dark:bg-gray-700/50">
            <tr>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Job</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Type</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Location</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Vacancies</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Status</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
            @forelse($jobs as $job)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
              <td class="px-5 py-3">
                <p class="font-semibold text-gray-800 dark:text-white">{{ $job->title }}</p>
                <p class="text-xs text-gray-400">{{ $job->department }}</p>
              </td>
              <td class="px-5 py-3">
                <span class="text-[11px] font-bold px-2 py-0.5 rounded-full {{ $job->type === 'government' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                  {{ ucfirst($job->type) }}
                </span>
              </td>
              <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $job->location }}</td>
              <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $job->vacancies ?? '—' }}</td>
              <td class="px-5 py-3">
                <span class="text-[11px] font-bold px-2 py-0.5 rounded-full {{ $job->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                  {{ $job->is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-5 py-3 flex items-center gap-3">
                <a href="{{ route('admin.jobs.edit', $job->id) }}" class="text-xs text-primary-600 hover:underline font-semibold">Edit</a>
                <form action="{{ route('admin.jobs.delete', $job->id) }}" method="POST" onsubmit="return confirm('Delete this job?')">
                  @csrf @method('DELETE')
                  <button class="text-xs text-red-500 hover:underline font-semibold">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-gray-400">No jobs found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="p-5 border-t border-gray-100 dark:border-gray-700">{{ $jobs->links() }}</div>
    </div>
  </div>
</div>
@endsection
