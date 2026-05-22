@extends('layouts.app')
@section('title', 'Manage Users – Admin')
@section('content')
<div class="pt-16 min-h-screen bg-gray-50 dark:bg-gray-900">
  <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-gray-900 pt-10 pb-24 px-6">
    <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <p class="text-orange-400 text-xs font-semibold uppercase tracking-widest mb-1">Admin Panel</p>
        <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
          <svg class="w-7 h-7 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          Manage Users
        </h1>
        <p class="text-primary-200 mt-1 text-sm">{{ $users->total() }} registered users</p>
      </div>
      <a href="{{ route('admin.dashboard') }}" class="bg-white/15 border border-white/20 text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-white/25 transition">← Dashboard</a>
    </div>
  </div>

  <div class="max-w-screen-xl mx-auto px-4 md:px-6 -mt-14 pb-16">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
      <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row gap-3">
        <form method="GET" class="flex gap-2 flex-1">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
            class="flex-1 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"/>
          <button class="bg-primary-600 text-white px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-700 transition">Search</button>
          @if(request('search'))<a href="{{ route('admin.users') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">Clear</a>@endif
        </form>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-gray-50 dark:bg-gray-700/50">
            <tr>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">#</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">User</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Phone</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">District</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Joined</th>
              <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
            @forelse($users as $u)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
              <td class="px-5 py-3 text-gray-400 text-xs">{{ $users->firstItem() + $loop->index }}</td>
              <td class="px-5 py-3">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-600 to-blue-400 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                  </div>
                  <div>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $u->name }}</p>
                    <p class="text-xs text-gray-400">{{ $u->email }}</p>
                  </div>
                </div>
              </td>
              <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $u->phone ?? '—' }}</td>
              <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $u->district ?? '—' }}</td>
              <td class="px-5 py-3 text-gray-400 text-xs">{{ $u->created_at->format('d M Y') }}</td>
              <td class="px-5 py-3">
                <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Delete {{ $u->name }}?')">
                  @csrf @method('DELETE')
                  <button class="text-xs text-red-500 hover:text-red-700 font-semibold hover:underline transition">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-gray-400">No users found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="p-5 border-t border-gray-100 dark:border-gray-700">{{ $users->links() }}</div>
    </div>
  </div>
</div>
@endsection
