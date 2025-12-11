<!DOCTYPE html>
<html>
<head>
    <title>{{ $show->name }}</title>
</head>
<body style="font-family: sans-serif; padding: 20px">

    <h1>{{ $show->name }}</h1>
    <p><strong>Tagline:</strong> {{ $show->tagline }}</p>
    <p><strong>Overview:</strong><br>{{ $show->overview }}</p>

    <p><strong>Genres:</strong> {{ $show->genres }}</p>
    <p><strong>Languages:</strong> {{ $show->languages }}</p>
    <p><strong>Spoken:</strong> {{ $show->spoken_languages }}</p>
    <p><strong>Network:</strong> {{ $show->networks }}</p>
    <p><strong>Production Countries:</strong> {{ $show->production_countries }}</p>

    <p><strong>Rating:</strong> {{ $show->vote_average }}</p>
    <p><strong>Popularity:</strong> {{ $show->popularity }}</p>

    <p><strong>First Air Date:</strong> {{ $show->first_air_date }}</p>
    <p><strong>Last Air Date:</strong> {{ $show->last_air_date }}</p>

</body>
</html>
