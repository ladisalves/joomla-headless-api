<?php
require_once 'database.php';
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Joomla Headless API", version="1.0.0")
 */
class MenuAPI {
    private $db;
    private $config;

    public function __construct() {
        $this->db = new Database();
        $this->config = new JConfig();
    }

    /**
     * @OA\Get(
     *     path="/menus",
     *     summary="Get all menus",
     *     @OA\Response(
     *         response=200,
     *         description="List of menus",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Menu"))
     *     )
     * )
     */
    public function getMenuItems($menutype) {
        $menutype = $this->db->escape_string($menutype);
        $result = $this->db->query("SELECT * FROM " . $this->config->dbprefix . "menu WHERE menutype = '$menutype'");
        $menuItems = [];

        while ($row = $result->fetch_assoc()) {
            $menuItems[] = $row;
        }

        return $menuItems;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['menutype'])) {
    $api = new MenuAPI();
    echo json_encode($api->getMenuItems($_GET['menutype']));
}

/**
 * @OA\Schema(
 *     schema="Menu",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="link", type="string"),
 *     @OA\Property(property="parent_id", type="integer")
 * )
 */
