<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Marketing Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4 bg-light">
  <div class="container">

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
      <h2 class="mb-0">📊 Marketing Dashboard</h2>

      <form method="POST" action="/logout" class="m-0">
        @csrf
        <button class="btn btn-outline-danger btn-sm">Logout</button>
      </form>
    </div>

    @php
      function safeDate($val) {
        if (!$val) return '-';
        try { return \Carbon\Carbon::parse($val)->format('Y-m-d'); }
        catch (\Exception $e) { return (string) $val; }
      }
      $section = $section ?? 1;
    @endphp

    <div class="accordion" id="marketingAccordion">

      {{-- ===========================
           1) Audience Segmentation
           =========================== --}}
      <div class="accordion-item">
        <h2 class="accordion-header" id="h1">
          <a class="accordion-button {{ $section === 1 ? '' : 'collapsed' }}"
             href="/marketing?section=1">
            1) Audience Segmentation & Profiling
          </a>
        </h2>
        <div id="c1" class="accordion-collapse collapse {{ $section === 1 ? 'show' : '' }}">
          <div class="accordion-body">

            <h5 class="mb-2">🎭 Genre Segments</h5>
            <div class="table-responsive mb-4">
              <table class="table table-striped align-middle">
                <thead>
                  <tr>
                    <th>Segment</th><th>Content</th><th>Avg Rating</th><th>Avg Popularity</th><th>Engagement</th><th>Market Share %</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse(($genreSegments ?? []) as $s)
                    <tr>
                      <td class="fw-semibold">{{ $s->segment_name }}</td>
                      <td>{{ $s->content_count }}</td>
                      <td>{{ is_null($s->avg_rating) ? '-' : number_format((float)$s->avg_rating, 2) }}</td>
                      <td>{{ is_null($s->avg_popularity) ? '-' : number_format((float)$s->avg_popularity, 2) }}</td>
                      <td>{{ $s->total_engagement ?? 0 }}</td>
                      <td>{{ is_null($s->market_share) ? '-' : number_format((float)$s->market_share, 2) }}</td>
                    </tr>
                  @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data genre segments.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <h5 class="mb-2">🔞 Audience Rating Segments</h5>
            <div class="table-responsive mb-4">
              <table class="table table-striped align-middle">
                <thead>
                  <tr>
                    <th>Segment</th><th>Content</th><th>Avg Rating</th><th>Avg Popularity</th><th>Engagement</th><th>Market Share %</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse(($ratingSegments ?? []) as $s)
                    <tr>
                      <td class="fw-semibold">{{ $s->segment_name }}</td>
                      <td>{{ $s->content_count }}</td>
                      <td>{{ is_null($s->avg_rating) ? '-' : number_format((float)$s->avg_rating, 2) }}</td>
                      <td>{{ is_null($s->avg_popularity) ? '-' : number_format((float)$s->avg_popularity, 2) }}</td>
                      <td>{{ $s->total_engagement ?? 0 }}</td>
                      <td>{{ is_null($s->market_share) ? '-' : number_format((float)$s->market_share, 2) }}</td>
                    </tr>
                  @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data audience rating segments.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <h5 class="mb-2">⏱️ Duration Segments</h5>
            <div class="table-responsive">
              <table class="table table-striped align-middle">
                <thead>
                  <tr>
                    <th>Segment</th><th>Content</th><th>Avg Rating</th><th>Avg Popularity</th><th>Engagement</th><th>Market Share %</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse(($durationSegments ?? []) as $s)
                    <tr>
                      <td class="fw-semibold">{{ $s->segment_name }}</td>
                      <td>{{ $s->content_count }}</td>
                      <td>{{ is_null($s->avg_rating) ? '-' : number_format((float)$s->avg_rating, 2) }}</td>
                      <td>{{ is_null($s->avg_popularity) ? '-' : number_format((float)$s->avg_popularity, 2) }}</td>
                      <td>{{ $s->total_engagement ?? 0 }}</td>
                      <td>{{ is_null($s->market_share) ? '-' : number_format((float)$s->market_share, 2) }}</td>
                    </tr>
                  @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data duration segments.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

      {{-- ===========================
           2) Campaign Performance
           =========================== --}}
      <div class="accordion-item">
        <h2 class="accordion-header" id="h2">
          <a class="accordion-button {{ $section === 2 ? '' : 'collapsed' }}"
             href="/marketing?section=2">
            2) Campaign Performance
          </a>
        </h2>
        <div id="c2" class="accordion-collapse collapse {{ $section === 2 ? 'show' : '' }}">
          <div class="accordion-body">

            <form class="row g-2 mb-3" method="GET" action="/marketing">
              <input type="hidden" name="section" value="2">

              <div class="col-md-3">
                <select class="form-select" name="period_bucket">
                  <option value="">All Period</option>
                  @foreach(['Last 7 Days','Last 30 Days','Older'] as $p)
                    <option value="{{ $p }}" @selected(request('period_bucket') === $p)>{{ $p }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-3">
                <input class="form-control" name="type_name" placeholder="type_name (ex: Scripted)" value="{{ request('type_name') }}">
              </div>

              <div class="col-md-2">
                <input class="form-control" name="min_score" placeholder="min score" value="{{ request('min_score') }}">
              </div>

              <div class="col-md-2">
                <input class="form-control" name="limit" placeholder="limit (max 100)" value="{{ request('limit', 50) }}">
              </div>

              <div class="col-md-2 d-grid">
                <button class="btn btn-primary">Apply</button>
              </div>
            </form>

            <div class="table-responsive">
              <table class="table table-striped table-bordered align-middle">
                <thead>
                  <tr>
                    <th>Show</th><th>Type</th><th>Genres</th><th>Rating</th><th>Votes</th><th>Popularity</th><th>First Air</th><th>Bucket</th><th>Score</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse(($campaignPerformance ?? []) as $c)
                    <tr>
                      <td class="fw-semibold">{{ $c->show_name }}</td>
                      <td>{{ $c->content_type }}</td>
                      <td style="max-width: 280px;">{{ $c->genres }}</td>
                      <td>{{ is_null($c->avg_rating) ? '-' : number_format((float)$c->avg_rating, 2) }}</td>
                      <td>{{ $c->total_votes ?? 0 }}</td>
                      <td>{{ is_null($c->popularity) ? '-' : number_format((float)$c->popularity, 2) }}</td>
                      <td>{{ safeDate($c->first_air_date ?? null) }}</td>
                      <td>{{ $c->campaign_period_bucket }}</td>
                      <td class="fw-bold">{{ is_null($c->campaign_score) ? '-' : number_format((float)$c->campaign_score, 2) }}</td>
                    </tr>
                  @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">No campaign data.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

      {{-- ===========================
           3) Trend Forecasting
           =========================== --}}
      <div class="accordion-item">
        <h2 class="accordion-header" id="h3">
          <a class="accordion-button {{ $section === 3 ? '' : 'collapsed' }}"
             href="/marketing?section=3">
            3) Trend Forecasting (Release Trend)
          </a>
        </h2>
        <div id="c3" class="accordion-collapse collapse {{ $section === 3 ? 'show' : '' }}">
          <div class="accordion-body">

            <form class="row g-2 mb-3" method="GET" action="/marketing">
              <input type="hidden" name="section" value="3">
              <div class="col-md-3"><input type="number" name="year_from" class="form-control" placeholder="Year From" value="{{ request('year_from') }}"></div>
              <div class="col-md-3"><input type="number" name="year_to" class="form-control" placeholder="Year To" value="{{ request('year_to') }}"></div>
              <div class="col-md-4"><input type="text" name="genre" class="form-control" placeholder="Genre (exact)" value="{{ request('genre') }}"></div>
              <div class="col-md-2 d-grid"><button class="btn btn-primary">Apply</button></div>
            </form>

            <div class="table-responsive">
              <table class="table table-striped table-bordered align-middle">
                <thead>
                  <tr>
                    <th>Year</th><th>Month</th><th>Genre</th><th>Total Titles</th><th>Avg Rating</th><th>Avg Popularity</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse(($trendForecasting ?? []) as $t)
                    <tr>
                      <td>{{ $t->release_year }}</td>
                      <td>{{ $t->release_month }}</td>
                      <td class="fw-semibold">{{ $t->genre_name }}</td>
                      <td>{{ $t->total_titles }}</td>
                      <td>{{ is_null($t->avg_rating) ? '-' : number_format((float)$t->avg_rating, 2) }}</td>
                      <td>{{ is_null($t->avg_popularity) ? '-' : number_format((float)$t->avg_popularity, 2) }}</td>
                    </tr>
                  @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data trend forecasting.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

      {{-- ===========================
           4) Cross-Studio Promotion
           =========================== --}}
      <div class="accordion-item">
        <h2 class="accordion-header" id="h4">
          <a class="accordion-button {{ $section === 4 ? '' : 'collapsed' }}"
             href="/marketing?section=4">
            4) Cross-Studio Promotion & Collaboration
          </a>
        </h2>
        <div id="c4" class="accordion-collapse collapse {{ $section === 4 ? 'show' : '' }}">
          <div class="accordion-body">

            <form class="row g-2 mb-3" method="GET" action="/marketing">
              <input type="hidden" name="section" value="4">
              <div class="col-md-4"><input type="text" name="studio_name" class="form-control" placeholder="Studio name" value="{{ request('studio_name') }}"></div>
              <div class="col-md-3"><input type="text" name="genre_cs" class="form-control" placeholder="Genre" value="{{ request('genre_cs') }}"></div>
              <div class="col-md-3"><input type="number" name="min_titles" class="form-control" placeholder="Min titles" value="{{ request('min_titles') }}"></div>
              <div class="col-md-2 d-grid"><button class="btn btn-primary">Apply</button></div>
            </form>

            <div class="table-responsive">
              <table class="table table-striped table-bordered align-middle">
                <thead>
                  <tr>
                    <th>Studio</th><th>Genre</th><th>Total Titles</th><th>Avg Rating</th><th>Avg Popularity</th><th>Total Engagement</th><th>In Production</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse(($crossStudioPromotion ?? []) as $x)
                    <tr>
                      <td class="fw-semibold">{{ $x->studio_name }}</td>
                      <td>{{ $x->genre_name }}</td>
                      <td>{{ $x->total_titles }}</td>
                      <td>{{ is_null($x->avg_rating) ? '-' : number_format((float)$x->avg_rating, 2) }}</td>
                      <td>{{ is_null($x->avg_popularity) ? '-' : number_format((float)$x->avg_popularity, 2) }}</td>
                      <td>{{ number_format((float)($x->total_engagement ?? 0)) }}</td>
                      <td>{{ $x->in_production_titles ?? 0 }}</td>
                    </tr>
                  @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data cross-studio.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

      {{-- ===========================
           5) Engagement Tracker
           =========================== --}}
      <div class="accordion-item">
        <h2 class="accordion-header" id="h5">
          <a class="accordion-button {{ $section === 5 ? '' : 'collapsed' }}"
             href="/marketing?section=5">
            5) Engagement Tracker
          </a>
        </h2>
        <div id="c5" class="accordion-collapse collapse {{ $section === 5 ? 'show' : '' }}">
          <div class="accordion-body">

            <form class="row g-2 mb-3" method="GET" action="/marketing">
              <input type="hidden" name="section" value="5">
              <div class="col-md-3">
                <select class="form-select" name="engagement_level">
                  <option value="">All Level</option>
                  @foreach(['Massive','High','Medium','Low'] as $lv)
                    <option value="{{ $lv }}" @selected(request('engagement_level') === $lv)>{{ $lv }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3"><input class="form-control" name="min_popularity" placeholder="min popularity" value="{{ request('min_popularity') }}"></div>
              <div class="col-md-4"><input class="form-control" name="type_name_et" placeholder="type_name" value="{{ request('type_name_et') }}"></div>
              <div class="col-md-2 d-grid"><button class="btn btn-primary">Apply</button></div>
            </form>

            <div class="table-responsive">
              <table class="table table-striped table-bordered align-middle">
                <thead>
                  <tr>
                    <th>Show</th><th>Type</th><th>Genres</th><th>Vote Avg</th><th>Vote Count</th><th>Popularity</th><th>Level</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse(($engagementTracker ?? []) as $e)
                    <tr>
                      <td class="fw-semibold">{{ $e->show_name }}</td>
                      <td>{{ $e->content_type }}</td>
                      <td style="max-width: 280px;">{{ $e->genres }}</td>
                      <td>{{ is_null($e->vote_average) ? '-' : number_format((float)$e->vote_average, 2) }}</td>
                      <td>{{ $e->vote_count ?? 0 }}</td>
                      <td>{{ is_null($e->popularity) ? '-' : number_format((float)$e->popularity, 2) }}</td>
                      <td><span class="badge text-bg-secondary">{{ $e->engagement_level }}</span></td>
                    </tr>
                  @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data engagement tracker.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

      {{-- ===========================
           6) Audience Behavior Base
           =========================== --}}
      <div class="accordion-item">
        <h2 class="accordion-header" id="h6">
          <a class="accordion-button {{ $section === 6 ? '' : 'collapsed' }}"
             href="/marketing?section=6">
            6) Audience Behavior Base
          </a>
        </h2>
        <div id="c6" class="accordion-collapse collapse {{ $section === 6 ? 'show' : '' }}">
          <div class="accordion-body">

            <form class="row g-2 mb-3" method="GET" action="/marketing">
              <input type="hidden" name="section" value="6">

              <div class="col-md-2">
                <select class="form-select" name="audience_flag">
                  <option value="">All Flag</option>
                  @foreach(['Adult','General'] as $af)
                    <option value="{{ $af }}" @selected(request('audience_flag') === $af)>{{ $af }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-4">
                <select class="form-select" name="content_lifecycle">
                  <option value="">All Lifecycle</option>
                  @foreach(['Multi-season','Single-season','One-shot / Movie'] as $cl)
                    <option value="{{ $cl }}" @selected(request('content_lifecycle') === $cl)>{{ $cl }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-2">
                <input class="form-control" name="min_votes" placeholder="min votes" value="{{ request('min_votes') }}">
              </div>

              <div class="col-md-2">
                <input class="form-control" name="limit_ab" placeholder="limit (max 100)" value="{{ request('limit_ab', 50) }}">
              </div>

              <div class="col-md-2 d-grid">
                <button class="btn btn-primary">Apply</button>
              </div>
            </form>

            <div class="table-responsive">
              <table class="table table-striped table-bordered align-middle">
                <thead>
                  <tr>
                    <th>Show</th><th>Type</th><th>Genres</th><th>Vote Avg</th><th>Vote Count</th><th>Popularity</th><th>Flag</th><th>Lifecycle</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse(($audienceBehavior ?? []) as $a)
                    <tr>
                      <td class="fw-semibold">{{ $a->show_name }}</td>
                      <td>{{ $a->content_type }}</td>
                      <td style="max-width: 260px;">{{ $a->genres }}</td>
                      <td>{{ is_null($a->vote_average) ? '-' : number_format((float)$a->vote_average, 2) }}</td>
                      <td>{{ $a->vote_count ?? 0 }}</td>
                      <td>{{ is_null($a->popularity) ? '-' : number_format((float)$a->popularity, 2) }}</td>
                      <td><span class="badge text-bg-info">{{ $a->audience_flag }}</span></td>
                      <td><span class="badge text-bg-secondary">{{ $a->content_lifecycle }}</span></td>
                    </tr>
                  @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada data audience behavior.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
