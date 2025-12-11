<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Executive Dashboard - CloseSense Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #1a56db;
            --secondary-color: #7e3af2;
            --success-color: #0e9f6e;
            --warning-color: #f59e0b;
            --danger-color: #e02424;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            color: #1f2937;
        }

        .navbar-executive {
            background: linear-gradient(135deg, #1a56db, #7e3af2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            background: white;
            min-height: calc(100vh - 76px);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 76px;
        }

        .sidebar .nav-link {
            color: #6b7280;
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(26, 86, 219, 0.1);
            color: var(--primary-color);
        }

        .main-content {
            background: #f5f7fa;
            min-height: calc(100vh - 76px);
            padding: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary-color);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .content-table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .badge-upcoming { background: var(--warning-color); }
        .badge-released { background: var(--success-color); }
        .badge-archived { background: var(--danger-color); }

        .lifecycle-tracker {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -23px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary-color);
            border: 2px solid white;
            box-shadow: 0 0 0 3px var(--primary-color);
        }

        .popularity-gauge {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: conic-gradient(
                #0e9f6e 0% 70%,
                #f59e0b 70% 85%,
                #e02424 85% 100%
            );
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .gauge-inner {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.5rem;
        }

        .portfolio-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-executive">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-crown me-2"></i>CloseSense Studio Executive
            </a>
            <div class="ms-auto d-flex gap-2 align-items-center">
                <span class="text-white me-3">
                    <i class="fas fa-user-circle me-1"></i>Executive User
                </span>
                <a href="/" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-eye me-1"></i>View User Portal
                </a>
                <form method="POST" action="/logout">
                    @csrf
                    <button class="btn btn-danger btn-sm" type="submit">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <nav class="nav flex-column py-3">
                    <a class="nav-link active" href="#summary" data-bs-toggle="tab">
                        <i class="fas fa-tachometer-alt"></i>Executive Summary
                    </a>
                    <a class="nav-link" href="#content" data-bs-toggle="tab">
                        <i class="fas fa-film"></i>Content Management
                    </a>
                    <a class="nav-link" href="#lifecycle" data-bs-toggle="tab">
                        <i class="fas fa-sync-alt"></i>Lifecycle Tracker
                    </a>
                    <a class="nav-link" href="#analytics" data-bs-toggle="tab">
                        <i class="fas fa-chart-bar"></i>Cross-Studio Analytics
                    </a>
                    <a class="nav-link" href="#popularity" data-bs-toggle="tab">
                        <i class="fas fa-fire"></i>Popularity Index
                    </a>
                    <a class="nav-link" href="#performance" data-bs-toggle="tab">
                        <i class="fas fa-trophy"></i>Top Performer
                    </a>
                    <a class="nav-link" href="#trends" data-bs-toggle="tab">
                        <i class="fas fa-globe"></i>Global Trends
                    </a>
                    <a class="nav-link" href="#language" data-bs-toggle="tab">
                        <i class="fas fa-language"></i>Language Analytics
                    </a>
                    <a class="nav-link" href="#production" data-bs-toggle="tab">
                        <i class="fas fa-industry"></i>Production Analytics
                    </a>
                    <a class="nav-link" href="#portfolio" data-bs-toggle="tab">
                        <i class="fas fa-chart-pie"></i>Portfolio Analysis
                    </a>
                    <a class="nav-link" href="#reports" data-bs-toggle="tab">
                        <i class="fas fa-file-export"></i>Report Generator
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="tab-content">
                    <!-- Executive Summary Dashboard -->
                    <div class="tab-pane fade show active" id="summary">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold mb-0">Executive Summary Dashboard</h3>
                            <div class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                <?php echo date('F j, Y'); ?>
                            </div>
                        </div>

                        <!-- Key Metrics -->
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <div class="stat-card text-center">
                                    <div class="stat-number">{{ count($films) }}</div>
                                    <div class="text-muted">Total Content</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="stat-card text-center">
                                    @php
                                        $avgRating = array_sum(array_column($films, 'rating')) / count($films);
                                    @endphp
                                    <div class="stat-number">{{ number_format($avgRating, 1) }}</div>
                                    <div class="text-muted">Average Rating</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="stat-card text-center">
                                    @php
                                        $totalPopularity = array_sum(array_column($films, 'popularity')) * 10000;
                                    @endphp
                                    <div class="stat-number">{{ number_format($totalPopularity) }}</div>
                                    <div class="text-muted">Total Views</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="stat-card text-center">
                                    @php
                                        $avgPopularity = array_sum(array_column($films, 'popularity')) / count($films);
                                    @endphp
                                    <div class="stat-number">{{ number_format($avgPopularity, 1) }}</div>
                                    <div class="text-muted">Avg Popularity</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="stat-card text-center">
                                    <div class="stat-number">{{ date('Y') }}</div>
                                    <div class="text-muted">Current Year</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="stat-card text-center">
                                    @php
                                        $currentYearFilms = array_filter($films, function($film) {
                                            return $film['year'] == date('Y');
                                        });
                                    @endphp
                                    <div class="stat-number">{{ count($currentYearFilms) }}</div>
                                    <div class="text-muted">YTD Releases</div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Overview Charts -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Content Distribution by Type</h5>
                                    <canvas id="contentTypeChart" height="200"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Monthly Performance Trend</h5>
                                    <canvas id="performanceTrendChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Studio Content Management -->
                    <div class="tab-pane fade" id="content">
                        <h3 class="fw-bold mb-4">Studio Content Management (CRUD)</h3>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="btn-group">
                                <button class="btn btn-outline-primary active">All Content</button>
                                <button class="btn btn-outline-primary">Movies</button>
                                <button class="btn btn-outline-primary">TV Shows</button>
                                <button class="btn btn-outline-primary">Actors</button>
                                <button class="btn btn-outline-primary">Crew</button>
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContentModal">
                                <i class="fas fa-plus me-1"></i>Add New Content
                            </button>
                        </div>

                        <div class="content-table">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Rating</th>
                                        <th>Popularity</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($films as $film)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $film['poster'] }}" alt="{{ $film['title'] }}" 
                                                     style="width: 40px; height: 60px; object-fit: cover; border-radius: 4px;" class="me-3">
                                                <div>
                                                    <strong>{{ $film['title'] }}</strong>
                                                    <div class="text-muted small">{{ $film['year'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $film['type'] === 'movie' ? 'Movie' : 'TV Show' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-released">Released</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-warning">⭐ {{ $film['rating'] }}</span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 8px; width: 100px;">
                                                <div class="progress-bar bg-success" style="width: {{ $film['popularity'] }}%"></div>
                                            </div>
                                            <small>{{ $film['popularity'] }}/100</small>
                                        </td>
                                        <td>
                                            {{ date('M j, Y', strtotime('-'.rand(1,30).' days')) }}
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-info" title="View Analytics">
                                                    <i class="fas fa-chart-bar"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Content Lifecycle Tracker -->
                    <div class="tab-pane fade" id="lifecycle">
                        <h3 class="fw-bold mb-4">Content Lifecycle Tracker</h3>
                        
                        <div class="lifecycle-tracker mb-4">
                            <div class="row mb-4">
                                <div class="col-md-4 text-center">
                                    <div class="stat-card">
                                        <div class="stat-number">8</div>
                                        <div class="text-muted">Upcoming</div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="stat-card">
                                        <div class="stat-number">18</div>
                                        <div class="text-muted">Released</div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="stat-card">
                                        <div class="stat-number">6</div>
                                        <div class="text-muted">Archived</div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3">Production Timeline</h5>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <h6 class="fw-bold">Inception 2</h6>
                                    <div class="text-muted small">Pre-production → Filming → Post-production → Release</div>
                                    <div class="progress mt-2" style="height: 8px;">
                                        <div class="progress-bar bg-warning" style="width: 40%"></div>
                                    </div>
                                    <small class="text-muted">Estimated release: June 2024</small>
                                </div>
                                <div class="timeline-item">
                                    <h6 class="fw-bold">Dark: New Generation</h6>
                                    <div class="text-muted small">Script Writing → Casting → Pre-production</div>
                                    <div class="progress mt-2" style="height: 8px;">
                                        <div class="progress-bar bg-info" style="width: 25%"></div>
                                    </div>
                                    <small class="text-muted">Estimated release: December 2024</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cross-Studio Analytics -->
                    <div class="tab-pane fade" id="analytics">
                        <h3 class="fw-bold mb-4">Cross-Studio Analytics (Read Only)</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Rating Trends Comparison</h5>
                                    <canvas id="ratingComparisonChart" height="200"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Market Share by Studio</h5>
                                    <canvas id="marketShareChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="content-table">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Studio</th>
                                        <th>Avg Rating</th>
                                        <th>Total Content</th>
                                        <th>Market Share</th>
                                        <th>Trend</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>CloseSense Studio</strong></td>
                                        <td>8.7</td>
                                        <td>{{ count($films) }}</td>
                                        <td>32%</td>
                                        <td><span class="text-success">↑ 2%</span></td>
                                    </tr>
                                    <tr>
                                        <td>Pixel Pictures</td>
                                        <td>8.5</td>
                                        <td>18</td>
                                        <td>28%</td>
                                        <td><span class="text-danger">↓ 1%</span></td>
                                    </tr>
                                    <tr>
                                        <td>DreamWorks Animation</td>
                                        <td>8.2</td>
                                        <td>15</td>
                                        <td>24%</td>
                                        <td><span class="text-success">↑ 1%</span></td>
                                    </tr>
                                    <tr>
                                        <td>Global Media</td>
                                        <td>7.9</td>
                                        <td>12</td>
                                        <td>16%</td>
                                        <td><span class="text-danger">↓ 2%</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Real-Time Popularity Index -->
                    <div class="tab-pane fade" id="popularity">
                        <h3 class="fw-bold mb-4">Real-Time Popularity Index</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="popularity-gauge mb-3">
                                        <div class="gauge-inner">87</div>
                                    </div>
                                    <h5>Overall Popularity Score</h5>
                                    <p class="text-muted">Based on rating, views, and engagement metrics</p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Popularity Trends (Last 30 Days)</h5>
                                    <canvas id="popularityTrendChart" height="150"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="content-table">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Content</th>
                                        <th>Popularity Score</th>
                                        <th>Weekly Change</th>
                                        <th>Engagement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(array_slice($films, 0, 5) as $film)
                                    <tr>
                                        <td>{{ $film['title'] }}</td>
                                        <td>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-success" style="width: {{ $film['popularity'] }}%"></div>
                                            </div>
                                            <small>{{ $film['popularity'] }}/100</small>
                                        </td>
                                        <td>
                                            @if($film['popularity'] > 95)
                                                <span class="text-success">↑ 5.2%</span>
                                            @elseif($film['popularity'] > 90)
                                                <span class="text-warning">↑ 2.1%</span>
                                            @else
                                                <span class="text-danger">↓ 1.3%</span>
                                            @endif
                                        </td>
                                        <td>{{ rand(70, 95) }}%</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Top Performer Dashboard -->
                    <div class="tab-pane fade" id="performance">
                        <h3 class="fw-bold mb-4">Top Performer Dashboard</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Top 10 Films This Week</h5>
                                    <canvas id="topFilmsChart" height="250"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Top 5 Popular Genres</h5>
                                    <canvas id="topGenresChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="chart-container">
                            <h5 class="fw-bold mb-4">Best Performing Actors</h5>
                            <div class="row">
                                @php
                                    $topActors = [
                                        ['name' => 'Leonardo DiCaprio', 'score' => 95, 'change' => '+3'],
                                        ['name' => 'Matthew McConaughey', 'score' => 92, 'change' => '+5'],
                                        ['name' => 'Emma Stone', 'score' => 89, 'change' => '+2'],
                                        ['name' => 'Bryan Cranston', 'score' => 88, 'change' => '+4'],
                                        ['name' => 'Louis Hofmann', 'score' => 85, 'change' => '+7']
                                    ];
                                @endphp
                                @foreach($topActors as $actor)
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center p-3 border rounded">
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px; font-size: 1.2rem; font-weight: bold;">
                                                {{ substr($actor['name'], 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ $actor['name'] }}</h6>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-success" style="width: {{ $actor['score'] }}%"></div>
                                            </div>
                                            <small class="text-muted">Performance Score: {{ $actor['score'] }}</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-success">{{ $actor['change'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Global Trend Monitoring -->
                    <div class="tab-pane fade" id="trends">
                        <h3 class="fw-bold mb-4">Global Trend Monitoring</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Genre Trends by Region</h5>
                                    <canvas id="genreTrendsChart" height="200"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Top Growing Markets</h5>
                                    <div class="list-group">
                                        @foreach([
                                            ['region' => 'Southeast Asia', 'growth' => '+45%', 'trend' => 'up'],
                                            ['region' => 'Latin America', 'growth' => '+38%', 'trend' => 'up'],
                                            ['region' => 'Eastern Europe', 'growth' => '+25%', 'trend' => 'up'],
                                            ['region' => 'Middle East', 'growth' => '+18%', 'trend' => 'up'],
                                            ['region' => 'Western Europe', 'growth' => '-12%', 'trend' => 'down']
                                        ] as $region)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $region['region'] }}
                                            <span class="badge bg-{{ $region['trend'] === 'up' ? 'success' : 'danger' }}">
                                                {{ $region['growth'] }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Multi-Language Analytics -->
                    <div class="tab-pane fade" id="language">
                        <h3 class="fw-bold mb-4">Multi-Language Metadata & Subtitle Analytics</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Subtitle Language Distribution</h5>
                                    <canvas id="subtitleLanguageChart" height="250"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Subtitle Demand Growth</h5>
                                    <canvas id="subtitleGrowthChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Production Performance Analytics -->
                    <div class="tab-pane fade" id="production">
                        <h3 class="fw-bold mb-4">Production Performance Analytics</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Studio Performance by Year</h5>
                                    <canvas id="studioPerformanceChart" height="250"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Success Rate Analysis</h5>
                                    <canvas id="successRateChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="content-table">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Studio</th>
                                        <th>Total Productions</th>
                                        <th>Avg Rating</th>
                                        <th>Success Rate</th>
                                        <th>High Performers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>CloseSense Studio</strong></td>
                                        <td>{{ count($films) }}</td>
                                        <td>{{ number_format($avgRating, 1) }}</td>
                                        <td>78%</td>
                                        <td>8</td>
                                    </tr>
                                    <tr>
                                        <td>Pixel Pictures</td>
                                        <td>18</td>
                                        <td>8.5</td>
                                        <td>72%</td>
                                        <td>6</td>
                                    </tr>
                                    <tr>
                                        <td>DreamWorks Animation</td>
                                        <td>15</td>
                                        <td>8.2</td>
                                        <td>68%</td>
                                        <td>5</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Content Portfolio Analysis -->
                    <div class="tab-pane fade" id="portfolio">
                        <h3 class="fw-bold mb-4">Content Portfolio Analysis</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="portfolio-card text-center">
                                    <h5 class="text-primary">{{ count($films) }}</h5>
                                    <p class="text-muted mb-0">Total Content</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="portfolio-card text-center">
                                    @php
                                        $moviesCount = count(array_filter($films, function($film) {
                                            return $film['type'] === 'movie';
                                        }));
                                    @endphp
                                    <h5 class="text-success">{{ $moviesCount }}</h5>
                                    <p class="text-muted mb-0">Movies ({{ number_format(($moviesCount/count($films))*100, 1) }}%)</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="portfolio-card text-center">
                                    @php
                                        $showsCount = count(array_filter($films, function($film) {
                                            return $film['type'] === 'show';
                                        }));
                                    @endphp
                                    <h5 class="text-warning">{{ $showsCount }}</h5>
                                    <p class="text-muted mb-0">TV Shows ({{ number_format(($showsCount/count($films))*100, 1) }}%)</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Genre Distribution</h5>
                                    <canvas id="genreDistributionChart" height="250"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Content by Release Year</h5>
                                    <canvas id="releaseYearChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comprehensive Report Generator -->
                    <div class="tab-pane fade" id="reports">
                        <h3 class="fw-bold mb-4">Comprehensive Report Generator</h3>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Generate New Report</h5>
                                    <form>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Report Type</label>
                                                <select class="form-select">
                                                    <option>Monthly Performance</option>
                                                    <option>Quarterly Analytics</option>
                                                    <option>Content Performance</option>
                                                    <option>Studio Comparison</option>
                                                    <option>Market Analysis</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Time Period</label>
                                                <select class="form-select">
                                                    <option>Last 30 Days</option>
                                                    <option>Last Quarter</option>
                                                    <option>Last 6 Months</option>
                                                    <option>Last Year</option>
                                                    <option>Custom Range</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Format</label>
                                                <div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="format" id="pdf" checked>
                                                        <label class="form-check-label" for="pdf">PDF</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="format" id="excel">
                                                        <label class="form-check-label" for="excel">Excel</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="format" id="csv">
                                                        <label class="form-check-label" for="csv">CSV</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Include Data</label>
                                                <div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" checked>
                                                        <label class="form-check-label">Viewership</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" checked>
                                                        <label class="form-check-label">Ratings</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox">
                                                        <label class="form-check-label">Financial</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-download me-1"></i>Generate Report
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Recent Reports</h5>
                                    <div style="max-height: 300px; overflow-y: auto;">
                                        @foreach([
                                            ['name' => 'Q3 2024 Performance Report', 'date' => 'Oct 1, 2024', 'size' => '2.4 MB'],
                                            ['name' => 'September Content Analytics', 'date' => 'Sep 30, 2024', 'size' => '1.8 MB'],
                                            ['name' => 'Competitor Analysis Q3', 'date' => 'Sep 25, 2024', 'size' => '3.1 MB'],
                                            ['name' => 'August Financial Summary', 'date' => 'Sep 1, 2024', 'size' => '1.2 MB']
                                        ] as $report)
                                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                                            <i class="fas fa-file-pdf text-danger me-3"></i>
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold">{{ $report['name'] }}</div>
                                                <small class="text-muted">{{ $report['date'] }} • {{ $report['size'] }}</small>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize all charts
        document.addEventListener('DOMContentLoaded', function() {
            // Content Type Chart
            new Chart(document.getElementById('contentTypeChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Movies', 'TV Shows'],
                    datasets: [{
                        data: [{{ $moviesCount }}, {{ $showsCount }}],
                        backgroundColor: ['#1a56db', '#7e3af2']
                    }]
                }
            });

            // Add more chart initializations as needed...
        });
    </script>
</body>
</html>