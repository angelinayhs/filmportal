<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CloseSense - Discover Movies & TV Shows</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --accent-color: #f59e0b;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        /* NAVBAR STYLING */
        .navbar-custom {
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

        .nav-menu {
            color: #4b5563 !important;
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .nav-menu:hover,
        .nav-menu.active {
            color: var(--primary-color) !important;
            background: rgba(99, 102, 241, 0.1);
            transform: translateY(-1px);
        }

        /* SEARCH & FILTER PANEL */
        .search-panel {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            margin-top: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .filter-sidebar {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        /* FILM CARD STYLING */
        .film-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
        }

        .film-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .poster {
            height: 280px;
            object-fit: cover;
            width: 100%;
        }

        .chip {
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 12px;
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            font-weight: 500;
            margin-right: 6px;
            margin-bottom: 6px;
            display: inline-block;
        }

        .rating-badge {
            background: linear-gradient(135deg, var(--accent-color), #f97316);
            color: white;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 13px;
        }

        /* SECTION TITLES */
        .section-title {
            font-weight: 800;
            color: white;
            font-size: 2rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            margin-bottom: 1.5rem;
        }

        /* TRENDING SLIDER */
        .trending-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 25px;
            margin: 30px 0;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
        }

        .swiper {
            width: 100%;
            height: 100%;
            border-radius: 16px;
        }

        .swiper-slide {
            text-align: center;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 16px;
            overflow: hidden;
        }

        .swiper-button-next, .swiper-button-prev {
            color: var(--primary-color);
            background: rgba(255, 255, 255, 0.9);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* DAILY HIGHLIGHT */
        .daily-highlight {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
        }

        .movie-history {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        /* QUICK PREVIEW */
        .quick-preview-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }

        .quick-preview-card {
            background: white;
            border-radius: 16px;
            max-width: 400px;
            width: 100%;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* AUTO-SUGGESTION */
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            max-height: 400px;
            overflow-y: auto;
            display: none;
            margin-top: 8px;
        }

        .suggestion-item {
            padding: 12px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .suggestion-item:hover {
            background: rgba(99, 102, 241, 0.1);
        }

        /* HORIZONTAL SCROLL */
        .horizontal-scroll {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            padding: 10px 0;
            scrollbar-width: thin;
        }

        .horizontal-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .horizontal-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .horizontal-scroll::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        .horizontal-item {
            flex: 0 0 auto;
            width: 200px;
        }

        /* TOP CHARTS */
        .top-charts {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
        }

        .chart-item {
            padding: 12px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .rank-badge {
            background: var(--primary-color);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
        }
        /* FIX QUICK PREVIEW JANGAN KEDIP */
    .quick-preview-overlay {
        pointer-events: none;
    }

    .quick-preview-card {
        pointer-events: auto;
    }
    </style>
</head>
<body>

    {{-- ALERT LOGIN ERROR EXECUTIVE --}}
    @if(session('login_error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('login_error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

   <!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="#">
            🎬 CloseSense
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link nav-menu active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-menu" href="#trending">Trending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-menu" href="#movies">Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-menu" href="#tvshows">TV Shows</a>
                </li>
                
                <!-- Marketing Login Button -->
<li class="nav-item">
    <button class="btn btn-success btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#marketingLoginModal">
        <i class="fas fa-bullhorn me-1"></i>Marketing Login
    </button>
</li>

<!-- Executive Login Button -->
<li class="nav-item">
    <button class="btn btn-primary btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#execLoginModal">
        <i class="fas fa-user-tie me-1"></i>Executive Login
    </button>
</li>

            </ul>
        </div>
    </div>
</nav>
        <!-- HERO SECTION -->
        <div class="text-center text-white mb-5 mt-4">
            <h1 class="display-4 fw-bold mb-3">Discover Your Next Favorite Story</h1>
            <p class="lead mb-4">Explore thousands of movies and TV shows with smart recommendations</p>
        </div>

        <!-- SMART CONTEXTUAL SEARCH -->
        <div class="search-panel">
            <div class="position-relative">
                <label class="form-label fw-semibold fs-5"><i class="fas fa-search me-2"></i>Smart Contextual Search</label>
                <input id="searchInput" type="text" class="form-control form-control-lg" 
                       placeholder="Try: 'thriller Leonardo', 'Nolan sci-fi', 'romance music'...">
                <div class="form-text">Search by title, actor, director, genre, or any combination</div>
                
                <!-- AUTO-SUGGESTION DROPDOWN -->
                <div id="searchSuggestions" class="search-suggestions">
                    <div id="suggestionsList"></div>
                </div>
            </div>
        </div>

<!-- DAILY HIGHLIGHT & MOVIE HISTORY -->
<div class="daily-highlight">
    <h3 class="fw-bold mb-4">📅 Daily Highlight & Movie History</h3>

    <!-- FILM HARI INI (Film of the Day) -->
    <div class="mb-4">
        @if($filmOfTheDay)
            <div class="film-card">
                <div class="row g-0">
                    <div class="col-12 p-4">
                        <h4 class="mb-2">🎬 Film Hari Ini</h4>

                        <h5 class="text-primary mb-1">
                            <a href="/film/{{ $filmOfTheDay->show_id }}" class="text-decoration-none">
                                {{ $filmOfTheDay->name }}
                            </a>
                        </h5>

                        <div class="d-flex align-items-center gap-2 mb-2">
                            @if(!is_null($filmOfTheDay->vote_average))
                                <span class="rating-badge">⭐ {{ $filmOfTheDay->vote_average }}</span>
                            @endif

                            @if($filmOfTheDay->type_name)
                                <span class="chip">{{ $filmOfTheDay->type_name }}</span>
                            @endif

                            @if($filmOfTheDay->genres)
                                @php
                                    $firstGenre = trim(explode(',', $filmOfTheDay->genres)[0] ?? '');
                                @endphp
                                @if($firstGenre !== '')
                                    <span class="chip">{{ $firstGenre }}</span>
                                @endif
                            @endif
                        </div>

                        @if($filmOfTheDay->overview)
                            <p class="text-muted mb-2" style="max-height: 80px; overflow: hidden;">
                                {{ \Illuminate\Support\Str::limit($filmOfTheDay->overview, 220, '...') }}
                            </p>
                        @endif

                        <small class="text-muted d-block mb-3">
                            @if($filmOfTheDay->original_release_date)
                                Rilis asli:
                                {{ \Carbon\Carbon::parse($filmOfTheDay->original_release_date)->format('Y-m-d') }}
                                @if(!is_null($filmOfTheDay->years_ago))
                                    ({{ $filmOfTheDay->years_ago }} tahun lalu)
                                @endif
                            @endif
                        </small>

                        <a href="/film/{{ $filmOfTheDay->show_id }}" class="btn btn-primary btn-sm">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @else
            <p class="text-muted">Belum ada film pilihan untuk hari ini.</p>
        @endif
    </div>

        <!-- TRENDING NOW SLIDER -->
       <div class="trending-section" id="trending">
    <h3 class="fw-bold mb-4">🔥 Trending Now</h3>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @forelse($trendingSlider as $item)
                <div class="swiper-slide"
                     onclick="window.location.href='/film/{{ $item->show_id }}'">
                    <div class="position-relative h-100" style="padding: 16px;">
                        <div class="bg-white rounded-4 h-100 d-flex flex-column justify-content-between p-3">
                            <div>
                                <h5 class="mb-1">{{ $item->name }}</h5>
                                <small class="text-muted d-block mb-2">
                                    {{ $item->type_name ?? '-' }}
                                    @if($item->number_of_seasons)
                                        • {{ $item->number_of_seasons }} season
                                    @endif
                                </small>
                                @if($item->genres)
                                    <div class="mb-2">
                                        @foreach(explode(',', $item->genres) as $g)
                                            @php $g = trim($g); @endphp
                                            @if($g !== '')
                                                <span class="chip">{{ $g }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                @if(!is_null($item->vote_average))
                                    <span class="rating-badge">⭐ {{ $item->vote_average }}</span>
                                @endif
                                <small class="text-muted">
                                    Popularity: {{ $item->popularity ?? 0 }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted px-2">Belum ada data trending.</p>
            @endforelse
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>


        <!-- TOP CHARTS -->
<div class="top-charts">
    <div class="row">
        <div class="col-md-6">
            <h4 class="fw-bold mb-4">🎯 Top 10 Film Hari Ini</h4>

            @forelse($topMovies as $index => $item)
                <div class="chart-item">
                    <div class="d-flex align-items-center">
                        <div class="rank-badge me-3">{{ $index + 1 }}</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">
                                <a href="/film/{{ $item->show_id }}" class="text-decoration-none text-dark">
                                    {{ $item->name }}
                                </a>
                            </div>
                            <small class="text-muted">
                                {{ $item->type_name ?? '-' }}
                                @if(!is_null($item->vote_average))
                                    • ⭐ {{ $item->vote_average }}
                                @endif
                                • Popularity {{ $item->popularity ?? 0 }}
                            </small>
                            @if($item->genres)
                                <div>
                                    <small class="text-muted">
                                        {{ $item->genres }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada data top film.</p>
            @endforelse
        </div>

        <div class="col-md-6">
            <h4 class="fw-bold mb-4">📺 Top 10 Serial Minggu Ini</h4>

            @forelse($topShows as $index => $item)
                <div class="chart-item">
                    <div class="d-flex align-items-center">
                        <div class="rank-badge me-3">{{ $index + 1 }}</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">
                                <a href="/film/{{ $item->show_id }}" class="text-decoration-none text-dark">
                                    {{ $item->name }}
                                </a>
                            </div>
                            <small class="text-muted">
                                {{ $item->type_name ?? '-' }}
                                @if(!is_null($item->vote_average))
                                    • ⭐ {{ $item->vote_average }}
                                @endif
                                • Popularity {{ $item->popularity ?? 0 }}
                            </small>
                            @if($item->genres)
                                <div>
                                    <small class="text-muted">
                                        {{ $item->genres }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada data top serial.</p>
            @endforelse
        </div>
    </div>
</div>


        <!-- FILTER & CONTENT GRID -->
        <div class="row mt-5" id="movies">
            <!-- FILTER SIDEBAR -->
            <div class="col-md-3">
                <div class="filter-sidebar">
                    <h5 class="fw-bold mb-4"><i class="fas fa-filter me-2"></i>Advanced Filters</h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Type</label>
                        <select id="typeFilter" class="form-select">
                            <option value="">All Content</option>
                            <option value="movie">Movies</option>
                            <option value="show">TV Shows</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Genres</label>
                        <div class="genre-checkboxes">
                            @php
                                $allGenres = ['Sci-Fi', 'Thriller', 'Drama', 'Mystery', 'Romance', 'Crime'];
                            @endphp
                            @foreach($allGenres as $genre)
                            <div class="form-check">
                                <input class="form-check-input genre-checkbox" type="checkbox" value="{{ strtolower($genre) }}" id="genre{{ $genre }}">
                                <label class="form-check-label" for="genre{{ $genre }}">{{ $genre }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Year Range</label>
                        <input type="range" class="form-range" id="yearRange" min="2000" max="2024" value="2024">
                        <div class="d-flex justify-content-between">
                            <small>2000</small>
                            <small id="yearValue">2024</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Min Rating</label>
                        <select id="ratingFilter" class="form-select">
                            <option value="0">Any Rating</option>
                            <option value="9">9+</option>
                            <option value="8">8+</option>
                            <option value="7">7+</option>
                            <option value="6">6+</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Country</label>
                        <select id="countryFilter" class="form-select">
                            <option value="">All Countries</option>
                            <option value="USA">USA</option>
                            <option value="Germany">Germany</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Language</label>
                        <select id="languageFilter" class="form-select">
                            <option value="">All Languages</option>
                            <option value="English">English</option>
                            <option value="German">German</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Duration (max minutes)</label>
                        <input type="range" class="form-range" id="durationRange" min="0" max="200" value="200">
                        <div class="d-flex justify-content-between">
                            <small>0</small>
                            <small id="durationValue">200+</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="adultContentToggle" checked>
                            <label class="form-check-label" for="adultContentToggle">Show Adult Content</label>
                        </div>
                    </div>

                    <button id="clearFilters" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-times me-1"></i>Clear All Filters
                    </button>
                </div>
            </div>

            <!-- CONTENT GRID -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="section-title mb-0">🎞️ Explore All Content</h3>
                    <div>
                        <label class="form-label me-2">Sort By:</label>
                        <select id="sortSelect" class="form-select" style="width: auto; display: inline-block;">
                            <option value="popularity">Popularity</option>
                            <option value="rating">Highest Rating</option>
                            <option value="year">Newest First</option>
                            <option value="title">Title A-Z</option>
                        </select>
                    </div>
                </div>
                <div class="row g-4" id="resultsGrid"></div>
            </div>
        </div>
    </div>

    <!-- QUICK PREVIEW OVERLAY -->
    <div class="quick-preview-overlay" id="quickPreview">
        <div class="quick-preview-card">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 id="previewTitle" class="mb-0"></h5>
                    <button class="btn-close" onclick="closeQuickPreview()"></button>
                </div>
                <div class="row">
                    <div class="col-4">
                    </div>
                    <div class="col-8">
                        <div id="previewMeta" class="small text-muted mb-2"></div>
                        <div id="previewGenres" class="mb-2"></div>
                        <p id="previewSummary" class="small"></p>
                        <div class="rating-badge d-inline-block" id="previewRating"></div>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary btn-sm w-100" onclick="viewFilmDetails()">
                        <i class="fas fa-eye me-1"></i>View Full Details
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- EXECUTIVE LOGIN MODAL -->
    <div class="modal fade" id="execLoginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-tie me-2"></i>Executive Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="/executive-login">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Email Executive</label>
                            <input type="email" class="form-control" name="email" placeholder="exec@studio.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="password123" required>
                        </div>
                        <div class="form-text">
                            Demo credentials: <b>exec@studio.com</b> / <b>password123</b>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Login as Executive</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- MARKETING LOGIN MODAL -->
<div class="modal fade" id="marketingLoginModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-bullhorn me-2"></i>Marketing Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="/marketing-login">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email Marketing</label>
                        <input type="email" class="form-control" name="email" placeholder="mkt@studio.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="marketing123" required>
                    </div>
                    <div class="form-text">
                        Demo credentials: <b>mkt@studio.com</b> / <b>marketing123</b>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Login as Marketing</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
        const FILMS_RAW = @json($films);

    // Normalisasi data DB -> format yang dipakai UI/filter
    const FILMS = (Array.isArray(FILMS_RAW) ? FILMS_RAW : []).map(x => {
        const genresArr = (x.genres ?? '')
            .toString()
            .split(',')
            .map(g => g.trim())
            .filter(Boolean);

        const typeLower = (x.type_name ?? '').toString().toLowerCase();
        const mappedType =
            typeLower.includes('scripted') || typeLower.includes('show') || typeLower.includes('tv')
                ? 'show'
                : 'movie'; // default

        return {
            id: x.show_id ?? x.id,
            title: x.name ?? x.title ?? '-',
            summary: x.overview ?? x.summary ?? '',
            year: x.first_air_year ?? (x.first_air_date ? parseInt(String(x.first_air_date).slice(0,4)) : null) ?? 0,
            type: mappedType,
            rating: Number(x.vote_average ?? x.rating ?? 0),
            runtime: Number(x.runtime ?? x.episode_run_time ?? x.eposide_run_time ?? 0),
            popularity: Number(x.popularity ?? 0),
            genres: genresArr,
            country: x.origin_country ?? x.country ?? '',
            language: x.original_language ?? x.language ?? '',
            is_adult: (String(x.adult ?? x.is_adult ?? 'false') === 'true'),

            // biar detail page tetep pakai show_id
            show_id: x.show_id ?? x.id,
            type_name: x.type_name ?? null,
            raw: x
        };
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
/* =========================
   DOM ELEMENTS
========================= */
const searchInput = document.getElementById('searchInput');
const searchSuggestions = document.getElementById('searchSuggestions');
const suggestionsList = document.getElementById('suggestionsList');

const typeFilter = document.getElementById('typeFilter');
const ratingFilter = document.getElementById('ratingFilter');
const sortSelect = document.getElementById('sortSelect');
const countryFilter = document.getElementById('countryFilter');
const languageFilter = document.getElementById('languageFilter');
const yearRange = document.getElementById('yearRange');
const yearValue = document.getElementById('yearValue');
const durationRange = document.getElementById('durationRange');
const durationValue = document.getElementById('durationValue');
const adultContentToggle = document.getElementById('adultContentToggle');
const clearFilters = document.getElementById('clearFilters');
const resultsGrid = document.getElementById('resultsGrid');

const quickPreview = document.getElementById('quickPreview');
let currentPreviewFilm = null;
let previewAbort = null;
let swiper = null;

/* =========================
   SEARCH SUGGESTIONS (API)
========================= */
function setupSearchSuggestions() {
  if (!searchInput) return;

  let typingTimer = null;

  searchInput.addEventListener('input', (e) => {
    const query = (e.target.value || '').trim();

    if (query.length < 2) {
      if (searchSuggestions) searchSuggestions.style.display = 'none';
      if (suggestionsList) suggestionsList.innerHTML = '';
      return;
    }

    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
      fetch(`/api/search-suggestions?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => displaySuggestions(data, query))
        .catch(() => {
          if (searchSuggestions) searchSuggestions.style.display = 'none';
        });
    }, 250);
  });

  document.addEventListener('click', (e) => {
    if (!searchInput.contains(e.target) && searchSuggestions && !searchSuggestions.contains(e.target)) {
      searchSuggestions.style.display = 'none';
    }
  });
}

function highlightText(text, query) {
  if (!query) return text;
  const regex = new RegExp(`(${query})`, 'gi');
  return String(text).replace(regex, '<mark>$1</mark>');
}

function displaySuggestions(suggestions, query) {
  if (!Array.isArray(suggestions) || suggestions.length === 0) {
    if (searchSuggestions) searchSuggestions.style.display = 'none';
    if (suggestionsList) suggestionsList.innerHTML = '';
    return;
  }

  suggestionsList.innerHTML = suggestions.map(item => `
    <div class="suggestion-item" onclick="goToSuggestion('${item.result_type}', '${item.id}')">
      <div class="fw-semibold">${highlightText(item.title, query)}</div>
      <small class="text-muted">
        ${item.result_type === 'person' ? 'Person' : 'Show'}
        ${item.genres ? ' • ' + item.genres : ''}
      </small>
    </div>
  `).join('');

  searchSuggestions.style.display = 'block';
}

function goToSuggestion(type, id) {
  if (type === 'show') {
    window.location.href = `/film/${id}`;
  } else {
    alert('Halaman detail person belum dibuat 🙂');
  }
  if (searchSuggestions) searchSuggestions.style.display = 'none';
  if (searchInput) searchInput.value = '';
}
window.goToSuggestion = goToSuggestion;

/* =========================
   FILTER + SORT
========================= */
function filterAndSortFilms() {
  const query = (searchInput?.value || '').trim().toLowerCase();
  const typeVal = typeFilter?.value || '';
  const minRating = parseFloat(ratingFilter?.value || '0');
  const sortVal = sortSelect?.value || 'popularity';
  const countryVal = countryFilter?.value || '';
  const languageVal = languageFilter?.value || '';
  const maxYear = parseInt(yearRange?.value || '2024', 10);
  const maxDuration = parseInt(durationRange?.value || '200', 10);
  const showAdult = adultContentToggle?.checked ?? true;

  const selectedGenres = Array.from(document.querySelectorAll('.genre-checkbox:checked'))
    .map(cb => (cb.value || '').toLowerCase());

  let list = Array.isArray(FILMS) ? [...FILMS] : [];

  // SEARCH (title/summary/genres/type/country/language)
  if (query) {
    const tokens = query.split(/\s+/);
    list = list.filter(f => {
      const haystack = (
        (f.title ?? '') + ' ' +
        (f.summary ?? '') + ' ' +
        ((Array.isArray(f.genres) ? f.genres.join(' ') : '') ?? '') + ' ' +
        (f.type_name ?? f.type ?? '') + ' ' +
        (f.country ?? '') + ' ' +
        (f.language ?? '')
      ).toLowerCase();

      return tokens.every(t => haystack.includes(t));
    });
  }

  // FILTERS
  if (typeVal) list = list.filter(f => f.type === typeVal);
  if (minRating > 0) list = list.filter(f => (f.rating || 0) >= minRating);
  if (countryVal) list = list.filter(f => (f.country || '') === countryVal);
  if (languageVal) list = list.filter(f => (f.language || '') === languageVal);
  if (maxYear < 2024) list = list.filter(f => (f.year || 0) <= maxYear);
  if (maxDuration < 200) list = list.filter(f => (f.runtime || 0) <= maxDuration);
  if (!showAdult) list = list.filter(f => !f.is_adult);

  if (selectedGenres.length > 0) {
    list = list.filter(f => {
      const gs = (f.genres || []).map(x => String(x).toLowerCase());
      return selectedGenres.some(sel => gs.some(g => g.includes(sel)));
    });
  }

  // SORT
  list.sort((a, b) => {
    switch (sortVal) {
      case 'rating': return (b.rating || 0) - (a.rating || 0);
      case 'year': return (b.year || 0) - (a.year || 0);
      case 'title': return (a.title || '').localeCompare(b.title || '');
      default: return (b.popularity || 0) - (a.popularity || 0);
    }
  });

  return list;
}

/* =========================
   RENDER GRID (NO IMAGE)
========================= */
function createFilmCard(f) {
  const genresHtml = (f.genres || []).slice(0, 2).map(g => `<span class="chip">${g}</span>`).join('');
  const meta = `${f.year || '-'} • ${f.type === 'movie' ? 'Film' : 'TV Show'}${f.runtime ? ' • ' + f.runtime + ' min' : ''}`;

  return `
    <div class="col-xl-4 col-lg-6 col-md-6">
      <div class="film-card p-3" onclick="openQuickPreview(${f.show_id})" style="min-height: 190px;">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <h6 class="mb-0 flex-grow-1 me-2">${f.title}</h6>
          <span class="rating-badge">⭐ ${f.rating ? f.rating.toFixed(1) : '-'}</span>
        </div>
        <div class="mb-2">
          <small class="text-muted">${meta}</small>
        </div>
        <div class="mb-2">${genresHtml}</div>
        <p class="small text-muted mb-0" style="max-height: 48px; overflow:hidden;">
          ${(f.summary || '').slice(0, 120)}${(f.summary || '').length > 120 ? '...' : ''}
        </p>
      </div>
    </div>
  `;
}

function renderResults() {
  if (!resultsGrid) return;
  const list = filterAndSortFilms();
  resultsGrid.innerHTML = list.length
    ? list.map(createFilmCard).join('')
    : `<div class="col-12 text-center py-5"><p class="text-muted">No results found. Try adjusting your filters.</p></div>`;
}

/* =========================
   QUICK PREVIEW (CLICK ONLY)
========================= */
async function openQuickPreview(showId) {
  if (!quickPreview) return;

  try {
    if (previewAbort) previewAbort.abort();
    previewAbort = new AbortController();

    const res = await fetch(`/api/quick-preview/${showId}`, { signal: previewAbort.signal });
    if (!res.ok) return;

    const item = await res.json();
    currentPreviewFilm = item;

    document.getElementById('previewTitle').textContent = item.name || item.original_name || '-';

    const year = item.first_air_year ?? '-';
    const type = item.type_name ?? '-';
    const runtime = item.runtime ? `${item.runtime} min` : '';
    document.getElementById('previewMeta').textContent = `${year} • ${type}${runtime ? ' • ' + runtime : ''}`;

    const genresWrap = document.getElementById('previewGenres');
    genresWrap.innerHTML = item.genres
      ? item.genres.split(',').map(g => g.trim()).filter(Boolean).slice(0, 4).map(g => `<span class="chip">${g}</span>`).join('')
      : '';

    const overview = item.overview || '';
    document.getElementById('previewSummary').textContent = overview.length > 150 ? overview.slice(0, 150) + '...' : overview;

    const rating = (item.vote_average !== null && item.vote_average !== undefined) ? item.vote_average : '-';
    document.getElementById('previewRating').textContent = `⭐ ${rating}`;

    quickPreview.style.display = 'flex';
  } catch (e) {
    // ignore abort
  }
}

function closeQuickPreview() {
  if (!quickPreview) return;
  quickPreview.style.display = 'none';
}

function viewFilmDetails() {
  if (!currentPreviewFilm) return;
  window.location.href = `/film/${currentPreviewFilm.show_id}`;
}

if (quickPreview) {
  quickPreview.addEventListener('click', (e) => {
    if (e.target === quickPreview) closeQuickPreview();
  });
}

window.openQuickPreview = openQuickPreview;
window.closeQuickPreview = closeQuickPreview;
window.viewFilmDetails = viewFilmDetails;

/* =========================
   LISTENERS
========================= */
function hookFilters() {
  [typeFilter, ratingFilter, sortSelect, countryFilter, languageFilter, adultContentToggle].forEach(el => {
    if (!el) return;
    el.addEventListener('change', renderResults);
    el.addEventListener('input', renderResults);
  });

  if (searchInput) searchInput.addEventListener('change', renderResults);

  if (yearRange) {
    yearRange.addEventListener('input', function () {
      if (yearValue) yearValue.textContent = this.value;
      renderResults();
    });
  }

  if (durationRange) {
    durationRange.addEventListener('input', function () {
      if (durationValue) durationValue.textContent = (this.value === '200') ? '200+' : `${this.value} min`;
      renderResults();
    });
  }

  document.querySelectorAll('.genre-checkbox').forEach(cb => cb.addEventListener('change', renderResults));

  if (clearFilters) {
    clearFilters.addEventListener('click', () => {
      if (typeFilter) typeFilter.value = '';
      if (ratingFilter) ratingFilter.value = '0';
      if (sortSelect) sortSelect.value = 'popularity';
      if (countryFilter) countryFilter.value = '';
      if (languageFilter) languageFilter.value = '';
      if (yearRange) { yearRange.value = '2024'; if (yearValue) yearValue.textContent = '2024'; }
      if (durationRange) { durationRange.value = '200'; if (durationValue) durationValue.textContent = '200+'; }
      if (adultContentToggle) adultContentToggle.checked = true;
      if (searchInput) searchInput.value = '';
      document.querySelectorAll('.genre-checkbox').forEach(cb => cb.checked = false);
      renderResults();
    });
  }
}

/* =========================
   INIT
========================= */
function init() {
  setupSearchSuggestions();
  hookFilters();
  renderResults();

  // Trending slider dari Blade sudah ada, tinggal init Swiper
  swiper = new Swiper('.mySwiper', {
    slidesPerView: 1,
    spaceBetween: 10,
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    breakpoints: {
      640: { slidesPerView: 2, spaceBetween: 20 },
      768: { slidesPerView: 3, spaceBetween: 30 },
      1024: { slidesPerView: 4, spaceBetween: 30 },
    },
  });
}

document.addEventListener('DOMContentLoaded', init);
</script>

</body>
</html>