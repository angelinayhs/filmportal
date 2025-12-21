<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketingController extends Controller
{
    /**
     * Ambil max N rows tanpa load semua ke memory (stream).
     */
    private function cursorTake(string $sql, array $bindings, int $limit): array
    {
        $rows = [];
        $i = 0;

        foreach (DB::cursor($sql, $bindings) as $row) {
            $rows[] = $row;
            $i++;
            if ($i >= $limit) break;
        }

        return $rows;
    }

    public function index(Request $request)
    {
        // section 1..6
        $section = (int) $request->query('section', 1);
        if ($section < 1 || $section > 6) $section = 1;

        // default biar blade aman
        $genreSegments = $ratingSegments = $durationSegments = [];
        $campaignPerformance = [];
        $trendForecasting = [];
        $crossStudioPromotion = [];
        $engagementTracker = [];
        $audienceBehavior = [];

        // =========================
        // SECTION 1
        // =========================
        if ($section === 1) {
            $genreSegments = $this->cursorTake(
                "EXEC dbo.sp_get_audience_segmentation ?, ?, ?",
                ['genre', null, null],
                20
            );

            $ratingSegments = $this->cursorTake(
                "EXEC dbo.sp_get_audience_segmentation ?, ?, ?",
                ['audience_rating', null, null],
                20
            );

            $durationSegments = $this->cursorTake(
                "EXEC dbo.sp_get_audience_segmentation ?, ?, ?",
                ['duration', null, null],
                20
            );
        }

        // =========================
        // SECTION 2
        // =========================
        if ($section === 2) {
            $periodBucket = $request->query('period_bucket');
            $periodBucket = ($periodBucket === '' || $periodBucket === null) ? null : $periodBucket;

            $minScore = $request->query('min_score');
            $minScore = ($minScore === '' || $minScore === null) ? null : (float) $minScore;

            $typeName = $request->query('type_name');
            $typeName = ($typeName === '' || $typeName === null) ? null : $typeName;

            $limit = (int) $request->query('limit', 50);
            if ($limit <= 0) $limit = 50;
            if ($limit > 100) $limit = 100;

            // SP ini sudah punya limit param -> aman
            $campaignPerformance = DB::select(
                "EXEC dbo.sp_get_campaign_performance ?, ?, ?, ?",
                [$periodBucket, $minScore, $typeName, $limit]
            );
        }

        // =========================
        // SECTION 3
        // =========================
        if ($section === 3) {
            $yearFrom = $request->query('year_from');
            $yearFrom = ($yearFrom === '' || $yearFrom === null) ? null : (int) $yearFrom;

            $yearTo = $request->query('year_to');
            $yearTo = ($yearTo === '' || $yearTo === null) ? null : (int) $yearTo;

            $genreTf = $request->query('genre');
            $genreTf = ($genreTf === '' || $genreTf === null) ? null : $genreTf;

            $trendForecasting = $this->cursorTake(
                "EXEC dbo.sp_get_trend_forecasting ?, ?, ?",
                [$yearFrom, $yearTo, $genreTf],
                60
            );
        }

        // =========================
        // SECTION 4
        // =========================
        if ($section === 4) {
            $studioName = $request->query('studio_name');
            $studioName = ($studioName === '' || $studioName === null) ? null : $studioName;

            $genreCs = $request->query('genre_cs');
            $genreCs = ($genreCs === '' || $genreCs === null) ? null : $genreCs;

            $minTitles = $request->query('min_titles');
            $minTitles = ($minTitles === '' || $minTitles === null) ? null : (int) $minTitles;

            $crossStudioPromotion = $this->cursorTake(
                "EXEC dbo.sp_get_cross_studio_promotion ?, ?, ?",
                [$studioName, $genreCs, $minTitles],
                50
            );
        }

        // =========================
        // SECTION 5
        // =========================
        if ($section === 5) {
            $engLevel = $request->query('engagement_level');
            $engLevel = ($engLevel === '' || $engLevel === null) ? null : $engLevel;

            $minPopularity = $request->query('min_popularity');
            $minPopularity = ($minPopularity === '' || $minPopularity === null) ? null : (float) $minPopularity;

            $typeNameEt = $request->query('type_name_et');
            $typeNameEt = ($typeNameEt === '' || $typeNameEt === null) ? null : $typeNameEt;

            $engagementTracker = $this->cursorTake(
                "EXEC dbo.sp_get_engagement_tracker ?, ?, ?",
                [$engLevel, $minPopularity, $typeNameEt],
                50
            );
        }

        // =========================
        // SECTION 6
        // =========================
        if ($section === 6) {
            $audienceFlag = $request->query('audience_flag');
            $audienceFlag = ($audienceFlag === '' || $audienceFlag === null) ? null : $audienceFlag;

            $contentLifecycle = $request->query('content_lifecycle');
            $contentLifecycle = ($contentLifecycle === '' || $contentLifecycle === null) ? null : $contentLifecycle;

            $minVotes = $request->query('min_votes');
            $minVotes = ($minVotes === '' || $minVotes === null) ? null : (int) $minVotes;

            $limitAb = (int) $request->query('limit_ab', 50);
            if ($limitAb <= 0) $limitAb = 50;
            if ($limitAb > 100) $limitAb = 100;

            $audienceBehavior = $this->cursorTake(
                "EXEC dbo.sp_get_audience_behavior ?, ?, ?",
                [$audienceFlag, $contentLifecycle, $minVotes],
                $limitAb
            );
        }

        return view('marketing', compact(
            'section',
            'genreSegments', 'ratingSegments', 'durationSegments',
            'campaignPerformance', 'trendForecasting', 'crossStudioPromotion',
            'engagementTracker', 'audienceBehavior'
        ));
    }
}
