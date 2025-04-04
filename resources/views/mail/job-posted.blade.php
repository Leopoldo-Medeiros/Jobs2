
<h2>
    {{ $job->title }}
</h2>

<p>
    Congrats! Your job has been posted.
</p>

<p>
    <a href="{{ url('/jobs/' . $job->id) }}">View Your Job Listings</a>
</p>

<p>
    Thanks,
    The Job Board Team
</p>