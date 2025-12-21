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
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>CloseSense Executive</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
  background: linear-gradient(135deg,#0f172a 0%,#1e3a8a 45%,#2563eb 100%);
  min-height:100vh;
}

/* NAVBAR */
.navbar-exec {
  background:#fff;
  border-bottom:1px solid #e5e7eb;
}
.navbar-exec .brand {
  font-weight:700;
  color:#1e3a8a;
}

/* CARD */
.card-glass {
  background:#fff;
  border-radius:18px;
  border:1px solid #e5e7eb;
  box-shadow:0 20px 40px rgba(0,0,0,.15);
}

/* TABLE */
.table {
  font-size:14px;
}
.table thead th {
  background:#f8fafc;
  font-size:12px;
  text-transform:uppercase;
  white-space:nowrap;
}
.table tbody tr:hover {
  background:#eef2ff;
}

/* BADGE */
.badge-upcoming { background:#f59e0b; }
.badge-released { background:#22c55e; }
.badge-archived { background:#ef4444; }

/* ACTION */
.action-btns .btn {
  padding:.25rem .45rem;
}

/* FILTERS */
.filter-card {
  background: #f8fafc;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 1rem;
}

/* FIXED COLUMN WIDTHS */
.col-title { min-width: 240px; }
.col-type { min-width: 80px; }
.col-status { min-width: 100px; }
.col-lifecycle { min-width: 100px; }
.col-rating { min-width: 100px; }
.col-popularity { min-width: 100px; }
.col-genres { min-width: 180px; }
.col-production { min-width: 180px; }
.col-airdates { min-width: 150px; }
.col-action { min-width: 120px; }

/* PAGINATION */
.pagination-container {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
  margin-top: 1rem;
}
.page-info {
  font-size: 14px;
  color: #6c757d;
  background: #f8f9fa;
  padding: 5px 12px;
  border-radius: 4px;
}

/* LIFECYCLE TRACKER */
.lifecycle-card {
  background:#fff;
  border-radius:18px;
  padding:20px;
  margin-bottom:24px;
  box-shadow:0 16px 30px rgba(0,0,0,.15);
}

.timeline {
  position:relative;
  padding-left:24px;
}
.timeline::before {
  content:'';
  position:absolute;
  left:8px;
  top:0;
  bottom:0;
  width:2px;
  background:#e5e7eb;
}
.timeline-item {
  position:relative;
  padding-bottom:16px;
}
.timeline-dot {
  position:absolute;
  left:0;
  top:6px;
  width:16px;
  height:16px;
  border-radius:50%;
}
.dot-upcoming { background:#f59e0b; }
.dot-released { background:#22c55e; }
.dot-archived { background:#ef4444; }

/* CHART CONTAINER */
.chart-container {
  position: relative;
  height: 260px;
  width: 100%;
}

/* FILTER BADGES */
.filter-badge {
  cursor: pointer;
  transition: all 0.2s;
}
.filter-badge.active {
  transform: scale(1.05);
  box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.3);
}

/* EMPTY STATE */
.empty-state {
  padding: 3rem 1rem;
  text-align: center;
  color: #6c757d;
}

/* GLOBAL TRENDS */
.global-trend-item {
  transition: all 0.2s;
}
.global-trend-item:hover {
  background-color: #f8f9fa;
}

/* MULTI-LANGUAGE SPECIFIC */
.multi-language-card .card {
  border: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: 0.5rem;
}
.multi-language-card .chart-container {
  height: 250px;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-exec shadow-sm">
  <div class="container py-2 d-flex justify-content-between align-items-center">
    <div>
      <div class="brand fs-5">🎬 CloseSense Executive</div>
    </div>
    <form method="POST" action="/logout">
      @csrf
      <button class="btn btn-danger btn-sm">
        <i class="fa-solid fa-right-from-bracket me-1"></i>Logout
      </button>
    </form>
  </div>
</nav>

<div class="container my-4">

<!-- STATISTIK CARD -->
<div class="card-glass p-3 mb-4">
  <h5 class="fw-bold mb-3">
    <i class="fa-solid fa-chart-pie me-2"></i>Content Statistics
  </h5>
  <div class="row text-center">
    <div class="col-3">
      <div class="fw-bold fs-4">{{ $stats->total ?? 0 }}</div>
      <small class="text-muted">Total Content</small>
    </div>
    <div class="col-3">
      <div class="fw-bold fs-4 text-warning">{{ $stats->upcoming ?? 0 }}</div>
      <small class="text-warning">Upcoming</small>
    </div>
    <div class="col-3">
      <div class="fw-bold fs-4 text-success">{{ $stats->released ?? 0 }}</div>
      <small class="text-success">Released</small>
    </div>
    <div class="col-3">
      <div class="fw-bold fs-4 text-danger">{{ $stats->archived ?? 0 }}</div>
      <small class="text-danger">Archived</small>
    </div>
  </div>
</div>

<!-- TOP PERFORMER DASHBOARD -->
<div class="card-glass p-3 mb-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">
      <i class="fa-solid fa-trophy me-2 text-warning"></i>
      Top Performer Dashboard (Weekly)
    </h5>
    <div class="text-muted small">
      <i class="fa-solid fa-calendar-week me-1"></i>Updated: {{ date('M d, Y') }}
    </div>
  </div>

  <div class="row">
    <!-- KOLOM KIRI: Top Content Chart -->
    <div class="col-lg-7 mb-3">
      <h6 class="fw-semibold mb-2">Top Content This Week</h6>
      <div class="chart-container mb-3">
        <canvas id="topContentChart"></canvas>
      </div>
      
      @if($topPerformers->where('metric_type', 'top_content')->count() == 0)
        <div class="empty-state py-4">
          <i class="fa-solid fa-chart-line fa-2x mb-2 text-muted"></i>
          <p class="mb-0">No top performer data available</p>
        </div>
      @endif
    </div>

    <!-- KOLOM KANAN: Top Genres Chart -->
    <div class="col-lg-5 mb-3">
      <h6 class="fw-semibold mb-2">Top Popular Genres</h6>
      <div class="chart-container mb-3">
        <canvas id="topGenreChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- LIFECYCLE TRACKER -->
<div class="lifecycle-card">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">
      <i class="fa-solid fa-clock-rotate-left me-2"></i>Content Lifecycle Tracker
    </h5>
  </div>
  
  <!-- FILTER LIFECYCLE -->
  <div class="filter-card mb-3">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h6 class="fw-semibold mb-2">Filter by Phase:</h6>
        <div class="d-flex flex-wrap gap-2">
          <a href="?lifecycle=all{{ $q ? '&q='.$q : '' }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}" 
             class="badge bg-primary filter-badge {{ $lifecycleFilter == 'all' ? 'active' : '' }}">
            All ({{ $stats->total ?? 0 }})
          </a>
          <a href="?lifecycle=upcoming{{ $q ? '&q='.$q : '' }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}" 
             class="badge bg-warning filter-badge {{ $lifecycleFilter == 'upcoming' ? 'active' : '' }}">
            Upcoming ({{ $stats->upcoming ?? 0 }})
          </a>
          <a href="?lifecycle=released{{ $q ? '&q='.$q : '' }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}" 
             class="badge bg-success filter-badge {{ $lifecycleFilter == 'released' ? 'active' : '' }}">
            Released ({{ $stats->released ?? 0 }})
          </a>
          <a href="?lifecycle=archived{{ $q ? '&q='.$q : '' }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}" 
             class="badge bg-danger filter-badge {{ $lifecycleFilter == 'archived' ? 'active' : '' }}">
            Archived ({{ $stats->archived ?? 0 }})
          </a>
        </div>
      </div>
      <div class="col-md-6 mt-2 mt-md-0">
        <form method="GET" action="">
          <input type="hidden" name="lifecycle" value="{{ $lifecycleFilter }}">
          <input type="hidden" name="studio_filter" value="{{ $studioFilter }}">
          <input type="hidden" name="global_search" value="{{ $globalSearch }}">
          <div class="input-group input-group-sm">
            <input
              type="text"
              name="q"
              value="{{ $q }}"
              class="form-control"
              placeholder="Search in lifecycle..."
            >
            <button class="btn btn-primary" type="submit">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="row">
    @forelse($lifecycle as $item)
      @php
        $dot = match($item->lifecycle_phase ?? 'Released') {
          'Upcoming' => 'dot-upcoming',
          'Archived' => 'dot-archived',
          default => 'dot-released'
        };
      @endphp

      <div class="col-md-6 col-lg-4 mb-3">
        <div class="timeline">
          <div class="timeline-item">
            <div class="timeline-dot {{ $dot }}"></div>
            <div class="ms-3">
              <div class="fw-semibold">{{ $item->name ?? 'Untitled' }}</div>
              <div class="small text-muted">
                {{ $item->content_type ?? '-' }} • {{ $item->production_status ?? '-' }}
              </div>
              <span class="badge
                {{ ($item->lifecycle_phase ?? 'Released') === 'Upcoming' ? 'badge-upcoming' :
                   (($item->lifecycle_phase ?? 'Released') === 'Archived' ? 'badge-archived' : 'badge-released') }}">
                {{ $item->lifecycle_phase ?? 'Released' }}
              </span>
              <div class="small text-muted mt-1">
                {{ $item->start_date ?? '-' }} → {{ $item->end_date ?? 'Now' }}
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="empty-state">
          <i class="fa-solid fa-inbox fa-3x mb-3"></i>
          <p class="mb-0">No lifecycle data found for the selected filters.</p>
        </div>
      </div>
    @endforelse
  </div>
</div>

<!-- GLOBAL TREND MONITORING -->
<div class="card-glass p-3 mb-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">
      <i class="fa-solid fa-globe me-2 text-info"></i>
      Global Trend Monitoring
    </h5>
    
    <!-- SEARCH GLOBAL TRENDS -->
    <form method="GET" action="" class="d-flex" style="max-width: 300px;">
      <input type="hidden" name="lifecycle" value="{{ $lifecycleFilter }}">
      <input type="hidden" name="studio_filter" value="{{ $studioFilter }}">
      <input type="hidden" name="q" value="{{ $q }}">
      <div class="input-group input-group-sm">
        <input
          type="text"
          name="global_search"
          value="{{ $globalSearch }}"
          class="form-control"
          placeholder="Search country, genre, studio..."
        >
        <button class="btn btn-primary" type="submit">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        @if($globalSearch)
        <a href="?lifecycle={{ $lifecycleFilter }}&studio_filter={{ $studioFilter }}&q={{ $q }}" 
           class="btn btn-outline-secondary">
          <i class="fa-solid fa-times"></i>
        </a>
        @endif
      </div>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-sm align-middle">
      <thead>
        <tr>
          <th width="60">Rank</th>
          <th width="120">Country</th>
          <th width="100">Total Content</th>
          <th width="100">Avg Rating</th>
          <th width="150">Top Genres</th>
        </tr>
      </thead>
      <tbody>
        @forelse($globalTrends as $trend)
        <tr class="global-trend-item">
          <td>
            <span class="badge {{ ($trend->country_rank ?? 0) <= 3 ? 'bg-warning' : 'bg-secondary' }}">
              #{{ $trend->country_rank ?? 0 }}
            </span>
          </td>
          <td class="fw-semibold">
            <div class="d-flex align-items-center">
              {{ $trend->country ?? 'Unknown' }}
            </div>
          </td>
          <td>{{ number_format($trend->total_content ?? 0) }}</td>
          <td>⭐ {{ number_format($trend->avg_rating ?? 0, 1) }}</td>
          <td class="small">{{ Str::limit($trend->top_genres ?? '-', 30) }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center text-muted py-4">
            <i class="fa-solid fa-globe-americas fa-2x mb-2"></i>
            <p class="mb-0">No global trend data found</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- PAGINATION GLOBAL TRENDS -->
  @if($globalTrends->hasPages())
  <div class="pagination-container mt-3">
    <div class="page-info">
      Showing {{ $globalTrends->firstItem() }} to {{ $globalTrends->lastItem() }} of {{ $globalTrends->total() }} countries
    </div>
    
    <nav aria-label="Global trends pagination">
      <ul class="pagination pagination-sm mb-0">
        {{-- Previous Page Link --}}
        @if($globalTrends->onFirstPage())
          <li class="page-item disabled">
            <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
          </li>
        @else
          <li class="page-item">
            <a class="page-link" href="{{ $globalTrends->previousPageUrl() }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}" rel="prev">
              <i class="fa-solid fa-chevron-left"></i>
            </a>
          </li>
        @endif

        {{-- Pagination Elements --}}
        @php
          $current = $globalTrends->currentPage();
          $last = $globalTrends->lastPage();
          $start = max($current - 2, 1);
          $end = min($current + 2, $last);
        @endphp

        {{-- First Page Link --}}
        @if($start > 1)
          <li class="page-item">
            <a class="page-link" href="{{ $globalTrends->url(1) }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}">1</a>
          </li>
          @if($start > 2)
            <li class="page-item disabled">
              <span class="page-link">...</span>
            </li>
          @endif
        @endif

        {{-- Page Number Links --}}
        @for($i = $start; $i <= $end; $i++)
          @if($i == $current)
            <li class="page-item active">
              <span class="page-link">{{ $i }}</span>
            </li>
          @else
            <li class="page-item">
              <a class="page-link" href="{{ $globalTrends->url($i) }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}">{{ $i }}</a>
            </li>
          @endif
        @endfor

        {{-- Last Page Link --}}
        @if($end < $last)
          @if($end < $last - 1)
            <li class="page-item disabled">
              <span class="page-link">...</span>
            </li>
          @endif
          <li class="page-item">
            <a class="page-link" href="{{ $globalTrends->url($last) }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}">{{ $last }}</a>
          </li>
        @endif

        {{-- Next Page Link --}}
        @if($globalTrends->hasMorePages())
          <li class="page-item">
            <a class="page-link" href="{{ $globalTrends->nextPageUrl() }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}" rel="next">
              <i class="fa-solid fa-chevron-right"></i>
            </a>
          </li>
        @else
          <li class="page-item disabled">
            <span class="page-link"><i class="fa-solid fa-chevron-right"></i></span>
          </li>
        @endif
      </ul>
    </nav>
  </div>
  @endif
</div>

<!-- EXTENDED GLOBAL ANALYTICS -->
<div class="card-glass p-3 mb-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">
      <i class="fa-solid fa-chart-line me-2 text-info"></i>
      Extended Global Analytics
    </h5>
    <div class="text-muted small">
      <i class="fa-solid fa-calendar-week me-1"></i>Updated: {{ date('M d, Y') }}
    </div>
  </div>

  <div class="row">
    <!-- CHART: Trend per Wilayah -->
    <div class="col-lg-12 mb-3">
      <h6 class="fw-semibold mb-2">Trend per Wilayah (Top Countries)</h6>
      <div class="chart-container">
        <canvas id="globalTrendLine"></canvas>
      </div>
    </div>
  </div>

  <hr class="my-3">

  <div class="row">
    <!-- LIST: Konten Global dengan Popularitas Tertinggi -->
    <div class="col-lg-12 mb-3">
      <h6 class="fw-semibold mb-2">Konten Global dengan Popularitas Tertinggi (Latest Year)</h6>
      <div class="list-group">
        @forelse($topGrowthContent as $c)
          <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
              <div class="fw-semibold">{{ $c->name ?? 'Unknown' }}</div>
              <small class="text-muted">
                Year: {{ $c->release_year ?? 'N/A' }} • ⭐ {{ number_format($c->vote_average ?? 0, 1) }}
              </small>
            </div>
            <div class="text-end">
              <div class="fw-semibold">{{ number_format($c->popularity ?? 0, 2) }}</div>
              <small class="text-muted">{{ number_format($c->vote_count ?? 0) }} votes</small>
            </div>
          </div>
        @empty
          <div class="text-muted p-3 text-center">
            <i class="fa-solid fa-film fa-2x mb-2"></i>
            <p class="mb-0">No content growth data</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>

<!-- MULTI-LANGUAGE & SUBTITLE ANALYTICS -->
<div class="card-glass p-3 mb-4 multi-language-card">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">
      <i class="fa-solid fa-language me-2 text-success"></i>
      Multi-Language & Subtitle Analytics
    </h5>
    <div class="text-muted small">
      <i class="fa-solid fa-calendar-week me-1"></i>Updated: {{ date('M d, Y') }}
    </div>
  </div>

  <div class="row mb-4">
    <!-- FILTER SECTION -->
    <div class="col-12 mb-3">
      <div class="row g-2">
        <div class="col-md-4">
          <label class="form-label small fw-semibold">Filter Bahasa</label>
          <select class="form-select form-select-sm" id="languageFilterSelect">
            <option value="all" {{ $languageFilter == 'all' ? 'selected' : '' }}>Semua Bahasa</option>
            <option value="top10" {{ $languageFilter == 'top10' ? 'selected' : '' }}>Top 10 Bahasa</option>
            <option value="europe" {{ $languageFilter == 'europe' ? 'selected' : '' }}>Eropa</option>
            <option value="asia" {{ $languageFilter == 'asia' ? 'selected' : '' }}>Asia</option>
            <option value="america" {{ $languageFilter == 'america' ? 'selected' : '' }}>Amerika</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label small fw-semibold">Periode Waktu</label>
          <select class="form-select form-select-sm" id="timePeriodSelect">
            <option value="monthly" {{ $timePeriod == 'monthly' ? 'selected' : '' }}>Bulanan</option>
            <option value="quarterly" {{ $timePeriod == 'quarterly' ? 'selected' : '' }}>Triwulan</option>
            <option value="yearly" {{ $timePeriod == 'yearly' ? 'selected' : '' }}>Tahunan</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label small fw-semibold">Jenis Konten</label>
          <select class="form-select form-select-sm" id="contentTypeSelect">
            <option value="all" {{ $contentTypeLang == 'all' ? 'selected' : '' }}>Semua Konten</option>
            <option value="movie" {{ $contentTypeLang == 'movie' ? 'selected' : '' }}>Film</option>
            <option value="tv" {{ $contentTypeLang == 'tv' ? 'selected' : '' }}>TV Series</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- CHART 1: Distribusi Subtitle per Bahasa (Donut Chart) -->
    <div class="col-lg-6 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <h6 class="fw-semibold mb-3">
            <i class="fa-solid fa-closed-captioning me-2 text-primary"></i>
            Distribusi Subtitle per Bahasa
          </h6>
          <div class="chart-container">
            <canvas id="subtitleLanguageDonut"></canvas>
          </div>
          <div class="mt-3">
            <div class="d-flex justify-content-between small">
              <span>Total Subtitle:</span>
              <span class="fw-semibold">{{ number_format($languageStats['total_subtitles'] ?? 0) }}</span>
            </div>
            <div class="d-flex justify-content-between small">
              <span>Bahasa Tersedia:</span>
              <span class="fw-semibold">{{ count($subtitleDistribution) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- CHART 2: Pertumbuhan Permintaan Subtitle (Line Chart) -->
    <div class="col-lg-6 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <h6 class="fw-semibold mb-3">
            <i class="fa-solid fa-chart-line me-2 text-warning"></i>
            Pertumbuhan Permintaan Subtitle
          </h6>
          <div class="chart-container">
            <canvas id="subtitleGrowthLine"></canvas>
          </div>
          <div class="mt-3">
            <div class="d-flex justify-content-between small">
              <span>Rata-rata Pertumbuhan/Bulan:</span>
              <span class="fw-semibold text-success">{{ $languageStats['top_market_growth'] ?? 0 }}%</span>
            </div>
            <div class="d-flex justify-content-between small">
              <span>Bahasa dengan Pertumbuhan Tertinggi:</span>
              <span class="fw-semibold" id="topGrowthLanguage">-</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- STATS SUMMARY -->
  <div class="row mt-4">
    <div class="col-md-3 mb-3">
      <div class="card bg-light">
        <div class="card-body text-center py-3">
          <i class="fa-solid fa-globe fa-2x text-primary mb-2"></i>
          <h5 class="fw-bold mb-1">{{ $languageStats['total_languages'] ?? 0 }}</h5>
          <p class="small text-muted mb-0">Total Bahasa Didukung</p>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card bg-light">
        <div class="card-body text-center py-3">
          <i class="fa-solid fa-cc fa-2x text-success mb-2"></i>
          <h5 class="fw-bold mb-1">{{ number_format($languageStats['avg_subtitle_per_content'] ?? 0, 1) }}</h5>
          <p class="small text-muted mb-0">Rata-rata Subtitle/Konten</p>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card bg-light">
        <div class="card-body text-center py-3">
          <i class="fa-solid fa-arrow-up fa-2x text-warning mb-2"></i>
          <h5 class="fw-bold mb-1">{{ $languageStats['top_market_growth'] ?? 0 }}%</h5>
          <p class="small text-muted mb-0">Pasar dengan Pertumbuhan Tertinggi</p>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card bg-light">
        <div class="card-body text-center py-3">
          <i class="fa-solid fa-flag fa-2x text-danger mb-2"></i>
          <h5 class="fw-bold mb-1">{{ $languageStats['emerging_languages'] ?? 0 }}</h5>
          <p class="small text-muted mb-0">Bahasa yang Sedang Berkembang</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- TABLE CARD -->
<div class="card-glass p-3">
  <!-- CARD HEADER -->
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
    <h5 class="fw-bold mb-0 d-flex align-items-center">
      Studio Content
    </h5>

    <div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-md-end">
      <form method="GET" action="" style="max-width:320px">
        <input type="hidden" name="lifecycle" value="{{ $lifecycleFilter }}">
        <input type="hidden" name="studio_filter" value="{{ $studioFilter }}">
        <input type="hidden" name="global_search" value="{{ $globalSearch }}">
        <input type="hidden" name="language_filter" value="{{ $languageFilter }}">
        <input type="hidden" name="time_period" value="{{ $timePeriod }}">
        <input type="hidden" name="content_type_lang" value="{{ $contentTypeLang }}">
        <div class="input-group input-group-sm">
          <input
            type="text"
            name="q"
            value="{{ $q }}"
            class="form-control"
            placeholder="Search title, genre, studio…"
          >
          <button class="btn btn-primary" type="submit">
            <i class="fa-solid fa-magnifying-glass me-1"></i>Search
          </button>
        </div>
      </form>

      <a href="#" class="btn btn-sm btn-primary">
        <i class="fa-solid fa-plus me-1"></i>Add Content
      </a>
    </div>
  </div>

  <!-- TABLE -->
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr>
          <th class="col-title">Title</th>
          <th class="col-type">Type</th>
          <th class="col-status">Status</th>
          <th class="col-lifecycle">Lifecycle</th>
          <th class="col-rating">Rating</th>
          <th class="col-popularity">Popularity</th>
          <th class="col-genres">Genres</th>
          <th class="col-production">Production</th>
          <th class="col-airdates">Air Dates</th>
          <th class="col-action">Action</th>
        </tr>
      </thead>

      <tbody>
      @forelse($contents as $c)
        @php
          $lifecycle_status = $c->lifecycle_status ?? 'Released';
          $badge = match($lifecycle_status) {
            'Upcoming' => 'badge-upcoming',
            'Archived' => 'badge-archived',
            default => 'badge-released'
          };
          $show_type = $c->show_type ?? '-';
          $status = $c->status ?? '-';
        @endphp

        <tr>
          <td class="col-title">
            <div class="fw-semibold">{{ $c->name ?? 'Untitled' }}</div>
            @if(!empty($c->original_name) && $c->original_name != $c->name)
            <small class="text-muted">{{ $c->original_name }}</small>
            @endif
          </td>

          <td class="col-type"><span class="badge bg-primary">{{ $show_type }}</span></td>
          <td class="col-status"><span class="badge bg-secondary">{{ $status }}</span></td>
          <td class="col-lifecycle"><span class="badge {{ $badge }}">{{ $lifecycle_status }}</span></td>

          <td class="col-rating">
            {!! formatRating($c->vote_average ?? 0, $c->vote_count ?? 0) !!}
          </td>

          <td class="col-popularity">{{ formatPopularity($c->popularity ?? null) }}</td>

          <td class="col-genres">{{ uniqueList($c->genres ?? '') }}</td>
          <td class="col-production">{{ uniqueList($c->production_companies ?? '') }}</td>

          <td class="col-airdates">
            <small class="text-muted">
              {!! formatDates($c->first_air_date ?? null, $c->last_air_date ?? null) !!}
            </small>
          </td>

          <td class="col-action action-btns text-nowrap">
            <a href="#" class="btn btn-outline-info btn-sm">
              <i class="fa-solid fa-eye"></i>
            </a>
            <a href="#" class="btn btn-outline-warning btn-sm">
              <i class="fa-solid fa-pen"></i>
            </a>
            <form method="POST" action="#" class="d-inline">
              @csrf
              @method('DELETE')
              <button class="btn btn-outline-danger btn-sm"
                onclick="return confirm('Yakin hapus data ini?')">
                <i class="fa-solid fa-trash"></i>
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="10" class="text-center text-muted py-4">
            Tidak ada data.
          </td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>

  <!-- DIVIDER -->
  <hr class="my-3">

  <!-- PAGINATION -->
  @if($contents->hasPages())
  <div class="pagination-container">
    <div class="page-info">
      Showing {{ $contents->firstItem() }} to {{ $contents->lastItem() }} of {{ $contents->total() }} results
    </div>
    
    <nav aria-label="Page navigation">
      <ul class="pagination pagination-sm mb-0">
        {{-- Previous Page Link --}}
        @if($contents->onFirstPage())
          <li class="page-item disabled">
            <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
          </li>
        @else
          <li class="page-item">
            <a class="page-link" href="{{ $contents->previousPageUrl() }}{{ $lifecycleFilter != 'all' ? '&lifecycle='.$lifecycleFilter : '' }}{{ $studioFilter ? '&studio_filter='.$studioFilter : '' }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}{{ $languageFilter != 'all' ? '&language_filter='.$languageFilter : '' }}{{ $timePeriod != 'monthly' ? '&time_period='.$timePeriod : '' }}{{ $contentTypeLang != 'all' ? '&content_type_lang='.$contentTypeLang : '' }}" rel="prev">
              <i class="fa-solid fa-chevron-left"></i>
            </a>
          </li>
        @endif

        {{-- Pagination Elements --}}
        @php
          $current = $contents->currentPage();
          $last = $contents->lastPage();
          $start = max($current - 2, 1);
          $end = min($current + 2, $last);
        @endphp

        {{-- First Page Link --}}
        @if($start > 1)
          <li class="page-item">
            <a class="page-link" href="{{ $contents->url(1) }}{{ $lifecycleFilter != 'all' ? '&lifecycle='.$lifecycleFilter : '' }}{{ $studioFilter ? '&studio_filter='.$studioFilter : '' }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}{{ $languageFilter != 'all' ? '&language_filter='.$languageFilter : '' }}{{ $timePeriod != 'monthly' ? '&time_period='.$timePeriod : '' }}{{ $contentTypeLang != 'all' ? '&content_type_lang='.$contentTypeLang : '' }}">1</a>
          </li>
          @if($start > 2)
            <li class="page-item disabled">
              <span class="page-link">...</span>
            </li>
          @endif
        @endif

        {{-- Page Number Links --}}
        @for($i = $start; $i <= $end; $i++)
          @if($i == $current)
            <li class="page-item active">
              <span class="page-link">{{ $i }}</span>
            </li>
          @else
            <li class="page-item">
              <a class="page-link" href="{{ $contents->url($i) }}{{ $lifecycleFilter != 'all' ? '&lifecycle='.$lifecycleFilter : '' }}{{ $studioFilter ? '&studio_filter='.$studioFilter : '' }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}{{ $languageFilter != 'all' ? '&language_filter='.$languageFilter : '' }}{{ $timePeriod != 'monthly' ? '&time_period='.$timePeriod : '' }}{{ $contentTypeLang != 'all' ? '&content_type_lang='.$contentTypeLang : '' }}">{{ $i }}</a>
            </li>
          @endif
        @endfor

        {{-- Last Page Link --}}
        @if($end < $last)
          @if($end < $last - 1)
            <li class="page-item disabled">
              <span class="page-link">...</span>
            </li>
          @endif
          <li class="page-item">
            <a class="page-link" href="{{ $contents->url($last) }}{{ $lifecycleFilter != 'all' ? '&lifecycle='.$lifecycleFilter : '' }}{{ $studioFilter ? '&studio_filter='.$studioFilter : '' }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}{{ $languageFilter != 'all' ? '&language_filter='.$languageFilter : '' }}{{ $timePeriod != 'monthly' ? '&time_period='.$timePeriod : '' }}{{ $contentTypeLang != 'all' ? '&content_type_lang='.$contentTypeLang : '' }}">{{ $last }}</a>
          </li>
        @endif

        {{-- Next Page Link --}}
        @if($contents->hasMorePages())
          <li class="page-item">
            <a class="page-link" href="{{ $contents->nextPageUrl() }}{{ $lifecycleFilter != 'all' ? '&lifecycle='.$lifecycleFilter : '' }}{{ $studioFilter ? '&studio_filter='.$studioFilter : '' }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}{{ $languageFilter != 'all' ? '&language_filter='.$languageFilter : '' }}{{ $timePeriod != 'monthly' ? '&time_period='.$timePeriod : '' }}{{ $contentTypeLang != 'all' ? '&content_type_lang='.$contentTypeLang : '' }}" rel="next">
              <i class="fa-solid fa-chevron-right"></i>
            </a>
          </li>
        @else
          <li class="page-item disabled">
            <span class="page-link"><i class="fa-solid fa-chevron-right"></i></span>
          </li>
        @endif
      </ul>
    </nav>
  </div>
  @endif
</div>

<!-- ANALYTICS CARD -->
<div class="card-glass p-3 mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">
      <i class="fa-solid fa-chart-bar me-2"></i>Cross-Studio Analytics
    </h5>
    
    <!-- FILTER STUDIO -->
    <div class="dropdown">
      <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" 
              data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-filter me-1"></i>
        @if($studioFilter)
          Studio: {{ $studioFilter }}
        @else
          All Studios
        @endif
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="?lifecycle={{ $lifecycleFilter }}{{ $q ? '&q='.$q : '' }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}{{ $languageFilter != 'all' ? '&language_filter='.$languageFilter : '' }}{{ $timePeriod != 'monthly' ? '&time_period='.$timePeriod : '' }}{{ $contentTypeLang != 'all' ? '&content_type_lang='.$contentTypeLang : '' }}">All Studios</a></li>
        <li><hr class="dropdown-divider"></li>
        @foreach($studioList as $studio)
          <li>
            <a class="dropdown-item" href="?studio_filter={{ $studio }}&lifecycle={{ $lifecycleFilter }}{{ $q ? '&q='.$q : '' }}{{ $globalSearch ? '&global_search='.$globalSearch : '' }}{{ $languageFilter != 'all' ? '&language_filter='.$languageFilter : '' }}{{ $timePeriod != 'monthly' ? '&time_period='.$timePeriod : '' }}{{ $contentTypeLang != 'all' ? '&content_type_lang='.$contentTypeLang : '' }}">
              {{ $studio }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>

  <!-- CHART CONTAINER -->
  <div class="chart-container mb-4">
    <canvas id="studioCompareChart"></canvas>
  </div>

  <!-- TABLE (READ ONLY) -->
  <div class="table-responsive">
    <table class="table table-sm align-middle">
      <thead>
        <tr>
          <th>Studio</th>
          <th>Total Content</th>
          <th>Avg Rating</th>
          <th>Total Votes</th>
          <th>Avg Popularity</th>
          <th>Top Genres</th>
        </tr>
      </thead>
      <tbody>
        @forelse($crossStudio as $s)
        <tr>
          <td class="fw-semibold">{{ $s->studio_name }}</td>
          <td>{{ $s->total_content }}</td>
          <td>⭐ {{ number_format($s->avg_rating,1) }}</td>
          <td>{{ number_format($s->total_votes) }}</td>
          <td>{{ number_format($s->avg_popularity,1) }}</td>
          <td class="small text-muted">{{ Str::limit($s->top_genres, 30) }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center text-muted py-3">
            No studio data available
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

</div> <!-- END CONTAINER -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  
  // =========================
  // TOP PERFORMER CHARTS
  // =========================
  const topContentRaw = @json($topPerformers->where('metric_type', 'top_content')->values());
  const topGenresRaw = @json($topPerformers->where('metric_type', 'top_genres')->values());

  // Clean top genres
  const topGenres = topGenresRaw
    .map(g => ({ ...g, name: String(g.name ?? '').trim() }))
    .filter(g => g.name !== '' && g.name.toLowerCase() !== 'null');

  const genreColorMap = {
    Drama: '#2563eb',
    Comedy: '#22c55e',
    Documentary: '#f59e0b',
    Animation: '#ef4444',
    Unknown: '#9ca3af'
  };

  // Deduplicate top content
  const seen = new Map();
  for (const item of topContentRaw) {
    const key = (item.show_id ?? String(item.name ?? '').trim()).toString();
    if (!seen.has(key)) {
      seen.set(key, item);
      continue;
    }
    const prev = seen.get(key);
    const prevVotes = Number(prev.vote_count ?? 0);
    const curVotes = Number(item.vote_count ?? 0);
    const prevPop = Number(prev.popularity ?? 0);
    const curPop = Number(item.popularity ?? 0);
    const prevRate = Number(prev.vote_average ?? 0);
    const curRate = Number(item.vote_average ?? 0);
    const better = (curVotes > prevVotes) ||
      (curVotes === prevVotes && curPop > prevPop) ||
      (curVotes === prevVotes && curPop === prevPop && curRate > prevRate);
    if (better) seen.set(key, item);
  }

  const topContent = Array.from(seen.values()).slice(0, 10);

  // Top Content Chart
  if (topContent.length > 0 && document.getElementById('topContentChart')) {
    const ctx = document.getElementById('topContentChart').getContext('2d');
    if (window.topContentChart instanceof Chart) {
      window.topContentChart.destroy();
    }

    const popArr = topContent.map(i => Number(i.popularity ?? 0));
    const maxPop = Math.max(...popArr);
    const barData = popArr.map(v => (maxPop > 0 ? (v / maxPop) * 100 : 0));

    window.topContentChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: topContent.map(i => {
          const name = String(i.name ?? 'Untitled');
          return name.length > 15 ? name.substring(0, 15) + '...' : name;
        }),
        datasets: [{
          label: 'Popularity (normalized)',
          data: barData,
          backgroundColor: 'rgba(37, 99, 235, 0.7)',
          borderColor: 'rgb(37, 99, 235)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'top', labels: { boxWidth: 12, padding: 10 } },
          tooltip: {
            callbacks: {
              label: function(context) {
                const item = topContent[context.dataIndex] || {};
                const pop = Number(item.popularity ?? 0);
                return `Popularity: ${pop.toLocaleString()} (normalized: ${Number(context.parsed.y).toFixed(1)}%)`;
              }
            }
          }
        },
        scales: {
          x: { grid: { display: false }, ticks: { font: { size: 10 } } },
          y: {
            type: 'linear',
            display: true,
            position: 'left',
            title: { display: true, text: 'Popularity (normalized %)', color: '#2563eb' },
            min: 0, max: 100,
            grid: { drawOnChartArea: false },
            ticks: { color: '#2563eb', callback: v => v + '%' }
          }
        }
      }
    });
  }

  // Top Genre Chart
  if (topGenres.length > 0 && document.getElementById('topGenreChart')) {
    const ctx = document.getElementById('topGenreChart').getContext('2d');
    const labels = topGenres.map(i => i.name || 'Unknown');
    const data = topGenres.map(i => Number(i.popularity ?? 0));
    const colors = labels.map(name => genreColorMap[name] ?? genreColorMap.Unknown);

    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels,
        datasets: [{
          data,
          backgroundColor: colors,
          borderWidth: 2,
          borderColor: '#fff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right',
            labels: { padding: 10, boxWidth: 12, font: { size: 11 } }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                const label = context.label || '';
                const value = Number(context.raw ?? 0);
                const total = (context.dataset.data || []).reduce((a, b) => Number(a) + Number(b), 0);
                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                return `${label}: ${value.toFixed(1)} (${percentage}%)`;
              }
            }
          }
        },
        cutout: '60%'
      }
    });
  }

  // =========================
  // GLOBAL TREND LINE CHART
  // =========================
  const trendLines = @json($trendLines ?? []);
  if (trendLines.length > 0 && document.getElementById('globalTrendLine')) {
    const ctx = document.getElementById('globalTrendLine').getContext('2d');
    if (window.globalTrendChart instanceof Chart) {
      window.globalTrendChart.destroy();
    }

    const labels = trendLines.map(x => x.country ?? 'Unknown');
    const scores = trendLines.map(x => Number(x.chart_value ?? 0));

    window.globalTrendChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: 'Avg Popularity',
          data: scores,
          tension: 0.3,
          fill: false,
          borderWidth: 2,
          borderColor: '#2563eb',
          backgroundColor: 'rgba(37, 99, 235, 0.1)',
          pointRadius: 4,
          pointBackgroundColor: '#2563eb'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'top' },
          tooltip: {
            callbacks: {
              label: function(context) {
                return `Avg Popularity: ${Number(context.raw ?? 0).toFixed(1)}`;
              }
            }
          }
        },
        scales: {
          x: { grid: { display: false } },
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Average Popularity' }
          }
        }
      }
    });
  } else {
    const canvas = document.getElementById('globalTrendLine');
    if (canvas) {
      const ctx = canvas.getContext('2d');
      ctx.font = '14px Arial';
      ctx.fillStyle = '#999';
      ctx.textAlign = 'center';
      ctx.fillText('No trend data available', canvas.width / 2, canvas.height / 2);
    }
  }

  // =========================
  // MULTI-LANGUAGE CHARTS
  // =========================
  
  // Subtitle Distribution Donut Chart
  const subtitleData = @json($subtitleDistribution);
  if (subtitleData.length > 0 && document.getElementById('subtitleLanguageDonut')) {
    const ctx = document.getElementById('subtitleLanguageDonut').getContext('2d');
    if (window.subtitleDonutChart instanceof Chart) {
      window.subtitleDonutChart.destroy();
    }

    const colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#6366f1'];
    
    window.subtitleDonutChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: subtitleData.map(item => item.language),
        datasets: [{
          data: subtitleData.map(item => item.count),
          backgroundColor: colors.slice(0, subtitleData.length),
          borderWidth: 1,
          borderColor: '#ffffff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right',
            labels: { boxWidth: 12, padding: 15, font: { size: 11 } }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                const value = context.raw;
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const percentage = Math.round((value / total) * 100);
                return `${context.label}: ${value.toLocaleString()} (${percentage}%)`;
              }
            }
          }
        },
        cutout: '60%'
      }
    });
  }

  // Subtitle Growth Line Chart
  const growthData = @json($subtitleGrowthData);
  if (growthData.labels && growthData.labels.length > 0 && document.getElementById('subtitleGrowthLine')) {
    const ctx = document.getElementById('subtitleGrowthLine').getContext('2d');
    if (window.growthLineChart instanceof Chart) {
      window.growthLineChart.destroy();
    }

    const colors = ['#3b82f6', '#10b981', '#f59e0b'];
    
    window.growthLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: growthData.labels,
        datasets: growthData.datasets.map((dataset, index) => ({
          label: dataset.language,
          data: dataset.data,
          borderColor: colors[index % colors.length],
          backgroundColor: colors[index % colors.length] + '20',
          borderWidth: 2,
          fill: true,
          tension: 0.3,
          pointRadius: 3,
          pointBackgroundColor: colors[index % colors.length]
        }))
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            labels: { boxWidth: 12, padding: 10, font: { size: 11 } }
          },
          tooltip: { mode: 'index', intersect: false }
        },
        scales: {
          x: { grid: { display: false } },
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Jumlah Subtitle Baru' },
            ticks: { callback: value => value.toLocaleString() }
          }
        }
      }
    });

    // Calculate top growth language
    const datasets = growthData.datasets || [];
    if (datasets.length > 0) {
      const growthRates = datasets.map(dataset => {
        const data = dataset.data || [];
        if (data.length < 2) return 0;
        const first = data[0] || 1;
        const last = data[data.length - 1] || 0;
        return ((last - first) / first) * 100;
      });
      
      const maxIndex = growthRates.indexOf(Math.max(...growthRates));
      if (maxIndex >= 0 && datasets[maxIndex]) {
        document.getElementById('topGrowthLanguage').textContent = datasets[maxIndex].language;
      }
    }
  }

  // =========================
  // STUDIO COMPARE CHART
  // =========================
  const studioData = @json($crossStudio ?? []);
  const studioFilter = "{{ $studioFilter }}";
  
  let studios = [];
  let ratings = [];
  let popularity = [];
  let votes = [];
  
  if (studioFilter) {
    const filteredData = studioData.filter(item => item.studio_name === studioFilter);
    if (filteredData.length > 0) {
      studios = filteredData.map(item => item.studio_name);
      ratings = filteredData.map(item => item.avg_rating);
      popularity = filteredData.map(item => item.avg_popularity);
      votes = filteredData.map(item => item.total_votes);
    }
  } else {
    studios = studioData.map(item => item.studio_name);
    ratings = studioData.map(item => item.avg_rating);
    popularity = studioData.map(item => item.avg_popularity);
    votes = studioData.map(item => item.total_votes);
  }

  if (studios.length > 0 && document.getElementById('studioCompareChart')) {
    const scaledVotes = votes.map(vote => vote / 10000);
    const ctx = document.getElementById('studioCompareChart').getContext('2d');
    
    if (window.studioChart instanceof Chart) {
      window.studioChart.destroy();
    }
    
    window.studioChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: studios,
        datasets: [
          {
            label: 'Avg Rating',
            data: ratings,
            backgroundColor: 'rgba(37, 99, 235, 0.7)',
            borderColor: 'rgb(37, 99, 235)',
            borderWidth: 1,
            yAxisID: 'y'
          },
          {
            label: 'Avg Popularity',
            data: popularity,
            backgroundColor: 'rgba(34, 197, 94, 0.7)',
            borderColor: 'rgb(34, 197, 94)',
            borderWidth: 1,
            yAxisID: 'y'
          },
          {
            label: 'Total Votes (÷10k)',
            data: scaledVotes,
            backgroundColor: 'rgba(245, 158, 11, 0.7)',
            borderColor: 'rgb(245, 158, 11)',
            borderWidth: 1,
            yAxisID: 'y1'
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'top' },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';
                if (label.includes('Votes')) {
                  const originalValue = votes[context.dataIndex];
                  return label + ': ' + originalValue.toLocaleString();
                }
                if (label) label += ': ';
                label += context.parsed.y.toFixed(2);
                return label;
              }
            }
          }
        },
        scales: {
          x: { grid: { display: false } },
          y: {
            type: 'linear',
            display: true,
            position: 'left',
            title: { display: true, text: 'Rating & Popularity' }
          },
          y1: {
            type: 'linear',
            display: true,
            position: 'right',
            title: { display: true, text: 'Votes (in 10k)' },
            grid: { drawOnChartArea: false }
          }
        }
      }
    });
  } else {
    const canvas = document.getElementById('studioCompareChart');
    if (canvas) {
      const ctx = canvas.getContext('2d');
      ctx.font = '16px Arial';
      ctx.fillStyle = '#999';
      ctx.textAlign = 'center';
      ctx.fillText('No data available for chart', canvas.width / 2, canvas.height / 2);
    }
  }

  // =========================
  // MULTI-LANGUAGE FILTERS
  // =========================
  document.getElementById('languageFilterSelect')?.addEventListener('change', function() {
    updateMultiLanguageFilters();
  });

  document.getElementById('timePeriodSelect')?.addEventListener('change', function() {
    updateMultiLanguageFilters();
  });

  document.getElementById('contentTypeSelect')?.addEventListener('change', function() {
    updateMultiLanguageFilters();
  });

  function updateMultiLanguageFilters() {
    const languageFilter = document.getElementById('languageFilterSelect').value;
    const timePeriod = document.getElementById('timePeriodSelect').value;
    const contentType = document.getElementById('contentTypeSelect').value;
    
    const params = new URLSearchParams(window.location.search);
    params.set('language_filter', languageFilter);
    params.set('time_period', timePeriod);
    params.set('content_type_lang', contentType);
    
    window.location.search = params.toString();
  }
});
</script>

</body>
</html>