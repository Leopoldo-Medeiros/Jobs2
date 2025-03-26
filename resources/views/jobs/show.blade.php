<x-layout>
    <x-slot:heading>
        Job Details
    </x-slot:heading>
 
        <h2 class="font-bold text-xl">{{ $job->title }}</h2>

        <p>
            This job pays <b class="text-red-500">{{ $job->salary }}</b> per year.
        </p>

        @can('edit', $job)
            <p class="mt-6">
                <button onclick="window.history.back()" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Back</button>
                <x-button href="{{ secure_url('/jobs/' . $job->id . '/edit') }}">Edit Job</x-button>
            </p>
        @else
            <p class="mt-6">
                <button onclick="window.history.back()" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Back</button>
            </p>
        @endcan

</x-layout>
