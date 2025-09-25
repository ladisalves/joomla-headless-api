<?php
namespace Cr8\JoomlaHeadlessApi\HeadlessApi;

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../configuration.php';
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="description", type="string")
 * )
 */

/**
 * @OA\Info(title="Joomla Headless API", version="1.0.0")
 */
class CategoryAPI {
    private $db;
    private $config;

    public function __construct() {
        $this->db = new Database();
        $this->config = new JConfig();
    }

    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="Get all categories",
     *     @OA\Response(
     *         response=200,
     *         description="List of categories",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     )
     * )
     */
    public function getCategories() {
        $result = $this->db->query("SELECT * FROM " . $this->config->dbprefix . "categories");
        $categories = [];

        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }

        return $categories;
    }
}

