<x-layout>
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-xl mx-auto mt-6">
        <h3 class="text-3xl text-center font-bold mb-4">
            My Job Listings
        </h3>
        @forelse ($jobs as $job)
            <div class="flex justify-between items-center border-b-2 border-gray-200 py-2">
                <div>
                    <h3 class="text-xl font-semibold">{{ $job->title }}</h3>
                    <p class="text-gray-700">{{ $job->job_type }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('jobs.edit', $job->id) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded text-sm">Edit</a>
                    <!-- Delete Form -->
                    <form method="POST" action="{{ route('jobs.destroy', $job->id) }}?from=dashboard "
                        onsubmit="return confirm('Are you sure that you want to delete this job?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 text-sm py-2 bg-red-500 hover:bg-red-600 text-white rounded">
                            Delete
                        </button>
                    </form>
                    <!-- End Delete Form -->
                </div>

            </div>

            <div class="mt-4 bg-gray-100 p-3">
                <h4 class="text-lg font-semibold mb-2">Applicants</h4>
                @forelse ($job->applicants as $applicants)
                    <div class="py-2">
                        <p class="text-gray-800">
                            <strong>Name:</strong> {{ $applicants->full_name }}
                        </p>
                        <p class="text-gray-800">
                            <strong>Contact Phone:</strong> {{ $applicants->contact_phone }}
                        </p>
                        <p class="text-gray-800">
                            <strong>Contact Email:</strong> {{ $applicants->contact_email }}
                        </p>
                        <p class="text-gray-800">
                            <strong>Location:</strong> {{ $applicants->location }}
                        </p>
                        <p class="text-gray-800">
                            <strong>Message:</strong> {{ $applicants->message }}
                        </p>
                        <p class="text-gray-400 mt-2">
                            <a href="{{ asset('storage/' . $applicants->resume_path) }}"
                                class="text-blue-500 hover:underline text-sm" download>
                                <i class="fas fa-download"></i> Download Resume
                            </a>
                        </p>
                        {{-- Delete applicant --}}
                        <form action="{{ route('applicant.destroy', $applicants->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this applicant?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 text-sm hover:underline mb-2" type="submit">
                                <i class="fas fa-trash"></i> Delete Applicant</button>
                        </form>

                    </div>
                @empty
                    <p class="text-gray-700 mb-5">No applicants for this job.</p>
                @endforelse
            </div>
        @empty
            <p class="text-grey-700">You have no job listings</p>
        @endforelse
    </div>
</x-layout>
