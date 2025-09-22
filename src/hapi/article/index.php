<?php
declare(strict_types=1);

use Cr8\JoomlaHeadlessApi\HeadlessApi\ArticleAPI;

require_once __DIR__ . '/../../HeadlessApi/ArticleAPI.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$api = new ArticleAPI();

if (isset($_GET['category'])) {
    $payload = $api->getArticlesByCategory($_GET['category']);
} elseif (isset($_GET['id'])) {
    $payload = $api->getArticlesById($_GET['id']);
} elseif (isset($_GET['slug'])) {
    $payload = $api->getArticlesBySlug($_GET['slug']);
} else {
    http_response_code(400);
    echo json_encode([
        'error' => 'Missing query parameter.',
        'details' => 'Provide category, id or slug.'
    ]);
    exit;
}

$json = json_encode($payload);

if ($json === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to encode response as JSON.', 'details' => json_last_error_msg()]);
    exit;
}

echo $json;
