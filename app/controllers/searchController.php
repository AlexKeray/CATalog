<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';

class SearchController extends BaseController
{
    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function searchAjaxExecute()
    {
        $query = $_GET['query'] ?? '';
        $media = [];

        $duration = 0;
        $results = [];

        $duration;
        if ($query !== '') {
            $token = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI3ZjNlMGQ3N2QyZTk4OTM4NjE2NmIxNDU3ODljYjhlOCIsIm5iZiI6MS43NDcwODMxMDIyNjU5OTk4ZSs5LCJzdWIiOiI2ODIyNWY1ZTcxZTMwMjNmZjFhMTY2MTUiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.c-ulm2_OoZACessEr_7LIYlDFVDATkIj8zVIQCw_F_Y';
            $searchUrl = 'https://api.themoviedb.org/3/search/multi?query=' . urlencode($query);
            $start = microtime(true);
            $results = $this->searchTmdb($searchUrl, $token);
            $duration = microtime(true) - $start;
        }

        $log = "Време за заявка: " . number_format($duration, 3) . " сек.\n";
        file_put_contents('tmdb_timing.log', $log, FILE_APPEND);

        $media = $results;
        header('Content-Type: text/html; charset=utf-8');

        $this->smarty->assign('media', $media);
        $this->smarty->assign('editMode', false);
        $this->smarty->assign('copyMode', true);

        $this->smarty->display('tmdbResults.tpl');
    }

    private function searchTmdb(string $baseUrl, string $token): array
    {
        $output = [];

        // Първата заявка (page=1)
        $firstUrl = $baseUrl . '&page=1';
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => "Authorization: Bearer $token\r\n"
            ]
        ];
        $ctx = stream_context_create($opts);
        $res = file_get_contents($firstUrl, false, $ctx);
        $data = $res ? json_decode($res, true) : null;

        if (!$data || !isset($data['results'])) {
            return [];
        }

        $totalPages = min($data['total_pages'] ?? 1, 3); // ограничаваме до 10 за безопасност

        for ($page = 1; $page <= $totalPages; $page++) {
            $url = $baseUrl . '&page=' . $page;
            $res = file_get_contents($url, false, $ctx);
            $data = $res ? json_decode($res, true) : null;
            $results = $data['results'] ?? [];

            foreach ($results as $item) {
                if (!in_array($item['media_type'], ['movie', 'tv'])) continue;

                $id = $item['id'];
                $type = $item['media_type'];
                $detailUrl = "https://api.themoviedb.org/3/$type/$id";
                $detail = file_get_contents($detailUrl, false, stream_context_create([
                    'http' => ['method' => 'GET', 'header' => "Authorization: Bearer $token\r\n"]
                ]));
                $detailData = $detail ? json_decode($detail, true) : [];

                $episodeCount = 0;
                if (isset($detailData['seasons']) && is_array($detailData['seasons'])) {
                    foreach ($detailData['seasons'] as $season) {
                        if (($season['season_number'] ?? 0) > 0) {
                            $episodeCount += $season['episode_count'] ?? 0;
                        }
                    }
                }

                $output[] = [
                    'id' => null,
                    'name' => $detailData['title'] ?? $detailData['name'] ?? '',
                    'type_name' => $type === 'movie' ? 'Филм' : 'Сериал',
                    'genre_name' => $detailData['genres'][0]['name'] ?? '',
                    'year' => isset($detailData['release_date'])
                        ? substr($detailData['release_date'], 0, 4)
                        : (isset($detailData['first_air_date']) ? substr($detailData['first_air_date'], 0, 4) : ''),
                    'duration' => $detailData['runtime'] ?? ($detailData['episode_run_time'][0] ?? ''),
                    'episodes_count' => $episodeCount > 0 ? $episodeCount : '',
                    'image_path' => isset($detailData['poster_path']) ? 'https://image.tmdb.org/t/p/w500' . $detailData['poster_path'] : '',
                ];
            }
        }

        return $output;
    }

}
