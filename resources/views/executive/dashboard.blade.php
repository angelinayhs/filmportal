<!DOCTYPE html>
<html>
<head>
    <title>Executive Dashboard</title>
</head>
<body>

<h1>Executive Dashboard</h1>

<p>Total Content: {{ $films->count() }}</p>
<p>Average Rating: {{ number_format($films->avg('rating'), 1) }}</p>

<ul>
    @foreach($films as $film)
        <li>
            {{ $film['title'] }} ({{ ucfirst($film['type']) }}) -
            ⭐ {{ $film['rating'] }}
        </li>
    @endforeach
</ul>

<form method="POST" action="/logout">
    @csrf
    <button type="submit">Logout</button>
</form>

</body>
</html>
