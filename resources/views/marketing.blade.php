<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Marketing Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-4">📊 Marketing Dashboard</h2>

    <h4 class="mt-4">🎭 Genre Segments</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Segment</th><th>Content</th><th>Avg Rating</th><th>Avg Popularity</th><th>Engagement</th><th>Market Share %</th>
        </tr>
      </thead>
      <tbody>
        @foreach($genreSegments as $s)
          <tr>
            <td>{{ $s->segment_name }}</td>
            <td>{{ $s->content_count }}</td>
            <td>{{ number_format($s->avg_rating, 2) }}</td>
            <td>{{ number_format($s->avg_popularity, 2) }}</td>
            <td>{{ $s->total_engagement }}</td>
            <td>{{ number_format($s->market_share, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <h4 class="mt-4">🔞 Audience Rating Segments</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Segment</th><th>Content</th><th>Avg Rating</th><th>Avg Popularity</th><th>Engagement</th><th>Market Share %</th>
        </tr>
      </thead>
      <tbody>
        @foreach($ratingSegments as $s)
          <tr>
            <td>{{ $s->segment_name }}</td>
            <td>{{ $s->content_count }}</td>
            <td>{{ number_format($s->avg_rating, 2) }}</td>
            <td>{{ number_format($s->avg_popularity, 2) }}</td>
            <td>{{ $s->total_engagement }}</td>
            <td>{{ number_format($s->market_share, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <h4 class="mt-4">⏱️ Duration Segments</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Segment</th><th>Content</th><th>Avg Rating</th><th>Avg Popularity</th><th>Engagement</th><th>Market Share %</th>
        </tr>
      </thead>
      <tbody>
        @foreach($durationSegments as $s)
          <tr>
            <td>{{ $s->segment_name }}</td>
            <td>{{ $s->content_count }}</td>
            <td>{{ number_format($s->avg_rating, 2) }}</td>
            <td>{{ number_format($s->avg_popularity, 2) }}</td>
            <td>{{ $s->total_engagement }}</td>
            <td>{{ number_format($s->market_share, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    {{-- ===========================
         FITUR 2: Campaign Performance
         =========================== --}}
    <div class="d-flex align-items-center justify-content-between mt-5">
      <h4 class="mb-0">📣 Campaign Performance</h4>

      <form class="d-flex gap-2" method="GET" action="/marketing">
        <select class="form-select" name="period" style="width: 170px;">
          <option value="">All Period</option>
          @foreach(['Last 7 Days','Last 30 Days','Older'] as $p)
            <option value="{{ $p }}" @selected(($period ?? '') === $p)>{{ $p }}</option>
          @endforeach
        </select>

        <input class="form-control" name="type" placeholder="type_name (ex: Scripted)"
               style="width: 190px;" value="{{ $typeName ?? '' }}">

        <input class="form-control" name="min_score" placeholder="min score"
               style="width: 140px;" value="{{ $minScore ?? '' }}">

        <input class="form-control" name="limit" placeholder="limit"
               style="width: 90px;" value="{{ $limit ?? 50 }}">

        <button class="btn btn-primary">Filter</button>
      </form>
    </div>

    <table class="table table-striped mt-3">
      <thead>
        <tr>
          <th>Show</th>
          <th>Type</th>
          <th>Genres</th>
          <th>Rating</th>
          <th>Votes</th>
          <th>Popularity</th>
          <th>First Air</th>
          <th>Bucket</th>
          <th>Score</th>
        </tr>
      </thead>
      <tbody>
        @forelse($campaign as $c)
          <tr>
            <td class="fw-semibold">{{ $c->show_name }}</td>
            <td>{{ $c->content_type }}</td>
            <td style="max-width: 260px;">{{ $c->genres }}</td>
            <td>{{ is_null($c->avg_rating) ? '-' : number_format((float)$c->avg_rating, 2) }}</td>
            <td>{{ $c->total_votes ?? 0 }}</td>
            <td>{{ is_null($c->popularity) ? '-' : number_format((float)$c->popularity, 2) }}</td>
            <td>
              {{ $c->first_air_date ? \Carbon\Carbon::parse($c->first_air_date)->format('Y-m-d') : '-' }}
            </td>
            <td>{{ $c->campaign_period_bucket }}</td>
            <td class="fw-bold">{{ number_format((float)$c->campaign_score, 2) }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="9" class="text-center text-muted py-4">No campaign data.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

  </div>
</body>
</html>
