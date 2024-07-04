<x-layout>
    <x-slot:heading>
        Job
    </x-slot:heading>

    <h2 class="font-bold text-xl">{{ $job['title'] }}</h2>

    <p>
        This job pays <b class="text-red-500">{{ $job['salary'] }}</b> per year.
    </p>
</x-layout>
