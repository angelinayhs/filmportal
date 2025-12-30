<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Marketing Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --primary:#6366f1;     /* indigo */
      --secondary:#8b5cf6;   /* violet */
      --bg1:#667eea;
      --bg2:#764ba2;
      --card: rgba(255,255,255,.92);
      --border: rgba(255,255,255,.35);
      --shadow: 0 10px 35px rgba(0,0,0,.15);
    }

    body{
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background: linear-gradient(135deg, var(--bg1) 0%, var(--bg2) 100%);
      min-height: 100vh;
      color: #111827;
    }

    .page-wrap{ padding: 22px 0; }

    .topbar{
      background: rgba(255,255,255,.95);
      border: 1px solid var(--border);
      border-radius: 18px;
      box-shadow: var(--shadow);
      padding: 16px 18px;
      margin-bottom: 18px;
      backdrop-filter: blur(14px);
    }
    .topbar h2{
      font-weight: 800;
      margin: 0;
      letter-spacing: -.3px;
      color: #111827;
    }

    /* Accordion polish */
    .accordion-item{
      border: 0;
      border-radius: 18px !important;
      overflow: hidden;
      box-shadow: var(--shadow);
      background: transparent;
      margin-bottom: 14px;
    }
    .accordion-button{
      background: rgba(255,255,255,.95) !important;
      font-weight: 800;
      color: #111827;
      border: 0;
      text-decoration: none;
    }
    .accordion-button:not(.collapsed){
      color: var(--primary);
      box-shadow: none;
    }
    .accordion-body{
      background: rgba(255,255,255,.92);
      backdrop-filter: blur(12px);
    }

    /* Glass cards */
    .card-glass{
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 18px;
      box-shadow: var(--shadow);
    }
    .card-glass .card-header{
      background: transparent;
      border-bottom: 1px solid rgba(17,24,39,.08);
      font-weight: 800;
      padding: 14px 16px;
      display:flex;
      align-items:center;
      justify-content: space-between;
      gap: 10px;
    }
    .card-glass .card-body{
      padding: 14px 16px 18px;
    }

    .muted{ color:#6b7280; font-size: .92rem; }

    .pill{
      font-size:.8rem;
      font-weight:700;
      padding: 6px 10px;
      border-radius: 999px;
      background: rgba(99,102,241,.12);
      color: var(--primary);
      border: 1px solid rgba(99,102,241,.18);
      white-space: nowrap;
    }

    .chart-grid{
      display: grid;
      grid-template-columns: 1fr;
      gap: 14px;
    }
    @media (min-width: 992px){
      .chart-grid{ grid-template-columns: 1.3fr 1fr; }
    }

    .chart-box{
      position: relative;
      height: 360px;
    }
    @media (max-width: 576px){
      .chart-box{ height: 320px; }
    }

    /* Filter panel */
    .filter-panel{
      background: rgba(255,255,255,.95);
      border: 1px solid rgba(255,255,255,.35);
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,.10);
      padding: 12px;
      margin-bottom: 14px;
    }
    .filter-panel .form-control,
    .filter-panel .form-select{
      border-radius: 12px;
    }
    .btn-primary{
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      border: none;
      border-radius: 12px;
      font-weight: 800;
    }
    .btn-outline-danger{
      border-radius: 12px;
      font-weight: 800;
    }
  </style>
</head>

