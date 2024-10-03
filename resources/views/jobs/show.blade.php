<x-layout>
    <x-slot:heading>
        Job
    </x-slot:heading>
    {{-- Here I am accessing as the array key --}}
    <h2 class="font-bold text-xl">{{ $job->title }}</h2>

    <p>
        This job pays <b class="text-red-500">{{ $job->salary }}</b> per year.
    </p>

    <p class="mt-6">
        {{-- Here I am accessing the job's id property to generate the URL. "{{ $job->id }}"--}}
        <x-button href="/jobs/{{ $job->id }}/edit">Edit Job</x-button>
    </p>
</x-layout>
