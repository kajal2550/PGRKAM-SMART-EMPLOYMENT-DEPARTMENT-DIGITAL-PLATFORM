@extends('layouts.app')
@section('title', ($job ? 'Edit' : 'Add') . ' Job – Admin')
@section('content')
<div class="pt-16 min-h-screen bg-gray-50 dark:bg-gray-900">
  <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-gray-900 pt-10 pb-24 px-6">
    <div class="max-w-screen-xl mx-auto flex items-center justify-between">
      <div>
        <p class="text-orange-400 text-xs font-semibold uppercase tracking-widest mb-1">Admin Panel</p>
        <h1 class="text-3xl font-extrabold text-white">{{ $job ? 'Edit Job' : 'Add New Job' }}</h1>
      </div>
      <a href="{{ route('admin.jobs') }}" class="bg-white/15 border border-white/20 text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-white/25 transition">← Back to Jobs</a>
    </div>
  </div>

  <div class="max-w-3xl mx-auto px-4 md:px-6 -mt-14 pb-16">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-primary-50/50 dark:bg-primary-900/10">
        <h2 class="font-bold text-gray-800 dark:text-gray-100">Job Details</h2>
      </div>

      <form action="{{ $job ? route('admin.jobs.update', $job->id) : route('admin.jobs.store') }}" method="POST" class="p-6 space-y-5">
        @csrf
        @if($job) @method('PUT') @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Job Title *</label>
            <input type="text" name="title" value="{{ old('title', $job?->title) }}" required
              class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"/>
            @error('title')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Department *</label>
            <input type="text" name="department" value="{{ old('department', $job?->department) }}" required
              class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"/>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Type *</label>
            <select name="type" required class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400">
              @foreach(['government','private','contract','internship'] as $t)
                <option value="{{ $t }}" {{ old('type', $job?->type) == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Location *</label>
            <input type="text" name="location" value="{{ old('location', $job?->location) }}" required
              class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"/>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Vacancies</label>
            <input type="number" name="vacancies" value="{{ old('vacancies', $job?->vacancies) }}" min="1"
              class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"/>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Salary Range</label>
            <input type="text" name="salary_range" value="{{ old('salary_range', $job?->salary_range) }}" placeholder="e.g. ₹25,000 – ₹45,000"
              class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"/>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Application Deadline</label>
            <input type="date" name="application_deadline" value="{{ old('application_deadline', $job?->application_deadline) }}"
              class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"/>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-600 dark:text-gray-300 mb-2 uppercase tracking-wide">Description</label>
          <textarea name="description" rows="4" placeholder="Job description..."
            class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 resize-none">{{ old('description', $job?->description) }}</textarea>
        </div>

        <div class="flex items-center gap-3">
          <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $job?->is_active ?? true) ? 'checked' : '' }}
            class="w-4 h-4 text-primary-600 rounded"/>
          <label for="is_active" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active (visible to users)</label>
        </div>

        <div class="flex gap-3">
          <button type="submit" class="flex-1 bg-gradient-to-r from-primary-700 to-blue-600 hover:from-primary-800 hover:to-blue-700 text-white font-bold py-3 rounded-xl transition shadow-lg flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ $job ? 'Update Job' : 'Create Job' }}
          </button>
          <a href="{{ route('admin.jobs') }}" class="px-6 py-3 rounded-xl border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
