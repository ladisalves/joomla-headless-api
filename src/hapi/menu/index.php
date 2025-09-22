<?php
declare(strict_types=1);

use Cr8\JoomlaHeadlessApi\HeadlessApi\MenuAPI;

require_once __DIR__ . '/../../HeadlessApi/MenuAPI.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

if (!isset($_GET['menutype'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing query parameter.', 'details' => 'Provide menutype.']);
    exit;
}

$api = new MenuAPI();
$payload = $api->getMenuItems($_GET['menutype']);

$json = json_encode($payload);

if ($json === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to encode response as JSON.', 'details' => json_last_error_msg()]);
    exit;
}

echo $json;
