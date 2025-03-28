<x-layout>
    <x-slot:heading>
        Job Listings
    </x-slot:heading>

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="py-12 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">

            @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasPermissionTo('create jobs')))
                <div class="mb-6">
                    <a href="{{ secure_url('/jobs/create') }}"
                       class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create
                        New Job</a>
                </div>
            @endif

            @unless(count($jobs) == 0)
                <div class="space-y-8">
                    @foreach($jobs as $job)
                        <a href="{{ url('/jobs/' . $job->id) }}"
                           class="block px-4 py-6 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-blue-400">
                            <div class="font-bold text-blue-500 text-xl">{{ $job->title }}<br></div>

                            <div>
                                <b>Salary:</b> {{ $job->salary }} per year
                            </div>
                        </a>
                    @endforeach
                </div>

                <div>
                    {{ $jobs->links() }}
                </div>
            @endunless
        </div>
    </div>
</x-layout>
