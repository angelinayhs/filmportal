@extends('executive.layout')


@section('content')
<h1 class="text-2xl font-bold mb-6">Studio Content Management</h1>


<!-- Summary Cards -->
<div class="grid grid-cols-4 gap-4 mb-6">
<div class="bg-white p-4 rounded shadow">Total Shows<br><b>{{ $stats['total'] }}</b></div>
<div class="bg-blue-100 p-4 rounded shadow">Upcoming<br><b>{{ $stats['upcoming'] }}</b></div>
<div class="bg-green-100 p-4 rounded shadow">Released<br><b>{{ $stats['released'] }}</b></div>
<div class="bg-gray-200 p-4 rounded shadow">Archived<br><b>{{ $stats['archived'] }}</b></div>
</div>


<!-- Table -->
<div class="bg-white rounded shadow overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-100">
<tr>
<th class="p-3">Title</th>
<th>Type</th>
<th>Genres</th>
<th>Rating</th>
<th>Popularity</th>
<th>Lifecycle</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@foreach($shows as $show)
<tr class="border-t">
<td class="p-3 font-semibold">{{ $show->name }}</td>
<td>{{ $show->show_type }}</td>
<td>{{ $show->genres }}</td>
<td>⭐ {{ $show->vote_average }} ({{ $show->vote_count }})</td>
<td>{{ $show->popularity }}</td>
<td>
<span class="px-2 py-1 rounded text-xs
@if($show->lifecycle_status=='Upcoming') bg-blue-200
@elseif($show->lifecycle_status=='Released') bg-green-200
@else bg-gray-300 @endif">
{{ $show->lifecycle_status }}
</span>
</td>
<td>
<a href="/executive/content/{{ $show->show_id }}" class="text-blue-600">View</a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection