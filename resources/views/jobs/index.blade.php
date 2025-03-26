<x-layout>
    <x-slot:heading>
        Job Listings
    </x-slot:heading>

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="space-y-4">
        @foreach($jobs as $job)
            <a href="{{ url('/jobs/' . $job->id) }}" class="block px-4 py-6 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-blue-400">
                <div class="font-bold text-blue-500 text-xl">{{ $job->title }}<br></div>

                <div>
                    <b>Salary:</b> {{ $job->salary }} per year
                </div>
            </a>
        @endforeach

        <div>
            {{ $jobs->links() }}
        </div>
    </div>
</x-layout>
