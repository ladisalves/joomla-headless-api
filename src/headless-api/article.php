<?php
require_once 'database.php';
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Joomla Headless API", version="1.0.0")
 */
class ArticleAPI {
    private $db;
    private $config;

    public function __construct() {
        $this->db = new Database();
        $this->config = new JConfig();
    }

    /**
     * @OA\Get(
     *     path="/articles",
     *     summary="Get articles by category",
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of articles",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Article"))
     *     )
     * )
     */
    public function getArticlesByCategory($category) {
        $category = $this->db->escape_string($category);
        $result = $this->db->query("SELECT * FROM " . $this->config->dbprefix . "content WHERE catid = '$category'");
        $articles = [];

        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }

        return $articles;
    }


    /**
     * @OA\Get(
     *     path="/articles/{id}",
     *     summary="Get article by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article details",
     *         @OA\JsonContent(ref="#/components/schemas/Article")
     *     )
     * )
     */
    public function getArticlesById($id) {
        $id = $this->db->escape_string($id);
        $result = $this->db->query("SELECT * FROM " . $this->config->dbprefix . "content WHERE id = '$id'");
        $articles = [];

        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }

        return $articles;
    }

    /**
     * @OA\Get(
     *     path="/articles/{slug}",
     *     summary="Get article by slug",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article details",
     *         @OA\JsonContent(ref="#/components/schemas/Article")
     *     )
     * )
     */
    public function getArticlesBySlug($slug) {
        $slug = $this->db->escape_string($slug);
        $result = $this->db->query("SELECT * FROM " . $this->config->dbprefix . "content WHERE alias = '$slug'");
        $articles = [];

        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }

        return $articles;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $api = new ArticleAPI();

    if (isset($_GET['category'])) {
        echo json_encode($api->getArticlesByCategory($_GET['category']));
    } elseif (isset($_GET['id'])) {
        echo json_encode($api->getArticlesById($_GET['id']));
    } elseif (isset($_GET['slug'])) {
        echo json_encode($api->getArticlesBySlug($_GET['slug']));
    }
}

/**
 * @OA\Schema(
 *     schema="Article",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="category", type="string")
 * )
 */
