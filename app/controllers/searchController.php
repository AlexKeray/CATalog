<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';

class SearchController extends BaseController
{
    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function searchExecute()
    {
        $query = $_GET['query'] ?? '';
        $results = [];

        if ($query !== '') {
            $token = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI3ZjNlMGQ3N2QyZTk4OTM4NjE2NmIxNDU3ODljYjhlOCIsIm5iZiI6MS43NDcwODMxMDIyNjU5OTk4ZSs5LCJzdWIiOiI2ODIyNWY1ZTcxZTMwMjNmZjFhMTY2MTUiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.c-ulm2_OoZACessEr_7LIYlDFVDATkIj8zVIQCw_F_Y';
            $searchUrl = 'https://api.themoviedb.org/3/search/multi?query=' . urlencode($query) . '&page=1';
            $results = $this->searchTmdb($searchUrl, $token);
        }

        $this->smarty->assign('search_results', $results);
        $this->smarty->assign('search_query', $query);
        $this->smarty->display('search_results.tpl');
    }

    public function searchAjaxExecute()
    {
        $query = $_GET['query'] ?? '';
        $results = [];

        if ($query !== '') {
            $token = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI3ZjNlMGQ3N2QyZTk4OTM4NjE2NmIxNDU3ODljYjhlOCIsIm5iZiI6MS43NDcwODMxMDIyNjU5OTk4ZSs5LCJzdWIiOiI2ODIyNWY1ZTcxZTMwMjNmZjFhMTY2MTUiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.c-ulm2_OoZACessEr_7LIYlDFVDATkIj8zVIQCw_F_Y';
            $searchUrl = 'https://api.themoviedb.org/3/search/multi?query=' . urlencode($query) . '&page=1';
            $results = $this->searchTmdb($searchUrl, $token);
        }

        header('Content-Type: text/html; charset=utf-8');

        //echo json_encode($results, JSON_UNESCAPED_UNICODE);
        //exit;

        foreach ($results as $r) {
            ob_start(); // буферираме съдържанието

            echo '<div style="display: flex; gap: 15px; align-items: flex-start; margin-bottom: 30px;">';

            // Снимка
            if (!empty($r['poster'])) {
                echo '<img src="' . htmlspecialchars($r['poster']) . '" alt="Постер" style="width: 200px; height: auto;">';
            } else {
                echo '<img src="' . BASE_URL . '/misc/question.jpg" alt="Без снимка" style="width: 200px; height: auto;">';
            }

            echo '<div>';
            echo '<strong>' . htmlspecialchars($r['title']) . '</strong><br>';
            echo 'Тип: ' . htmlspecialchars($r['type']) . '<br>';
            echo 'Жанр: ' . htmlspecialchars($r['genre']) . '<br>';
            echo 'Година: ' . htmlspecialchars($r['year'] ?? '—') . '<br>';

            if (($r['type'] ?? '') === 'сериал') {
                echo 'Брой епизоди: ' . htmlspecialchars($r['episodes'] ?? '—') . '<br>';
            }

            echo 'Продължителност: ' . htmlspecialchars($r['duration'] ?? '—') . ' минути<br>';
            echo '</div>'; // вътрешен div
            echo '</div>'; // външен div

            $content = ob_get_clean(); // взимаме буферираното съдържание

            // Първо бутон, после съдържанието
            echo '<button class="fill-form-btn" 
                data-title="' . htmlspecialchars($r['title']) . '" 
                data-type="' . htmlspecialchars($r['type']) . '" 
                data-genre="' . htmlspecialchars($r['genre']) . '"
                data-year="' . htmlspecialchars($r['year']) . '" 
                data-episodes="' . htmlspecialchars($r['episodes']) . '" 
                data-duration="' . htmlspecialchars($r['duration']) . '" 
                data-poster="' . htmlspecialchars($r['poster']) . '"
            >Попълни</button>';

            echo $content;
        }
    }

    private function searchTmdb(string $url, string $token): array
    {
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => "Authorization: Bearer $token\r\n"
            ]
        ];
        $ctx = stream_context_create($opts);
        $res = file_get_contents($url, false, $ctx);
        $data = $res ? json_decode($res, true) : null;

        $results = array_slice($data['results'] ?? [], 0, 100);
        $output = [];

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
                'title' => $detailData['title'] ?? $detailData['name'] ?? '',
                'type' => $type === 'movie' ? 'филм' : 'сериал',
                'genre' => $detailData['genres'][0]['name'] ?? 'неизвестен',
                'year' => isset($detailData['release_date'])
                    ? substr($detailData['release_date'], 0, 4)
                    : (isset($detailData['first_air_date']) ? substr($detailData['first_air_date'], 0, 4) : '—'),
                'duration' => $detailData['runtime'] ?? ($detailData['episode_run_time'][0] ?? '—'),
                'episodes' => $episodeCount > 0 ? $episodeCount : '—',
                'poster' => isset($detailData['poster_path']) ? 'https://image.tmdb.org/t/p/w500' . $detailData['poster_path'] : ''
            ];

        }

        return $output;
    }
}
