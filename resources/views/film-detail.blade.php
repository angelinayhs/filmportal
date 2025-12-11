<!DOCTYPE html>
<html>
<head>
    <title>{{ $film->name }} - CineSense</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .navbar-custom {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(14px);
        }
        .film-detail-header {
            background: rgba(255,255,255,0.95);
            border-radius: 14px;
            padding: 30px;
            margin-top: 20px;
        }
        .cross-media-recommendation {
            background: rgba(255,255,255,0.92);
            border-radius: 14px;
            padding: 20px;
            margin-top: 30px;
        }
        .recommendation-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: transform 0.2s;
        }
        .recommendation-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid px-3">
            <a class="navbar-brand" href="/">🎬 CineSense</a>
        </div>
    </nav>

    <div class="container mb-5">
        <!-- FILM DETAIL SECTION -->
<!-- FILM DETAIL SECTION -->
<div class="film-detail-header">
    <div class="row">
        <div class="col-md-12">

            <h1>{{ $film->name }}</h1>

            @if($film->original_name && $film->original_name !== $film->name)
                <small class="text-muted">({{ $film->original_name }})</small>
            @endif

            <div class="mb-3 mt-2">
                @if(!is_null($film->vote_average))
                    <span class="badge bg-warning text-dark me-2">⭐ {{ $film->vote_average }}</span>
                @endif

                @if($film->show_type)
                    <span class="badge bg-secondary me-2">{{ $film->show_type }}</span>
                @endif

                @if($film->runtime_minutes)
                    <span class="badge bg-light text-dark">{{ $film->runtime_minutes }} min</span>
                @endif

                @if($film->status)
                    <span class="badge bg-info text-dark">{{ $film->status }}</span>
                @endif
            </div>

            @if($film->tagline)
                <p class="fst-italic text-muted">"{{ $film->tagline }}"</p>
            @endif

            <p class="lead">{{ $film->overview }}</p>

            <div class="mb-2">
                <strong>Genres:</strong>
                @if($film->genres)
                    @foreach(explode(',', $film->genres) as $genre)
                        @php $genre = trim($genre); @endphp
                        @if($genre !== '')
                            <span class="badge bg-primary me-1">{{ $genre }}</span>
                        @endif
                    @endforeach
                @else
                    <span class="text-muted">-</span>
                @endif
            </div>

            <div class="mb-2"><strong>Languages:</strong> {{ $film->languages ?? '-' }}</div>
            <div class="mb-2"><strong>Spoken Languages:</strong> {{ $film->spoken_languages ?? '-' }}</div>
            <div class="mb-2"><strong>Networks:</strong> {{ $film->networks ?? '-' }}</div>
            <div class="mb-2"><strong>Production Countries:</strong> {{ $film->production_countries ?? '-' }}</div>
            <div class="mb-2"><strong>Origin Countries:</strong> {{ $film->origin_countries ?? '-' }}</div>
            <div class="mb-2"><strong>Production Companies:</strong> {{ $film->production_companies ?? '-' }}</div>
            <div class="mb-2"><strong>First Air Date:</strong> {{ $film->first_air_date ?? '-' }}</div>
            <div class="mb-3"><strong>Last Air Date:</strong> {{ $film->last_air_date ?? '-' }}</div>

            <button class="btn btn-warning" onclick="addToWatchlist({{ $film->show_id }})">
                ⭐ Tambah ke Watchlist
            </button>

        </div>
    </div>
</div>


         <!-- RECOMMENDATIONS (sementara simple saja) -->
        <div class="cross-media-recommendation">
            <h3>🎬 Rekomendasi Konten Lain</h3>
            @if($recommendations->isEmpty())
                <p class="text-muted">Belum ada rekomendasi yang tersedia untuk konten ini.</p>
            @else
                <div class="row g-3 mt-3">
                    @foreach($recommendations as $rec)
                        <div class="col-md-3">
                            <div class="recommendation-card"
                                 onclick="window.location.href='/film/{{ $rec->show_id }}'">
                                
                                {{-- TANPA GAMBAR --}}
                                <h6 class="mt-1 fw-bold">{{ $rec->name }}</h6>

                                <small class="text-muted d-block mb-1">
                                    {{ $rec->show_type ?? '' }}
                                </small>

                                @if(!is_null($rec->vote_average))
                                    <div class="mt-1">
                                        <span class="badge bg-warning text-dark">⭐ {{ $rec->vote_average }}</span>
                                    </div>
                                @endif

                                @if($rec->genres)
                                    <div class="mt-1">
                                        <small class="text-muted">
                                            {{ $rec->genres }}
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        function addToWatchlist(showId) {
            let watchlist = JSON.parse(localStorage.getItem('watchlist') || '[]');
            if (!watchlist.includes(showId)) {
                watchlist.push(showId);
                localStorage.setItem('watchlist', JSON.stringify(watchlist));
                alert('Ditambahkan ke watchlist!');
            } else {
                alert('Sudah ada di watchlist!');
            }
        }
    </script>
</body>
</html>