<body>
  <div class="page-wrap">
    <div class="container">

      <div class="topbar d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h2>📊 Marketing Dashboard</h2>

        <form method="POST" action="/logout" class="m-0">
          @csrf
          <button class="btn btn-outline-danger btn-sm">Logout</button>
        </form>
      </div>

      @php
        $section = $section ?? 1;

        $genreSegments = $genreSegments ?? [];
        $ratingSegments = $ratingSegments ?? [];
        $durationSegments = $durationSegments ?? [];

        $campaignPerformance = $campaignPerformance ?? [];
        $trendForecasting = $trendForecasting ?? [];

        $crossStudioPromotion = $crossStudioPromotion ?? [];
        $engagementTracker = $engagementTracker ?? [];
        $audienceBehavior = $audienceBehavior ?? [];
      @endphp

      <div class="accordion" id="marketingAccordion">

        {{-- =========================================================
             1) Audience Segmentation & Profiling (CHART ONLY)
             ========================================================= --}}
        <div class="accordion-item">
          <h2 class="accordion-header" id="h1">
            <a class="accordion-button {{ $section === 1 ? '' : 'collapsed' }}" href="/marketing?section=1">
              1) Audience Segmentation & Profiling
            </a>
          </h2>
          <div id="c1" class="accordion-collapse collapse {{ $section === 1 ? 'show' : '' }}">
            <div class="accordion-body">

              <div class="chart-grid">
                <div class="card card-glass">
                  <div class="card-header">
                    <div>
                      🎭 Genre Segments
                      <div class="muted">Top segment berdasarkan metrik yang kamu pilih.</div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                      <span class="pill" id="genreMetricLabel">Market Share %</span>
                      <select id="genreMetric" class="form-select form-select-sm" style="width: 170px;">
                        <option value="market_share" selected>Market Share %</option>
                        <option value="content_count">Content Count</option>
                        <option value="avg_rating">Avg Rating</option>
                        <option value="avg_popularity">Avg Popularity</option>
                        <option value="total_engagement">Engagement</option>
                      </select>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="chart-box"><canvas id="genreChart"></canvas></div>
                  </div>
                </div>

                <div class="card card-glass">
                  <div class="card-header">
                    <div>
                      Audience Rating Segments
                      <div class="muted">Komposisi segment (Market Share).</div>
                    </div>
                    <span class="pill">Doughnut</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box"><canvas id="ratingChart"></canvas></div>
                  </div>
                </div>

                <div class="card card-glass" style="grid-column: 1 / -1;">
                  <div class="card-header">
                    <div>
                      ⏱️ Duration Segments
                      <div class="muted">Perbandingan Market Share & Content Count.</div>
                    </div>
                    <span class="pill">Bar</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box" style="height: 380px;"><canvas id="durationChart"></canvas></div>
                  </div>
                </div>

                @if(empty($genreSegments) && empty($ratingSegments) && empty($durationSegments))
                  <div class="card card-glass" style="grid-column: 1 / -1;">
                    <div class="card-body text-center text-muted py-4">Tidak ada data untuk section 1.</div>
                  </div>
                @endif
              </div>

            </div>
          </div>
        </div>

        {{-- =========================================================
             2) Campaign Performance (CHART ONLY + FILTER)
             ========================================================= --}}
        <div class="accordion-item">
          <h2 class="accordion-header" id="h2">
            <a class="accordion-button {{ $section === 2 ? '' : 'collapsed' }}" href="/marketing?section=2">
              2) Campaign Performance
            </a>
          </h2>
          <div id="c2" class="accordion-collapse collapse {{ $section === 2 ? 'show' : '' }}">
            <div class="accordion-body">

              <div class="filter-panel">
                <form class="row g-2 align-items-end" method="GET" action="/marketing">
                  <input type="hidden" name="section" value="2">

                  <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold mb-1">Period</label>
                    <select class="form-select" name="period_bucket">
                      <option value="">All Period</option>
                      @foreach(['Last 7 Days','Last 30 Days','Older'] as $p)
                        <option value="{{ $p }}" @selected(request('period_bucket') === $p)>{{ $p }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold mb-1">Type Name</label>
                    <input class="form-control" name="type_name" placeholder="ex: Scripted" value="{{ request('type_name') }}">
                  </div>

                  <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-bold mb-1">Min Score</label>
                    <input class="form-control" name="min_score" placeholder="min score" value="{{ request('min_score') }}">
                  </div>

                  <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-bold mb-1">Limit</label>
                    <input class="form-control" name="limit" placeholder="max 100" value="{{ request('limit', 50) }}">
                  </div>

                  <div class="col-lg-2 col-md-12 d-grid">
                    <button class="btn btn-primary">Apply</button>
                  </div>
                </form>
              </div>

              <div class="chart-grid">
                <div class="card card-glass">
                  <div class="card-header">
                    <div>
                      🚀 Top Campaign Score
                      <div class="muted">Top berdasarkan <b>campaign_score</b> dari hasil filter.</div>
                    </div>
                    <span class="pill">Bar</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box"><canvas id="campaignTopScoreChart"></canvas></div>
                  </div>
                </div>

                <div class="card card-glass">
                  <div class="card-header">
                    <div>
                      🧩 Period Bucket Distribution
                      <div class="muted">Proporsi konten per bucket.</div>
                    </div>
                    <span class="pill">Doughnut</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box"><canvas id="campaignBucketChart"></canvas></div>
                  </div>
                </div>

                <div class="card card-glass" style="grid-column: 1 / -1;">
                  <div class="card-header">
                    <div>
                      📌 Rating vs Popularity
                      <div class="muted">Bubble size = Votes (total_votes).</div>
                    </div>
                    <span class="pill">Bubble</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box" style="height: 380px;"><canvas id="campaignBubbleChart"></canvas></div>
                  </div>
                </div>

                @if(empty($campaignPerformance))
                  <div class="card card-glass" style="grid-column: 1 / -1;">
                    <div class="card-body text-center text-muted py-4">
                      Data campaign kosong untuk filter ini. Coba longgarkan filter / limit.
                    </div>
                  </div>
                @endif
              </div>

            </div>
          </div>
        </div>

        {{-- =========================================================
             3) Trend Forecasting (CHART ONLY + FILTER)
             ========================================================= --}}
        <div class="accordion-item">
          <h2 class="accordion-header" id="h3">
            <a class="accordion-button {{ $section === 3 ? '' : 'collapsed' }}" href="/marketing?section=3">
              3) Trend Forecasting (Release Trend)
            </a>
          </h2>
          <div id="c3" class="accordion-collapse collapse {{ $section === 3 ? 'show' : '' }}">
            <div class="accordion-body">

              <div class="filter-panel">
                <form class="row g-2 align-items-end" method="GET" action="/marketing">
                  <input type="hidden" name="section" value="3">

                  <div class="col-md-3">
                    <label class="form-label fw-bold mb-1">Year From</label>
                    <input type="number" name="year_from" class="form-control" placeholder="Year From" value="{{ request('year_from') }}">
                  </div>

                  <div class="col-md-3">
                    <label class="form-label fw-bold mb-1">Year To</label>
                    <input type="number" name="year_to" class="form-control" placeholder="Year To" value="{{ request('year_to') }}">
                  </div>

                  <div class="col-md-4">
                    <label class="form-label fw-bold mb-1">Genre (exact)</label>
                    <input type="text" name="genre" class="form-control" placeholder="Genre (exact)" value="{{ request('genre') }}">
                  </div>

                  <div class="col-md-2 d-grid">
                    <button class="btn btn-primary">Apply</button>
                  </div>
                </form>
              </div>

              <div class="chart-grid">
                <div class="card card-glass">
                  <div class="card-header">
                    <div>
                      📈 Release Trend (Total Titles)
                      <div class="muted">Total rilis per bulan (hasil filter).</div>
                    </div>
                    <span class="pill">Line</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box"><canvas id="trendTitlesChart"></canvas></div>
                  </div>
                </div>

                <div class="card card-glass">
                  <div class="card-header">
                    <div>
                      🏷️ Top Genres (by Titles)
                      <div class="muted">Top 10 genre berdasarkan jumlah title.</div>
                    </div>
                    <span class="pill">Bar</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box"><canvas id="trendGenresChart"></canvas></div>
                  </div>
                </div>

                @if(empty($trendForecasting))
                  <div class="card card-glass" style="grid-column: 1 / -1;">
                    <div class="card-body text-center text-muted py-4">
                      Tidak ada data trend forecasting untuk filter ini. Coba ubah year/genre.
                    </div>
                  </div>
                @endif
              </div>

            </div>
          </div>
        </div>

        {{-- =========================================================
             4) Cross-Studio Promotion (CHART ONLY + FILTER)
             ========================================================= --}}
        <div class="accordion-item">
          <h2 class="accordion-header" id="h4">
            <a class="accordion-button {{ $section === 4 ? '' : 'collapsed' }}" href="/marketing?section=4">
              4) Cross-Studio Promotion & Collaboration
            </a>
          </h2>
          <div id="c4" class="accordion-collapse collapse {{ $section === 4 ? 'show' : '' }}">
            <div class="accordion-body">

              <div class="filter-panel">
                <form class="row g-2 align-items-end" method="GET" action="/marketing">
                  <input type="hidden" name="section" value="4">

                  <div class="col-md-4">
                    <label class="form-label fw-bold mb-1">Studio name</label>
                    <input type="text" name="studio_name" class="form-control" placeholder="Studio name" value="{{ request('studio_name') }}">
                  </div>

                  <div class="col-md-3">
                    <label class="form-label fw-bold mb-1">Genre</label>
                    <input type="text" name="genre_cs" class="form-control" placeholder="Genre" value="{{ request('genre_cs') }}">
                  </div>

                  <div class="col-md-3">
                    <label class="form-label fw-bold mb-1">Min titles</label>
                    <input type="number" name="min_titles" class="form-control" placeholder="Min titles" value="{{ request('min_titles') }}">
                  </div>

                  <div class="col-md-2 d-grid">
                    <button class="btn btn-primary">Apply</button>
                  </div>
                </form>
              </div>

              <div class="chart-grid">
                <div class="card card-glass">
                  <div class="card-header">
                    <div>
                      🏢 Top Studios (Total Titles)
                      <div class="muted">Ranking studio berdasarkan total_titles.</div>
                    </div>
                    <span class="pill">Bar</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box"><canvas id="csTopStudiosChart"></canvas></div>
                  </div>
                </div>

                <div class="card card-glass">
                  <div class="card-header">
                    <div>
                      🎬 In Production Share
                      <div class="muted">Proporsi judul yang masih produksi.</div>
                    </div>
                    <span class="pill">Doughnut</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box"><canvas id="csProdShareChart"></canvas></div>
                  </div>
                </div>

                <div class="card card-glass" style="grid-column: 1 / -1;">
                  <div class="card-header">
                    <div>
                      ⭐ Rating vs Popularity (Studio/Genre)
                      <div class="muted">Bubble size = Total Engagement.</div>
                    </div>
                    <span class="pill">Bubble</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box" style="height: 380px;"><canvas id="csBubbleChart"></canvas></div>
                  </div>
                </div>

                @if(empty($crossStudioPromotion))
                  <div class="card card-glass" style="grid-column: 1 / -1;">
                    <div class="card-body text-center text-muted py-4">
                      Tidak ada data cross-studio untuk filter ini.
                    </div>
                  </div>
                @endif
              </div>

            </div>
          </div>
        </div>

        {{-- =========================================================
             5) Engagement Tracker (CHART ONLY + FILTER)
             ========================================================= --}}
        <div class="accordion-item">
          <h2 class="accordion-header" id="h5">
            <a class="accordion-button {{ $section === 5 ? '' : 'collapsed' }}" href="/marketing?section=5">
              5) Engagement Tracker
            </a>
          </h2>
          <div id="c5" class="accordion-collapse collapse {{ $section === 5 ? 'show' : '' }}">
            <div class="accordion-body">

              <div class="filter-panel">
                <form class="row g-2 align-items-end" method="GET" action="/marketing">
                  <input type="hidden" name="section" value="5">

                  <div class="col-md-3">
                    <label class="form-label fw-bold mb-1">Engagement Level</label>
                    <select class="form-select" name="engagement_level">
                      <option value="">All Level</option>
                      @foreach(['Massive','High','Medium','Low'] as $lv)
                        <option value="{{ $lv }}" @selected(request('engagement_level') === $lv)>{{ $lv }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label fw-bold mb-1">Min Popularity</label>
                    <input class="form-control" name="min_popularity" placeholder="min popularity" value="{{ request('min_popularity') }}">
                  </div>

                  <div class="col-md-4">
                    <label class="form-label fw-bold mb-1">Type Name</label>
                    <input class="form-control" name="type_name_et" placeholder="type_name" value="{{ request('type_name_et') }}">
                  </div>

                  <div class="col-md-2 d-grid">
                    <button class="btn btn-primary">Apply</button>
                  </div>
                </form>
              </div>

              <div class="chart-grid">
                <div class="card card-glass">
                  <div class="card-header">
                    <div>
                      🔥 Engagement Level Distribution
                      <div class="muted">Jumlah konten per level.</div>
                    </div>
                    <span class="pill">Doughnut</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box"><canvas id="etLevelChart"></canvas></div>
                  </div>
                </div>

                <div class="card card-glass">
                  <div class="card-header">
                    <div>
                      🚀 Top Shows by Popularity
                      <div class="muted">Top berdasarkan popularity.</div>
                    </div>
                    <span class="pill">Bar</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box"><canvas id="etTopPopularityChart"></canvas></div>
                  </div>
                </div>

                <div class="card card-glass" style="grid-column: 1 / -1;">
                  <div class="card-header">
                    <div>
                      ⭐ Rating vs Popularity
                      <div class="muted">Bubble size = Vote Count.</div>
                    </div>
                    <span class="pill">Bubble</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box" style="height: 380px;"><canvas id="etBubbleChart"></canvas></div>
                  </div>
                </div>

                @if(empty($engagementTracker))
                  <div class="card card-glass" style="grid-column: 1 / -1;">
                    <div class="card-body text-center text-muted py-4">
                      Tidak ada data engagement tracker untuk filter ini.
                    </div>
                  </div>
                @endif
              </div>

            </div>
          </div>
        </div>

        {{-- =========================================================
             6) Audience Behavior Base (CHART ONLY + FILTER)
             ========================================================= --}}
        <div class="accordion-item">
          <h2 class="accordion-header" id="h6">
            <a class="accordion-button {{ $section === 6 ? '' : 'collapsed' }}" href="/marketing?section=6">
              6) Audience Behavior Base
            </a>
          </h2>
          <div id="c6" class="accordion-collapse collapse {{ $section === 6 ? 'show' : '' }}">
            <div class="accordion-body">

              <div class="filter-panel">
                <form class="row g-2 align-items-end" method="GET" action="/marketing">
                  <input type="hidden" name="section" value="6">

                  <div class="col-md-2">
                    <label class="form-label fw-bold mb-1">Audience Flag</label>
                    <select class="form-select" name="audience_flag">
                      <option value="">All Flag</option>
                      @foreach(['Adult','General'] as $af)
                        <option value="{{ $af }}" @selected(request('audience_flag') === $af)>{{ $af }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label class="form-label fw-bold mb-1">Content Lifecycle</label>
                    <select class="form-select" name="content_lifecycle">
                      <option value="">All Lifecycle</option>
                      @foreach(['Multi-season','Single-season','One-shot / Movie'] as $cl)
                        <option value="{{ $cl }}" @selected(request('content_lifecycle') === $cl)>{{ $cl }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-2">
                    <label class="form-label fw-bold mb-1">Min Votes</label>
                    <input class="form-control" name="min_votes" placeholder="min votes" value="{{ request('min_votes') }}">
                  </div>

                  <div class="col-md-2">
                    <label class="form-label fw-bold mb-1">Limit</label>
                    <input class="form-control" name="limit_ab" placeholder="max 100" value="{{ request('limit_ab', 50) }}">
                  </div>

                  <div class="col-md-2 d-grid">
                    <button class="btn btn-primary">Apply</button>
                  </div>
                </form>
              </div>

              <div class="chart-grid">
                <div class="card card-glass">
                  <div class="card-header">
                    <div>
                      🏷️ Audience Flag Distribution
                      <div class="muted">Komposisi konten Adult vs General.</div>
                    </div>
                    <span class="pill">Doughnut</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box"><canvas id="abFlagChart"></canvas></div>
                  </div>
                </div>

                <div class="card card-glass">
                  <div class="card-header">
                    <div>
                      🔁 Lifecycle Distribution
                      <div class="muted">Komposisi berdasarkan lifecycle.</div>
                    </div>
                    <span class="pill">Bar</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box"><canvas id="abLifecycleChart"></canvas></div>
                  </div>
                </div>

                <div class="card card-glass" style="grid-column: 1 / -1;">
                  <div class="card-header">
                    <div>
                      ⭐ Rating vs Popularity
                      <div class="muted">Bubble size = Vote Count.</div>
                    </div>
                    <span class="pill">Bubble</span>
                  </div>
                  <div class="card-body">
                    <div class="chart-box" style="height: 380px;"><canvas id="abBubbleChart"></canvas></div>
                  </div>
                </div>

                @if(empty($audienceBehavior))
                  <div class="card card-glass" style="grid-column: 1 / -1;">
                    <div class="card-body text-center text-muted py-4">
                      Tidak ada data audience behavior untuk filter ini.
                    </div>
                  </div>
                @endif
              </div>

            </div>
          </div>
        </div>

      </div>{{-- /accordion --}}
    </div>{{-- /container --}}
  </div>{{-- /page-wrap --}}

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <script>
    // =========================
    // DATA dari Laravel
    // =========================
    const GENRE    = @json($genreSegments ?? []);
    const RATING   = @json($ratingSegments ?? []);
    const DURATION = @json($durationSegments ?? []);

    const CAMPAIGN = @json($campaignPerformance ?? []);
    const TREND    = @json($trendForecasting ?? []);

    const CROSS    = @json($crossStudioPromotion ?? []);
    const ENG      = @json($engagementTracker ?? []);
    const AB       = @json($audienceBehavior ?? []);

    const num = (v) => {
      const n = Number(v);
      return Number.isFinite(n) ? n : 0;
    };

    Chart.defaults.font.family = "Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif";
    Chart.defaults.color = "#111827";

    // helper gradient
    const GRAD = (ctx, a=0.95, b=0.85) => {
      const chart = ctx.chart;
      const {ctx: c, chartArea} = chart;
      if (!chartArea) return `rgba(99,102,241,${a})`;
      const g = c.createLinearGradient(chartArea.left, 0, chartArea.right, 0);
      g.addColorStop(0, `rgba(99,102,241,${a})`);
      g.addColorStop(1, `rgba(139,92,246,${b})`);
      return g;
    };

    // =========================
    // SECTION 1 charts
    // =========================
    let genreChart, ratingChart, durationChart;

    function buildGenreChart(metricKey){
      const labels = GENRE.map(x => x.segment_name);
      const values = GENRE.map(x => num(x[metricKey]));

      const labelMap = {
        market_share: "Market Share %",
        content_count: "Content Count",
        avg_rating: "Avg Rating",
        avg_popularity: "Avg Popularity",
        total_engagement: "Engagement",
      };

      const metricLabel = labelMap[metricKey] ?? metricKey;
      const labelEl = document.getElementById("genreMetricLabel");
      if (labelEl) labelEl.textContent = metricLabel;

      if (genreChart) genreChart.destroy();
      const el = document.getElementById("genreChart");
      if (!el) return;

      genreChart = new Chart(el, {
        type: "bar",
        data: {
          labels,
          datasets: [{
            label: metricLabel,
            data: values,
            borderRadius: 10,
            borderWidth: 1,
            backgroundColor: (ctx) => GRAD(ctx, .95, .85),
            borderColor: "rgba(99,102,241,.35)",
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: (ctx) => {
                  const val = ctx.raw ?? 0;
                  return metricKey === "market_share"
                    ? ` ${metricLabel}: ${Number(val).toFixed(2)}%`
                    : ` ${metricLabel}: ${Number(val).toLocaleString()}`;
                }
              }
            }
          },
          scales: {
            x: { ticks: { maxRotation: 0, autoSkip: true }, grid: { display: false } },
            y: { grid: { color: "rgba(17,24,39,.08)" }, beginAtZero: true }
          }
        }
      });
    }

    function buildRatingChart(){
      const labels = RATING.map(x => x.segment_name);
      const values = RATING.map(x => num(x.market_share));

      if (ratingChart) ratingChart.destroy();
      const el = document.getElementById("ratingChart");
      if (!el) return;

      ratingChart = new Chart(el, {
        type: "doughnut",
        data: {
          labels,
          datasets: [{
            label: "Market Share %",
            data: values,
            borderWidth: 1,
            hoverOffset: 6,
            cutout: "62%",
            backgroundColor: [
              "rgba(99,102,241,.80)",
              "rgba(139,92,246,.75)",
              "rgba(99,102,241,.45)",
              "rgba(139,92,246,.45)",
              "rgba(99,102,241,.25)",
            ]
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: "bottom" },
            tooltip: { callbacks: { label: (ctx) => ` ${ctx.label}: ${num(ctx.raw).toFixed(2)}%` } }
          }
        }
      });
    }

    function buildDurationChart(){
      const labels = DURATION.map(x => x.segment_name);
      const share = DURATION.map(x => num(x.market_share));
      const count = DURATION.map(x => num(x.content_count));

      if (durationChart) durationChart.destroy();
      const el = document.getElementById("durationChart");
      if (!el) return;

      durationChart = new Chart(el, {
        type: "bar",
        data: {
          labels,
          datasets: [
            {
              label: "Market Share %",
              data: share,
              borderRadius: 10,
              borderWidth: 1,
              backgroundColor: "rgba(99,102,241,.75)",
              borderColor: "rgba(99,102,241,.25)",
            },
            {
              label: "Content Count",
              data: count,
              borderRadius: 10,
              borderWidth: 1,
              backgroundColor: "rgba(139,92,246,.65)",
              borderColor: "rgba(139,92,246,.25)",
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { position: "bottom" } },
          scales: {
            x: { grid: { display: false } },
            y: { grid: { color: "rgba(17,24,39,.08)" }, beginAtZero: true }
          }
        }
      });
    }

    function initSegmentationCharts(){
      if (!document.getElementById("genreChart")) return;
      buildGenreChart("market_share");
      buildRatingChart();
      buildDurationChart();

      const metricSel = document.getElementById("genreMetric");
      if (metricSel){
        metricSel.addEventListener("change", (e) => buildGenreChart(e.target.value));
      }
    }

    // =========================
    // SECTION 2 charts (Campaign)
    // =========================
    let topScoreChart, bucketChart, bubbleChart;

    function buildCampaignTopScore(){
      const el = document.getElementById("campaignTopScoreChart");
      if (!el) return;

      const list = [...CAMPAIGN].sort((a,b)=> num(b.campaign_score) - num(a.campaign_score));
      const labels = list.map(x => x.show_name);
      const scores = list.map(x => num(x.campaign_score));

      if (topScoreChart) topScoreChart.destroy();

      topScoreChart = new Chart(el, {
        type: "bar",
        data: {
          labels,
          datasets: [{
            label: "Campaign Score",
            data: scores,
            borderRadius: 10,
            borderWidth: 1,
            backgroundColor: (ctx) => GRAD(ctx, .95, .85),
            borderColor: "rgba(99,102,241,.35)",
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: (ctx) => ` Score: ${num(ctx.raw).toLocaleString(undefined, {maximumFractionDigits: 2})}` } }
          },
          scales: {
            x: {
              grid: { display: false },
              ticks: {
                callback: function(value) {
                  const label = this.getLabelForValue(value);
                  return String(label).length > 18 ? String(label).slice(0,18)+'…' : label;
                }
              }
            },
            y: { beginAtZero: true, grid: { color: "rgba(17,24,39,.08)" } }
          }
        }
      });
    }

    function buildCampaignBucket(){
      const el = document.getElementById("campaignBucketChart");
      if (!el) return;

      const buckets = {};
      for (const row of CAMPAIGN){
        const k = row.campaign_period_bucket || "Unknown";
        buckets[k] = (buckets[k] || 0) + 1;
      }
      const labels = Object.keys(buckets);
      const values = labels.map(k => buckets[k]);

      if (bucketChart) bucketChart.destroy();

      bucketChart = new Chart(el, {
        type: "doughnut",
        data: {
          labels,
          datasets: [{
            label: "Count",
            data: values,
            borderWidth: 1,
            cutout: "62%",
            backgroundColor: [
              "rgba(99,102,241,.80)",
              "rgba(139,92,246,.75)",
              "rgba(99,102,241,.45)",
              "rgba(139,92,246,.45)",
              "rgba(99,102,241,.25)",
            ]
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: "bottom" },
            tooltip: { callbacks: { label: (ctx) => ` ${ctx.label}: ${num(ctx.raw)} items` } }
          }
        }
      });
    }

    function buildCampaignBubble(){
      const el = document.getElementById("campaignBubbleChart");
      if (!el) return;

      const points = CAMPAIGN.map(x => {
        const votes = num(x.total_votes);
        const r = Math.max(4, Math.min(18, Math.sqrt(votes) / 20));
        return {
          x: num(x.popularity),
          y: num(x.avg_rating),
          r,
          _name: x.show_name,
          _votes: votes,
          _bucket: x.campaign_period_bucket || "-"
        };
      }).filter(p => p.x !== 0 || p.y !== 0);

      if (bubbleChart) bubbleChart.destroy();

      bubbleChart = new Chart(el, {
        type: "bubble",
        data: {
          datasets: [{
            label: "Shows",
            data: points,
            backgroundColor: "rgba(99,102,241,.35)",
            borderColor: "rgba(99,102,241,.55)",
            borderWidth: 1,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: (ctx) => {
                  const p = ctx.raw;
                  return [
                    ` ${p._name}`,
                    ` Rating: ${num(p.y).toFixed(2)} | Popularity: ${num(p.x).toFixed(2)}`,
                    ` Votes: ${num(p._votes).toLocaleString()} | Bucket: ${p._bucket}`
                  ];
                }
              }
            }
          },
          scales: {
            x: { title: { display: true, text: "Popularity" }, grid: { color: "rgba(17,24,39,.08)" } },
            y: { title: { display: true, text: "Avg Rating" }, grid: { color: "rgba(17,24,39,.08)" }, beginAtZero: true }
          }
        }
      });
    }

    function initCampaignCharts(){
      if (!document.getElementById("campaignTopScoreChart")) return;
      if (!Array.isArray(CAMPAIGN) || CAMPAIGN.length === 0) return;
      buildCampaignTopScore(); buildCampaignBucket(); buildCampaignBubble();
    }

    // =========================
    // SECTION 3 charts (Trend)
    // =========================
    let trendTitlesChart, trendGenresChart;

    function ymLabel(y,m){
      const mm = String(m).padStart(2,'0');
      return `${y}-${mm}`;
    }

    function buildTrendCharts(){
      const el1 = document.getElementById("trendTitlesChart");
      const el2 = document.getElementById("trendGenresChart");
      if (!el1 || !el2) return;
      if (!Array.isArray(TREND) || TREND.length === 0) return;

      const rows = TREND.map(r => ({
        year: Number(r.release_year ?? 0),
        month: Number(r.release_month ?? 0),
        genre: (r.genre_name ?? '').toString().trim(),
        total_titles: num(r.total_titles),
      })).filter(x => x.year && x.month);

      const byMonth = new Map();
      for(const r of rows){
        const key = ymLabel(r.year, r.month);
        byMonth.set(key, (byMonth.get(key) || 0) + r.total_titles);
      }
      const monthKeys = Array.from(byMonth.keys()).sort((a,b)=>a.localeCompare(b));
      const titlesSeries = monthKeys.map(k => byMonth.get(k));

      const byGenre = new Map();
      for(const r of rows){
        const g = r.genre || "(Unknown)";
        byGenre.set(g, (byGenre.get(g) || 0) + r.total_titles);
      }
      const topGenres = Array.from(byGenre.entries()).sort((a,b)=>b[1]-a[1]).slice(0,10);
      const gLabels = topGenres.map(x=>x[0]);
      const gVals = topGenres.map(x=>x[1]);

      if (trendTitlesChart) trendTitlesChart.destroy();
      if (trendGenresChart) trendGenresChart.destroy();

      trendTitlesChart = new Chart(el1, {
        type: "line",
        data: {
          labels: monthKeys,
          datasets: [{
            label: "Total Titles",
            data: titlesSeries,
            borderWidth: 3,
            tension: .35,
            fill: true,
            pointRadius: 2,
            borderColor: "rgba(99,102,241,.85)",
            backgroundColor: "rgba(99,102,241,.18)",
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } },
          interaction: { mode: "index", intersect: false },
          scales: {
            x: { grid: { display:false }, ticks: { maxRotation:45, minRotation:45 } },
            y: { beginAtZero:true, grid: { color:"rgba(17,24,39,.08)" } }
          }
        }
      });

      trendGenresChart = new Chart(el2, {
        type: "bar",
        data: {
          labels: gLabels,
          datasets: [{
            label: "Total Titles",
            data: gVals,
            borderRadius: 10,
            borderWidth: 1,
            backgroundColor: "rgba(139,92,246,.65)",
            borderColor: "rgba(139,92,246,.25)",
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } },
          scales: {
            x: { grid: { display:false }, ticks: { maxRotation:45, minRotation:45 } },
            y: { beginAtZero:true, grid: { color:"rgba(17,24,39,.08)" } }
          }
        }
      });
    }

    // =========================
    // SECTION 4 charts (Cross-Studio)
    // =========================
    let csTopStudiosChart, csProdShareChart, csBubbleChart;

    function buildCrossStudioCharts(){
      const elA = document.getElementById("csTopStudiosChart");
      const elB = document.getElementById("csProdShareChart");
      const elC = document.getElementById("csBubbleChart");
      if (!elA || !elB || !elC) return;
      if (!Array.isArray(CROSS) || CROSS.length === 0) return;

      const list = [...CROSS].sort((a,b)=>num(b.total_titles)-num(a.total_titles));
      const top = list.slice(0,10);

      // Top studios bar
      if (csTopStudiosChart) csTopStudiosChart.destroy();
      csTopStudiosChart = new Chart(elA, {
        type:"bar",
        data:{
          labels: top.map(x=>x.studio_name),
          datasets:[{
            label:"Total Titles",
            data: top.map(x=>num(x.total_titles)),
            borderRadius:10,
            borderWidth:1,
            backgroundColor:(ctx)=>GRAD(ctx,.95,.85),
            borderColor:"rgba(99,102,241,.35)"
          }]
        },
        options:{
          responsive:true, maintainAspectRatio:false,
          plugins:{ legend:{display:false}},
          scales:{
            x:{ grid:{display:false}, ticks:{ callback:function(v){ const t=this.getLabelForValue(v); return String(t).length>14?String(t).slice(0,14)+'…':t; } } },
            y:{ beginAtZero:true, grid:{ color:"rgba(17,24,39,.08)" } }
          }
        }
      });

      // Production share doughnut
      const prod = CROSS.reduce((acc,x)=>acc+num(x.in_production_titles),0);
      const total = CROSS.reduce((acc,x)=>acc+num(x.total_titles),0);
      const notProd = Math.max(0, total - prod);

      if (csProdShareChart) csProdShareChart.destroy();
      csProdShareChart = new Chart(elB, {
        type:"doughnut",
        data:{
          labels:["In Production","Released/Other"],
          datasets:[{
            data:[prod, notProd],
            cutout:"62%",
            borderWidth:1,
            backgroundColor:["rgba(139,92,246,.75)","rgba(99,102,241,.35)"]
          }]
        },
        options:{
          responsive:true, maintainAspectRatio:false,
          plugins:{ legend:{ position:"bottom" } }
        }
      });

      // Bubble: x=avg_popularity, y=avg_rating, r=engagement scaled
      const points = CROSS.map(x=>{
        const eng = num(x.total_engagement);
        const r = Math.max(5, Math.min(20, Math.sqrt(eng)/60));
        return {
          x: num(x.avg_popularity),
          y: num(x.avg_rating),
          r,
          _studio: x.studio_name,
          _genre: x.genre_name,
          _titles: num(x.total_titles),
          _eng: eng
        };
      }).filter(p=>p.x!==0 || p.y!==0);

      if (csBubbleChart) csBubbleChart.destroy();
      csBubbleChart = new Chart(elC,{
        type:"bubble",
        data:{ datasets:[{
          label:"Studio/Genre",
          data: points,
          backgroundColor:"rgba(139,92,246,.28)",
          borderColor:"rgba(139,92,246,.55)",
          borderWidth:1
        }]},
        options:{
          responsive:true, maintainAspectRatio:false,
          plugins:{
            legend:{display:false},
            tooltip:{ callbacks:{
              label:(ctx)=>{
                const p=ctx.raw;
                return [
                  ` ${p._studio} — ${p._genre}`,
                  ` Rating: ${num(p.y).toFixed(2)} | Popularity: ${num(p.x).toFixed(2)}`,
                  ` Titles: ${num(p._titles).toLocaleString()} | Engagement: ${num(p._eng).toLocaleString()}`
                ];
              }
            }}
          },
          scales:{
            x:{ title:{display:true,text:"Avg Popularity"}, grid:{ color:"rgba(17,24,39,.08)" } },
            y:{ title:{display:true,text:"Avg Rating"}, grid:{ color:"rgba(17,24,39,.08)" }, beginAtZero:true }
          }
        }
      });
    }

    // =========================
    // SECTION 5 charts (Engagement Tracker)
    // =========================
    let etLevelChart, etTopPopularityChart, etBubbleChart;

    function buildEngagementCharts(){
      const elA = document.getElementById("etLevelChart");
      const elB = document.getElementById("etTopPopularityChart");
      const elC = document.getElementById("etBubbleChart");
      if (!elA || !elB || !elC) return;
      if (!Array.isArray(ENG) || ENG.length === 0) return;

      // Level distribution
      const levels = {};
      for(const r of ENG){
        const k = (r.engagement_level || "Unknown");
        levels[k] = (levels[k] || 0) + 1;
      }
      const lLabels = Object.keys(levels);
      const lVals = lLabels.map(k=>levels[k]);

      if (etLevelChart) etLevelChart.destroy();
      etLevelChart = new Chart(elA,{
        type:"doughnut",
        data:{
          labels:lLabels,
          datasets:[{
            data:lVals,
            cutout:"62%",
            borderWidth:1,
            backgroundColor:[
              "rgba(99,102,241,.80)",
              "rgba(139,92,246,.75)",
              "rgba(99,102,241,.45)",
              "rgba(139,92,246,.45)",
              "rgba(99,102,241,.25)",
            ]
          }]
        },
        options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ position:"bottom" } } }
      });

      // Top popularity bar
      const top = [...ENG].sort((a,b)=>num(b.popularity)-num(a.popularity)).slice(0,12);

      if (etTopPopularityChart) etTopPopularityChart.destroy();
      etTopPopularityChart = new Chart(elB,{
        type:"bar",
        data:{
          labels: top.map(x=>x.show_name),
          datasets:[{
            label:"Popularity",
            data: top.map(x=>num(x.popularity)),
            borderRadius:10,
            borderWidth:1,
            backgroundColor:"rgba(99,102,241,.70)",
            borderColor:"rgba(99,102,241,.25)"
          }]
        },
        options:{
          responsive:true, maintainAspectRatio:false,
          plugins:{ legend:{ display:false } },
          scales:{
            x:{ grid:{display:false}, ticks:{ callback:function(v){ const t=this.getLabelForValue(v); return String(t).length>16?String(t).slice(0,16)+'…':t; } } },
            y:{ beginAtZero:true, grid:{ color:"rgba(17,24,39,.08)" } }
          }
        }
      });

      // Bubble: x=popularity, y=vote_average, r=vote_count
      const points = ENG.map(x=>{
        const votes = num(x.vote_count);
        const r = Math.max(4, Math.min(18, Math.sqrt(votes)/20));
        return {
          x: num(x.popularity),
          y: num(x.vote_average),
          r,
          _name: x.show_name,
          _type: x.content_type,
          _votes: votes,
          _lv: x.engagement_level
        };
      }).filter(p=>p.x!==0 || p.y!==0);

      if (etBubbleChart) etBubbleChart.destroy();
      etBubbleChart = new Chart(elC,{
        type:"bubble",
        data:{ datasets:[{
          label:"Shows",
          data: points,
          backgroundColor:"rgba(99,102,241,.30)",
          borderColor:"rgba(99,102,241,.55)",
          borderWidth:1
        }]},
        options:{
          responsive:true, maintainAspectRatio:false,
          plugins:{
            legend:{display:false},
            tooltip:{ callbacks:{ label:(ctx)=>{
              const p=ctx.raw;
              return [
                ` ${p._name}`,
                ` Rating: ${num(p.y).toFixed(2)} | Popularity: ${num(p.x).toFixed(2)}`,
                ` Votes: ${num(p._votes).toLocaleString()} | Level: ${p._lv} | Type: ${p._type}`
              ];
            }}}
          },
          scales:{
            x:{ title:{display:true,text:"Popularity"}, grid:{ color:"rgba(17,24,39,.08)" } },
            y:{ title:{display:true,text:"Vote Avg"}, grid:{ color:"rgba(17,24,39,.08)" }, beginAtZero:true }
          }
        }
      });
    }

    // =========================
    // SECTION 6 charts (Audience Behavior Base)
    // =========================
    let abFlagChart, abLifecycleChart, abBubbleChart;

    function buildAudienceBehaviorCharts(){
      const elA = document.getElementById("abFlagChart");
      const elB = document.getElementById("abLifecycleChart");
      const elC = document.getElementById("abBubbleChart");
      if (!elA || !elB || !elC) return;
      if (!Array.isArray(AB) || AB.length === 0) return;

      // Flag distribution
      const flags = {};
      for(const r of AB){
        const k = (r.audience_flag || "Unknown");
        flags[k] = (flags[k] || 0) + 1;
      }
      const fLabels = Object.keys(flags);
      const fVals = fLabels.map(k=>flags[k]);

      if (abFlagChart) abFlagChart.destroy();
      abFlagChart = new Chart(elA,{
        type:"doughnut",
        data:{
          labels:fLabels,
          datasets:[{
            data:fVals,
            cutout:"62%",
            borderWidth:1,
            backgroundColor:["rgba(99,102,241,.80)","rgba(139,92,246,.70)","rgba(99,102,241,.35)"]
          }]
        },
        options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ position:"bottom" } } }
      });

      // Lifecycle distribution (bar)
      const life = {};
      for(const r of AB){
        const k = (r.content_lifecycle || "Unknown");
        life[k] = (life[k] || 0) + 1;
      }
      const lLabels = Object.keys(life);
      const lVals = lLabels.map(k=>life[k]);

      if (abLifecycleChart) abLifecycleChart.destroy();
      abLifecycleChart = new Chart(elB,{
        type:"bar",
        data:{
          labels:lLabels,
          datasets:[{
            label:"Count",
            data:lVals,
            borderRadius:10,
            borderWidth:1,
            backgroundColor:"rgba(139,92,246,.65)",
            borderColor:"rgba(139,92,246,.25)"
          }]
        },
        options:{
          responsive:true, maintainAspectRatio:false,
          plugins:{ legend:{ display:false } },
          scales:{
            x:{ grid:{ display:false } },
            y:{ beginAtZero:true, grid:{ color:"rgba(17,24,39,.08)" } }
          }
        }
      });

      // Bubble: x=popularity, y=vote_average, r=vote_count
      const points = AB.map(x=>{
        const votes = num(x.vote_count);
        const r = Math.max(4, Math.min(18, Math.sqrt(votes)/20));
        return {
          x: num(x.popularity),
          y: num(x.vote_average),
          r,
          _name: x.show_name,
          _type: x.content_type,
          _flag: x.audience_flag,
          _life: x.content_lifecycle,
          _votes: votes
        };
      }).filter(p=>p.x!==0 || p.y!==0);

      if (abBubbleChart) abBubbleChart.destroy();
      abBubbleChart = new Chart(elC,{
        type:"bubble",
        data:{ datasets:[{
          label:"Shows",
          data: points,
          backgroundColor:"rgba(139,92,246,.26)",
          borderColor:"rgba(139,92,246,.55)",
          borderWidth:1
        }]},
        options:{
          responsive:true, maintainAspectRatio:false,
          plugins:{
            legend:{display:false},
            tooltip:{ callbacks:{ label:(ctx)=>{
              const p=ctx.raw;
              return [
                ` ${p._name}`,
                ` Rating: ${num(p.y).toFixed(2)} | Popularity: ${num(p.x).toFixed(2)}`,
                ` Votes: ${num(p._votes).toLocaleString()} | Flag: ${p._flag} | Lifecycle: ${p._life} | Type: ${p._type}`
              ];
            }}}
          },
          scales:{
            x:{ title:{display:true,text:"Popularity"}, grid:{ color:"rgba(17,24,39,.08)" } },
            y:{ title:{display:true,text:"Vote Avg"}, grid:{ color:"rgba(17,24,39,.08)" }, beginAtZero:true }
          }
        }
      });
    }

    // =========================
    // INIT
    // =========================
    document.addEventListener("DOMContentLoaded", () => {
      initSegmentationCharts();
      initCampaignCharts();
      buildTrendCharts();
      buildCrossStudioCharts();
      buildEngagementCharts();
      buildAudienceBehaviorCharts();
    });
  </script>
</body>
</html>
