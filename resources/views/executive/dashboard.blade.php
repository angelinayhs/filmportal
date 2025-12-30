@php
function uniqueList($str) {
    if (!$str) return '-';
    $arr = array_map('trim', explode(',', $str));
    $arr = array_unique(array_filter($arr));
    return implode(', ', $arr);
}

function formatRating($vote_average, $vote_count) {
    if ($vote_count == 0) return '<span class="text-muted">0 votes</span>';
    return '⭐ ' . number_format($vote_average, 1) . '<br><small class="text-muted">' . number_format($vote_count) . ' votes</small>';
}

function formatPopularity($popularity) {
    if ($popularity === null || $popularity === '') return '-';
    return number_format($popularity, 2);
}

function formatDates($first_date, $last_date) {
    if (!$first_date && !$last_date) return '-';
    if ($first_date == $last_date) return $first_date;
    return $first_date . ' → ' . $last_date;
}

// Safe check untuk variable
$topPerformers = $topPerformers ?? collect();
$globalTrends = $globalTrends ?? collect();
$lifecycle = $lifecycle ?? collect();
$crossStudio = $crossStudio ?? collect();
$studioList = $studioList ?? collect();
$stats = $stats ?? (object)['total' => 0, 'upcoming' => 0, 'released' => 0, 'archived' => 0];
$topGrowthContent = $topGrowthContent ?? collect();
$trendLines = $trendLines ?? collect();
$subtitleDistribution = $subtitleDistribution ?? collect();
$subtitleGrowthData = $subtitleGrowthData ?? [];
$languageStats = $languageStats ?? [];
@endphp

<!DOCTYPE html>
<html lang="id">
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