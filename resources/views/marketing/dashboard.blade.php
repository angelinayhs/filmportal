<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Marketing Dashboard - CloseSense Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --success-color: #0e9f6e;
            --warning-color: #f59e0b;
            --danger-color: #e02424;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .navbar-marketing {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 12px 0;
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--primary-color) !important;
            font-size: 28px;
            letter-spacing: -0.5px;
        }

        .sidebar {
            background: rgba(255, 255, 255, 0.95);
            min-height: calc(100vh - 76px);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 76px;
            border-radius: 0 20px 20px 0;
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
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
        }

        .main-content {
            background: transparent;
            min-height: calc(100vh - 76px);
            padding: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
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
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .content-table {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .heatmap-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .heatmap {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            margin-top: 15px;
        }

        .heatmap-cell {
            height: 40px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: white;
        }

        .heatmap-cell.low { background: #e5e7eb; color: #6b7280; }
        .heatmap-cell.medium { background: #f59e0b; }
        .heatmap-cell.high { background: #0e9f6e; }
        .heatmap-cell.very-high { background: #e02424; }

        .campaign-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
            border-left: 4px solid var(--primary-color);
        }

        .badge-upcoming { background: var(--warning-color); }
        .badge-active { background: var(--success-color); }
        .badge-completed { background: var(--danger-color); }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-marketing">
        <div class="container">
            <a class="navbar-brand" href="#">
                🎯 CloseSense Marketing
            </a>
            <div class="ms-auto d-flex gap-2 align-items-center">
                <span class="text-dark me-3">
                    <i class="fas fa-chart-line me-1"></i>Marketing Team
                </span>
                <a href="/" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-eye me-1"></i>User Portal
                </a>
                <!-- PERBAIKAN: Ganti route marketing.login dengan route yang ada -->
                <form method="POST" action="{{ route('logout') }}">
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
                    <a class="nav-link active" href="#performance" data-bs-toggle="tab">
                        <i class="fas fa-tachometer-alt"></i>Performance Dashboard
                    </a>
                    <a class="nav-link" href="#audience" data-bs-toggle="tab">
                        <i class="fas fa-users"></i>Audience Segmentation
                    </a>
                    <a class="nav-link" href="#campaigns" data-bs-toggle="tab">
                        <i class="fas fa-bullhorn"></i>Campaign Management
                    </a>
                    <a class="nav-link" href="#trends" data-bs-toggle="tab">
                        <i class="fas fa-chart-line"></i>Predictive Trends
                    </a>
                    <a class="nav-link" href="#collaboration" data-bs-toggle="tab">
                        <i class="fas fa-handshake"></i>Collaboration Insights
                    </a>
                    <a class="nav-link" href="#conversion" data-bs-toggle="tab">
                        <i class="fas fa-funnel-dollar"></i>Conversion Tracker
                    </a>
                    <a class="nav-link" href="#heatmap" data-bs-toggle="tab">
                        <i class="fas fa-map"></i>Audience Heatmap
                    </a>
                    <a class="nav-link" href="#keywords" data-bs-toggle="tab">
                        <i class="fas fa-search"></i>Keyword Explorer
                    </a>
                    <a class="nav-link" href="#studio" data-bs-toggle="tab">
                        <i class="fas fa-building"></i>Studio Performance
                    </a>
                    <a class="nav-link" href="#genre" data-bs-toggle="tab">
                        <i class="fas fa-film"></i>Genre Analytics
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="tab-content">
                    <!-- Marketing Performance Dashboard -->
                    <div class="tab-pane fade show active" id="performance">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold text-white mb-0">Marketing Performance Dashboard</h3>
                            <div class="text-white">
                                <i class="fas fa-calendar me-1"></i>
                                {{ date('F j, Y') }}
                            </div>
                        </div>

                        <!-- Key Metrics -->
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <div class="stat-card text-center">
                                    <!-- PERBAIKAN: Gunakan data dummy jika $films tidak ada -->
                                    <div class="stat-number">{{ $films ? count($films) : '25' }}</div>
                                    <div class="text-muted">Total Content</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="stat-card text-center">
                                    @php
                                        // PERBAIKAN: Data dummy jika $films tidak tersedia
                                        $avgPopularity = $films ? array_sum(array_column($films, 'popularity')) / count($films) : 85.5;
                                    @endphp
                                    <div class="stat-number">{{ number_format($avgPopularity, 1) }}</div>
                                    <div class="text-muted">Avg Popularity</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="stat-card text-center">
                                    @php
                                        $totalEngagement = $films ? array_sum(array_column($films, 'popularity')) * 1000 : 2135000;
                                    @endphp
                                    <div class="stat-number">{{ number_format($totalEngagement) }}</div>
                                    <div class="text-muted">Total Engagement</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="stat-card text-center">
                                    @php
                                        // PERBAIKAN: Data dummy untuk high performers
                                        $highPerformers = $films ? array_filter($films, function($film) {
                                            return $film['rating'] >= 8.5 && $film['popularity'] >= 90;
                                        }) : [1,2,3,4,5,6]; // 6 high performers dummy
                                    @endphp
                                    <div class="stat-number">{{ count($highPerformers) }}</div>
                                    <div class="text-muted">High Performers</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="stat-card text-center">
                                    @php
                                        $currentYear = date('Y');
                                        $currentYearReleases = $films ? array_filter($films, function($film) use ($currentYear) {
                                            return $film['year'] == $currentYear;
                                        }) : [1,2,3,4]; // 4 YTD releases dummy
                                    @endphp
                                    <div class="stat-number">{{ count($currentYearReleases) }}</div>
                                    <div class="text-muted">YTD Releases</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="stat-card text-center">
                                    <div class="stat-number">78%</div>
                                    <div class="text-muted">Campaign Success</div>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Charts -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Campaign Performance Trend</h5>
                                    <canvas id="campaignTrendChart" height="200"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Engagement by Platform</h5>
                                    <canvas id="platformEngagementChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Audience Segmentation & Profiling -->
                    <div class="tab-pane fade" id="audience">
                        <h3 class="fw-bold text-white mb-4">Audience Segmentation & Profiling</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Age Distribution</h5>
                                    <canvas id="ageDistributionChart" height="250"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Geographic Distribution</h5>
                                    <canvas id="geoDistributionChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Genre Preferences</h5>
                                    <canvas id="genrePreferenceChart" height="200"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Watch Time Patterns</h5>
                                    <canvas id="watchTimeChart" height="200"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Device Usage</h5>
                                    <canvas id="deviceUsageChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campaign Management (CRUD) -->
                    <div class="tab-pane fade" id="campaigns">
                        <h3 class="fw-bold text-white mb-4">Campaign Management (CRUD)</h3>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="btn-group">
                                <button class="btn btn-outline-primary active">All Campaigns</button>
                                <button class="btn btn-outline-primary">Active</button>
                                <button class="btn btn-outline-primary">Upcoming</button>
                                <button class="btn btn-outline-primary">Completed</button>
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCampaignModal">
                                <i class="fas fa-plus me-1"></i>Create Campaign
                            </button>
                        </div>

                        <!-- Campaign Cards -->
                        <div class="row">
                            @foreach([
                                ['title' => 'Inception Anniversary Campaign', 'status' => 'active', 'platform' => 'Multi-Platform', 'budget' => '$50K', 'engagement' => '45K'],
                                ['title' => 'Dark Season 4 Launch', 'status' => 'upcoming', 'platform' => 'Social Media', 'budget' => '$30K', 'engagement' => '0'],
                                ['title' => 'Interstellar Re-release', 'status' => 'completed', 'platform' => 'Theatrical', 'budget' => '$75K', 'engagement' => '120K'],
                                ['title' => 'Breaking Bad Prequel', 'status' => 'active', 'platform' => 'Digital Ads', 'budget' => '$40K', 'engagement' => '28K']
                            ] as $campaign)
                            <div class="col-md-6">
                                <div class="campaign-card">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h6 class="fw-bold mb-0">{{ $campaign['title'] }}</h6>
                                        <!-- PERBAIKAN: Ganti class badge -->
                                        <span class="badge bg-{{ $campaign['status'] === 'active' ? 'success' : ($campaign['status'] === 'upcoming' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($campaign['status']) }}
                                        </span>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <small class="text-muted">Platform</small>
                                            <div class="fw-semibold">{{ $campaign['platform'] }}</div>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Budget</small>
                                            <div class="fw-semibold">{{ $campaign['budget'] }}</div>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Engagement</small>
                                            <div class="fw-semibold">{{ $campaign['engagement'] }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-3 d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                                        <button class="btn btn-sm btn-outline-info">Analytics</button>
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Predictive Trend Forecasting -->
                    <div class="tab-pane fade" id="trends">
                        <h3 class="fw-bold text-white mb-4">Predictive Trend Forecasting</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Genre Trend Projection (Next 6 Months)</h5>
                                    <canvas id="trendProjectionChart" height="200"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Top Rising Trends</h5>
                                    <div class="list-group">
                                        @foreach([
                                            ['trend' => 'AI Thrillers', 'growth' => '+45%', 'confidence' => 'high'],
                                            ['trend' => 'True Crime Documentaries', 'growth' => '+38%', 'confidence' => 'medium'],
                                            ['trend' => 'Anime Adaptations', 'growth' => '+32%', 'confidence' => 'high'],
                                            ['trend' => 'Historical Dramas', 'growth' => '+25%', 'confidence' => 'medium'],
                                            ['trend' => 'Virtual Reality Content', 'growth' => '+18%', 'confidence' => 'low']
                                        ] as $trend)
                                        <div class="list-group-item">
                                            <div class="fw-semibold">{{ $trend['trend'] }}</div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-success">{{ $trend['growth'] }}</span>
                                                <span class="badge bg-{{ $trend['confidence'] === 'high' ? 'success' : ($trend['confidence'] === 'medium' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($trend['confidence']) }}
                                                </span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Collaboration Insight -->
                    <div class="tab-pane fade" id="collaboration">
                        <h3 class="fw-bold text-white mb-4">Collaboration Insight (Cross-Studio Promotion View)</h3>
                        
                        <div class="content-table">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Studio</th>
                                        <th>Campaign</th>
                                        <th>Platform</th>
                                        <th>Duration</th>
                                        <th>Engagement</th>
                                        <th>ROI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach([
                                        ['studio' => 'Pixel Pictures', 'campaign' => 'Summer Blockbuster', 'platform' => 'Social Media', 'duration' => '2 months', 'engagement' => '250K', 'roi' => '3.2x'],
                                        ['studio' => 'DreamWorks', 'campaign' => 'Animation Festival', 'platform' => 'YouTube', 'duration' => '1 month', 'engagement' => '180K', 'roi' => '2.8x'],
                                        ['studio' => 'Global Media', 'campaign' => 'Documentary Series', 'platform' => 'Streaming', 'duration' => '3 months', 'engagement' => '95K', 'roi' => '1.9x'],
                                        ['studio' => 'Star Studios', 'campaign' => 'Action Movie Launch', 'platform' => 'TV Ads', 'duration' => '6 weeks', 'engagement' => '320K', 'roi' => '4.1x']
                                    ] as $campaign)
                                    <tr>
                                        <td><strong>{{ $campaign['studio'] }}</strong></td>
                                        <td>{{ $campaign['campaign'] }}</td>
                                        <td>{{ $campaign['platform'] }}</td>
                                        <td>{{ $campaign['duration'] }}</td>
                                        <td>{{ $campaign['engagement'] }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $campaign['roi'] }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Conversion & Engagement Tracker -->
                    <div class="tab-pane fade" id="conversion">
                        <h3 class="fw-bold text-white mb-4">Conversion & Engagement Tracker</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Campaign Funnel Analysis</h5>
                                    <canvas id="funnelChart" height="250"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Engagement Metrics</h5>
                                    <canvas id="engagementMetricsChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="content-table">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Campaign</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>Conversions</th>
                                        <th>Completion Rate</th>
                                        <th>CPA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach([
                                        ['campaign' => 'Inception Anniversary', 'impressions' => '1.2M', 'clicks' => '45K', 'conversions' => '8.2K', 'completion' => '68%', 'cpa' => '$4.25'],
                                        ['campaign' => 'Dark S4 Launch', 'impressions' => '850K', 'clicks' => '32K', 'conversions' => '6.1K', 'completion' => '72%', 'cpa' => '$3.80'],
                                        ['campaign' => 'Interstellar Re-release', 'impressions' => '2.1M', 'clicks' => '78K', 'conversions' => '15.3K', 'completion' => '81%', 'cpa' => '$2.95']
                                    ] as $metric)
                                    <tr>
                                        <td><strong>{{ $metric['campaign'] }}</strong></td>
                                        <td>{{ $metric['impressions'] }}</td>
                                        <td>{{ $metric['clicks'] }}</td>
                                        <td>{{ $metric['conversions'] }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $metric['completion'] }}</span>
                                        </td>
                                        <td>{{ $metric['cpa'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Audience Behavior Heatmap -->
                    <div class="tab-pane fade" id="heatmap">
                        <h3 class="fw-bold text-white mb-4">Audience Behavior Heatmap</h3>
                        
                        <div class="heatmap-container">
                            <h5 class="fw-bold mb-4">Weekly Activity Heatmap</h5>
                            <div class="heatmap">
                                <!-- Header Row -->
                                <div class="heatmap-cell low">Time</div>
                                @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                                <div class="heatmap-cell low">{{ $day }}</div>
                                @endforeach
                                
                                <!-- Data Rows -->
                                @foreach([
                                    ['time' => '6AM', 'data' => ['low', 'low', 'low', 'low', 'low', 'medium', 'medium']],
                                    ['time' => '9AM', 'data' => ['medium', 'medium', 'medium', 'low', 'medium', 'high', 'high']],
                                    ['time' => '12PM', 'data' => ['high', 'high', 'medium', 'medium', 'high', 'very-high', 'very-high']],
                                    ['time' => '3PM', 'data' => ['very-high', 'high', 'high', 'high', 'very-high', 'very-high', 'very-high']],
                                    ['time' => '6PM', 'data' => ['very-high', 'very-high', 'very-high', 'very-high', 'very-high', 'very-high', 'very-high']],
                                    ['time' => '9PM', 'data' => ['high', 'high', 'high', 'high', 'high', 'very-high', 'very-high']],
                                    ['time' => '12AM', 'data' => ['medium', 'medium', 'medium', 'medium', 'high', 'high', 'high']]
                                ] as $row)
                                <div class="heatmap-cell low">{{ $row['time'] }}</div>
                                @foreach($row['data'] as $activity)
                                <div class="heatmap-cell {{ $activity }}">{{ ucfirst($activity) }}</div>
                                @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Keyword & Genre Trend Explorer -->
                    <div class="tab-pane fade" id="keywords">
                        <h3 class="fw-bold text-white mb-4">Keyword & Genre Trend Explorer</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Top Search Keywords</h5>
                                    <canvas id="keywordTrendChart" height="250"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h5 class="fw-bold mb-4">Genre Popularity Trend</h5>
                                    <canvas id="genreTrendChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="content-table">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Keyword</th>
                                        <th>Search Volume</th>
                                        <th>Growth</th>
                                        <th>Competition</th>
                                        <th>Opportunity Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach([
                                        ['keyword' => 'sci-fi thriller', 'volume' => '45K', 'growth' => '+32%', 'competition' => 'High', 'score' => '65'],
                                        ['keyword' => 'time travel movies', 'volume' => '38K', 'growth' => '+28%', 'competition' => 'Medium', 'score' => '82'],
                                        ['keyword' => 'psychological drama', 'volume' => '29K', 'growth' => '+45%', 'competition' => 'Low', 'score' => '91'],
                                        ['keyword' => 'crime series 2024', 'volume' => '52K', 'growth' => '+15%', 'competition' => 'High', 'score' => '58'],
                                        ['keyword' => 'animation comedy', 'volume' => '41K', 'growth' => '+22%', 'competition' => 'Medium', 'score' => '76']
                                    ] as $keyword)
                                    <tr>
                                        <td><strong>{{ $keyword['keyword'] }}</strong></td>
                                        <td>{{ $keyword['volume'] }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $keyword['growth'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $keyword['competition'] === 'High' ? 'danger' : ($keyword['competition'] === 'Medium' ? 'warning' : 'success') }}">
                                                {{ $keyword['competition'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" style="width: {{ $keyword['score'] }}%"></div>
                                            </div>
                                            <small>{{ $keyword['score'] }}/100</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Content Performance by Studio -->
                    <div class="tab-pane fade" id="studio">
                        <h3 class="fw-bold text-white mb-4">Content Performance by Studio</h3>
                        
                        <div class="content-table">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Studio</th>
                                        <th>Total Content</th>
                                        <th>Avg Rating</th>
                                        <th>Avg Popularity</th>
                                        <th>Total Engagement</th>
                                        <th>High Performers</th>
                                        <th>YTD Releases</th>
                                        <th>Success Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // PERBAIKAN: Data dummy untuk studio performance
                                        $dummyFilms = $films ?? [];
                                        $dummyAvgRating = $films ? array_sum(array_column($films, 'rating')) / count($films) : 8.4;
                                        $dummyAvgPopularity = $films ? array_sum(array_column($films, 'popularity')) / count($films) : 85.5;
                                        $dummyTotalEngagement = $films ? array_sum(array_column($films, 'popularity')) * 1000 : 2135000;
                                        $dummyHighPerformers = $films ? array_filter($films, function($film) {
                                            return $film['rating'] >= 8.5 && $film['popularity'] >= 90;
                                        }) : [1,2,3,4,5,6];
                                        $dummyCurrentYearReleases = $films ? array_filter($films, function($film) use ($currentYear) {
                                            return $film['year'] == $currentYear;
                                        }) : [1,2,3,4];
                                    @endphp
                                    @foreach([
                                        ['studio' => 'CloseSense Studio', 'content' => count($dummyFilms) ?: '25', 'rating' => number_format($dummyAvgRating, 1), 'popularity' => number_format($dummyAvgPopularity, 1), 'engagement' => number_format($dummyTotalEngagement), 'performers' => count($dummyHighPerformers), 'releases' => count($dummyCurrentYearReleases), 'success' => '78%'],
                                        ['studio' => 'Pixel Pictures', 'content' => '18', 'rating' => '8.5', 'popularity' => '88.2', 'engagement' => '1,584,000', 'performers' => '6', 'releases' => '5', 'success' => '72%'],
                                        ['studio' => 'DreamWorks', 'content' => '15', 'rating' => '8.2', 'popularity' => '85.6', 'engagement' => '1,284,000', 'performers' => '5', 'releases' => '4', 'success' => '68%'],
                                        ['studio' => 'Global Media', 'content' => '12', 'rating' => '7.9', 'popularity' => '82.1', 'engagement' => '985,200', 'performers' => '3', 'releases' => '3', 'success' => '62%']
                                    ] as $studio)
                                    <tr>
                                        <td><strong>{{ $studio['studio'] }}</strong></td>
                                        <td>{{ $studio['content'] }}</td>
                                        <td>⭐ {{ $studio['rating'] }}</td>
                                        <td>{{ $studio['popularity'] }}</td>
                                        <td>{{ $studio['engagement'] }}</td>
                                        <td>{{ $studio['performers'] }}</td>
                                        <td>{{ $studio['releases'] }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $studio['success'] }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Genre Performance Analytics -->
                    <div class="tab-pane fade" id="genre">
                        <h3 class="fw-bold text-white mb-4">Genre Performance Analytics</h3>
                        
                        <div class="content-table">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Genre</th>
                                        <th>Content Count</th>
                                        <th>Avg Rating</th>
                                        <th>Avg Popularity</th>
                                        <th>Total Engagement</th>
                                        <th>Studios</th>
                                        <th>Market Share</th>
                                        <th>Rank</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // PERBAIKAN: Data dummy untuk genre analytics
                                        $dummyGenreStats = [
                                            'Sci-Fi' => ['count' => 8, 'avg_rating' => 8.7, 'avg_popularity' => 92.5, 'engagement' => 740000, 'market_share' => 32.0],
                                            'Drama' => ['count' => 6, 'avg_rating' => 8.4, 'avg_popularity' => 88.2, 'engagement' => 529200, 'market_share' => 24.0],
                                            'Action' => ['count' => 5, 'avg_rating' => 8.2, 'avg_popularity' => 85.6, 'engagement' => 428000, 'market_share' => 20.0],
                                            'Thriller' => ['count' => 4, 'avg_rating' => 8.1, 'avg_popularity' => 83.3, 'engagement' => 333200, 'market_share' => 16.0],
                                            'Comedy' => ['count' => 2, 'avg_rating' => 7.8, 'avg_popularity' => 78.5, 'engagement' => 157000, 'market_share' => 8.0]
                                        ];
                                    @endphp
                                    
                                    @foreach($dummyGenreStats as $genre => $stats)
                                    <tr>
                                        <td><strong>{{ $genre }}</strong></td>
                                        <td>{{ $stats['count'] }}</td>
                                        <td>⭐ {{ number_format($stats['avg_rating'], 1) }}</td>
                                        <td>{{ number_format($stats['avg_popularity'], 1) }}</td>
                                        <td>{{ number_format($stats['engagement']) }}</td>
                                        <td>{{ rand(2, 5) }}</td>
                                        <td>{{ number_format($stats['market_share'], 1) }}%</td>
                                        <td>
                                            <span class="badge bg-primary">#{{ $loop->iteration }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
            // Campaign Trend Chart
            new Chart(document.getElementById('campaignTrendChart'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                    datasets: [{
                        label: 'Engagement',
                        data: [45, 52, 48, 65, 72, 68, 75, 82, 78, 85],
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        tension: 0.4
                    }]
                }
            });

            // Platform Engagement Chart
            new Chart(document.getElementById('platformEngagementChart'), {
                type: 'bar',
                data: {
                    labels: ['Social Media', 'YouTube', 'TV Ads', 'Streaming', 'Email'],
                    datasets: [{
                        label: 'Engagement Rate',
                        data: [65, 45, 35, 55, 25],
                        backgroundColor: [
                            '#6366f1', '#8b5cf6', '#0e9f6e', '#f59e0b', '#e02424'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Age Distribution Chart
            new Chart(document.getElementById('ageDistributionChart'), {
                type: 'pie',
                data: {
                    labels: ['13-17', '18-24', '25-34', '35-44', '45-54', '55+'],
                    datasets: [{
                        data: [12, 28, 35, 15, 6, 4],
                        backgroundColor: [
                            '#6366f1', '#8b5cf6', '#0e9f6e', '#f59e0b', '#e02424', '#6b7280'
                        ]
                    }]
                }
            });

            // Geographic Distribution Chart
            new Chart(document.getElementById('geoDistributionChart'), {
                type: 'doughnut',
                data: {
                    labels: ['North America', 'Europe', 'Asia', 'South America', 'Oceania', 'Africa'],
                    datasets: [{
                        data: [45, 25, 18, 7, 3, 2],
                        backgroundColor: [
                            '#6366f1', '#8b5cf6', '#0e9f6e', '#f59e0b', '#e02424', '#6b7280'
                        ]
                    }]
                }
            });

            // Genre Preference Chart
            new Chart(document.getElementById('genrePreferenceChart'), {
                type: 'polarArea',
                data: {
                    labels: ['Sci-Fi', 'Drama', 'Action', 'Comedy', 'Thriller'],
                    datasets: [{
                        data: [35, 25, 20, 15, 5],
                        backgroundColor: [
                            '#6366f1', '#8b5cf6', '#0e9f6e', '#f59e0b', '#e02424'
                        ]
                    }]
                }
            });

            // Watch Time Chart
            new Chart(document.getElementById('watchTimeChart'), {
                type: 'line',
                data: {
                    labels: ['6AM', '9AM', '12PM', '3PM', '6PM', '9PM', '12AM'],
                    datasets: [{
                        label: 'Average Watch Time (min)',
                        data: [25, 35, 45, 55, 75, 85, 65],
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        tension: 0.4
                    }]
                }
            });

            // Device Usage Chart
            new Chart(document.getElementById('deviceUsageChart'), {
                type: 'pie',
                data: {
                    labels: ['Mobile', 'Desktop', 'Tablet', 'Smart TV'],
                    datasets: [{
                        data: [45, 25, 15, 15],
                        backgroundColor: [
                            '#6366f1', '#8b5cf6', '#0e9f6e', '#f59e0b'
                        ]
                    }]
                }
            });

            // Trend Projection Chart
            new Chart(document.getElementById('trendProjectionChart'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [
                        {
                            label: 'Sci-Fi',
                            data: [65, 68, 72, 75, 78, 82],
                            borderColor: '#6366f1',
                            tension: 0.4
                        },
                        {
                            label: 'Drama',
                            data: [45, 48, 52, 55, 58, 62],
                            borderColor: '#8b5cf6',
                            tension: 0.4
                        },
                        {
                            label: 'Action',
                            data: [55, 58, 62, 65, 68, 72],
                            borderColor: '#0e9f6e',
                            tension: 0.4
                        }
                    ]
                }
            });

            // Funnel Chart
            new Chart(document.getElementById('funnelChart'), {
                type: 'bar',
                data: {
                    labels: ['Impressions', 'Clicks', 'Engagements', 'Conversions', 'Completions'],
                    datasets: [{
                        label: 'Conversion Funnel',
                        data: [100, 65, 45, 30, 25],
                        backgroundColor: '#6366f1'
                    }]
                },
                options: {
                    indexAxis: 'y'
                }
            });

            // Engagement Metrics Chart
            new Chart(document.getElementById('engagementMetricsChart'), {
                type: 'radar',
                data: {
                    labels: ['View Rate', 'Click Rate', 'Share Rate', 'Comment Rate', 'Completion Rate'],
                    datasets: [{
                        label: 'Current Campaign',
                        data: [85, 65, 45, 35, 75],
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.2)'
                    }]
                }
            });

            // Keyword Trend Chart
            new Chart(document.getElementById('keywordTrendChart'), {
                type: 'bar',
                data: {
                    labels: ['Sci-Fi', 'Thriller', 'Drama', 'Comedy', 'Action', 'Documentary'],
                    datasets: [{
                        label: 'Search Volume (K)',
                        data: [45, 38, 35, 32, 28, 25],
                        backgroundColor: '#6366f1'
                    }]
                }
            });

            // Genre Trend Chart
            new Chart(document.getElementById('genreTrendChart'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [
                        {
                            label: 'Sci-Fi Thriller',
                            data: [35, 42, 48, 55, 62, 68],
                            borderColor: '#6366f1',
                            tension: 0.4
                        },
                        {
                            label: 'True Crime',
                            data: [25, 32, 38, 45, 52, 58],
                            borderColor: '#8b5cf6',
                            tension: 0.4
                        },
                        {
                            label: 'Historical Drama',
                            data: [20, 25, 30, 35, 40, 45],
                            borderColor: '#0e9f6e',
                            tension: 0.4
                        }
                    ]
                }
            });
        });

        // Tab functionality
        const triggerTabList = document.querySelectorAll('#myTab button')
        triggerTabList.forEach(triggerEl => {
            const tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', event => {
                event.preventDefault()
                tabTrigger.show()
            })
        });
    </script>

    <!-- Create Campaign Modal -->
    <div class="modal fade" id="createCampaignModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Campaign</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Campaign Title</label>
                                    <input type="text" class="form-control" placeholder="Enter campaign title">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Platform</label>
                                    <select class="form-select">
                                        <option>Social Media</option>
                                        <option>YouTube</option>
                                        <option>TV Ads</option>
                                        <option>Streaming</option>
                                        <option>Email Marketing</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Budget</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" placeholder="Enter budget amount">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Target Audience</label>
                            <select class="form-select" multiple>
                                <option>13-17 Years</option>
                                <option>18-24 Years</option>
                                <option>25-34 Years</option>
                                <option>35-44 Years</option>
                                <option>45+ Years</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Campaign Description</label>
                            <textarea class="form-control" rows="3" placeholder="Describe the campaign objectives..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Create Campaign</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>