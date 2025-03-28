<x-layout>
    <x-slot:heading>
        Job Details
    </x-slot:heading>
 
        <h2 class="font-bold text-xl">{{ $job->title }}</h2>

        <p>
            This job pays <b class="text-red-500">{{ $job->salary }}</b> per year.
        </p>

        <!-- Job Description Container -->
        @if($job->about)
        <div class="mt-6 mb-6 bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
                <h3 class="text-base font-semibold text-gray-900">Job Description</h3>
            </div>
            <div class="p-4">
                <div class="prose max-w-none text-gray-700">
                    {{ $job->about }}
                </div>
            </div>
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
                <h3 class="text-base font-semibold text-gray-900">About The Team</h3>
            </div>
            <div class="p-4">
                <div class="prose max-w-none text-gray-700">
                    {{ $job->about }}
                </div>
            </div>
        </div>
        
        @else
        <div class="mt-6 mb-6 bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
                <h3 class="text-base font-semibold text-gray-900">Job Description</h3>
            </div>
            <div class="p-4 text-center">
                <p class="text-gray-500">No job description provided.</p>
            </div>
        </div>
        @endif
        @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasPermissionTo('edit jobs')))
            <p class="mt-6">
                <button onclick="window.history.back()" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Back</button>
                <x-button href="{{ secure_url('/jobs/' . $job->id . '/edit') }}">Edit Job</x-button>
            </p>
        @else
            <p class="mt-6">
                <button onclick="window.history.back()" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Back</button>
            </p>
        @endif

</x-layout>
