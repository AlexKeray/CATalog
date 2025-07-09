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
            $start = microtime(true); // да знам колко се бави апито
            $results = $this->searchTmdb($searchUrl, $token);
            $duration = microtime(true) - $start;
        }

        // логвам времето във файл в сървъра
        $log = "Време за заявка: " . number_format($duration, 3) . " сек.\n";
        file_put_contents('tmdb_timing.log', $log, FILE_APPEND);

        $media = $results;
        header('Content-Type: text/html; charset=utf-8'); // казва че отговорът е html с UTF-8

        $this->smarty->assign('media', $media);
        $this->smarty->assign('editMode', false);
        $this->smarty->assign('copyMode', true); // позволява взимане на данни от търсене и слагането им във формата за добавяне на филми

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
        $ctx = stream_context_create($opts); // ctx = context
        $res = file_get_contents($firstUrl, false, $ctx); // res = result
        $data = $res ? json_decode($res, true) : null; // true за да върне асоциативен масив

        // ако няма резултати спира
        if (!$data || !isset($data['results'])) {
            return [];
        }

        // гледаме колко страници има
        $totalPages = min($data['total_pages'] ?? 1, 3); // максимум 3 че иначе ще умрем от чакане

        // обхождаме и другите страници
        for ($page = 1; $page <= $totalPages; $page++) {
            $url = $baseUrl . '&page=' . $page;
            $res = file_get_contents($url, false, $ctx);
            $data = $res ? json_decode($res, true) : null;
            $results = $data['results'] ?? [];

            // обхождаме всеки резултат от всяка страница и правим още заявки на резултат за да разберем 
            foreach ($results as $item) {
                // проверка дали типът е правилен
                if (!in_array($item['media_type'], ['movie', 'tv'])) 
                {continue;}

                $id = $item['id'];
                $type = $item['media_type'];
                $detailUrl = "https://api.themoviedb.org/3/$type/$id"; // 3 е версията на апито
                $detail = file_get_contents($detailUrl, false, stream_context_create([  // stream_context_create указва как да се изпълни заявката и слага апи ключа вътре
                    'http' => ['method' => 'GET', 'header' => "Authorization: Bearer $token\r\n"]
                ]));
                $detailData = $detail ? json_decode($detail, true) : [];

                // изчисляваме епизодите
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
