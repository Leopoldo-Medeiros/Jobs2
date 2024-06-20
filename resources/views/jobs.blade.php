<x-layout>
    <x-slot:heading>
        Job Listing
    </x-slot:heading>

    <ul>
        @foreach($jobs as $job)
            <li>
                <a href="/jobs/{{ $job['id'] }}" class="block rounded-md px-3 py-2 text-base font-medium hover:bg-blue-200 hover:text-black">
                    <b>{{ $job['title'] }} :</b> Pays {{ $job['salary'] }} per year
                </a>
            </li>

        @endforeach
    </ul>
</x-layout>
