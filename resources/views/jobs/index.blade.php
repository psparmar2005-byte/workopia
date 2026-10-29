<x-layout>

    <div class="bg-blue-900 h-24 p-4 mb-4 flex justify-center items-center rounded">
        <x-search />
    </div>

    @if (request()->has('keywords') || request()->has('location'))
        <a href="{{ route('jobs.index') }}"
            class="bg-blue-400 hover:bg-blue-600 px-4 py-2 rounded text-white mb-4 inline-block">
            <i class="fa fa-arrow-left mr-2en"></i>Back
        </a>
    @endif

    <h1 class="text-2xl">{{ request('keywords') || request('location') ? 'Search Results' : 'All Jobs' }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
        @forelse ($jobs as $job)
            <x-job-card :job="$job" />
        @empty
            <p>No jobs available.</p>
        @endforelse
    </div>
    {{ $jobs->links() }}
</x-layout>
