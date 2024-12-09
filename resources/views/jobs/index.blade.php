<x-layout>
    <x-slot:pageTitle>All Jobs</x-slot:pageTitle>
    <h1 class="text-2xl"> ALL JOBS</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @forelse($jobs as $job)
            <x-job-card :job="$job" />
        @empty
            <p>No jobs found</p>
        @endforelse
    </div>
</x-layout>