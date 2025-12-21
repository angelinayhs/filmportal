@extends('executive.layout')


@section('content')
<h1 class="text-2xl font-bold mb-4">{{ $show->name }}</h1>
<p class="italic text-gray-600 mb-4">{{ $show->tagline }}</p>


<div class="grid grid-cols-2 gap-6">
<div>
<h3 class="font-bold mb-2">Overview</h3>
<p>{{ $show->overview }}</p>
</div>
<div>
<h3 class="font-bold mb-2">Metadata</h3>
<ul class="text-sm">
<li>Type: {{ $show->show_type }}</li>
<li>Genres: {{ $show->genres }}</li>
<li>Runtime: {{ $show->runtime_minutes }} min</li>
<li>Seasons: {{ $show->number_of_seasons }}</li>
<li>Episodes: {{ $show->number_of_episodes }}</li>
<li>Status: {{ $show->status }}</li>
<li>Lifecycle: {{ $show->lifecycle_status }}</li>
</ul>
</div>
</div>
@endsection