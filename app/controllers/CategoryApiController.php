<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
require_once('app/utils/JWTHandler.php');

class CategoryApiController
{
    private $categoryModel;
    private $db;
    private $jwtHandler;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
        $this->jwtHandler = new JWTHandler();
    }

    private function authenticate()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $arr = explode(" ", $authHeader);
            $jwt = $arr[1] ?? null;
            if ($jwt) {
                $decode = $this->jwtHandler->decode($jwt);
                return $decode ? true : false;
            }
        }
        return false;
    }

    private function requireAuth()
    {
        header('Content-Type: application/json');
        if ($this->authenticate()) {
            return true;
        }
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        return false;
    }

    public function index()
    {
        if (!$this->requireAuth()) {
            return;
        }
        $categories = $this->categoryModel->getCategories();
        echo json_encode($categories);
    }

    public function show($id)
    {
        if (!$this->requireAuth()) {
            return;
        }
        $category = $this->categoryModel->getCategoryById($id);
        if ($category) {
            echo json_encode($category);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Category not found']);
        }
    }

    public function store()
    {
        if (!$this->requireAuth()) {
            return;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $result = $this->categoryModel->addCategory(
            $name,
            $description,
        );
        if (is_array($result)) {
            http_response_code(400);
            echo json_encode(['errors' => $result]);
        } else {
            http_response_code(201);
            echo json_encode(['message' => 'Category created successfully']);
        }
    }

    public function update($id)
    {
        if (!$this->requireAuth()) {
            return;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';

        $result = $this->categoryModel->updateCategory(
            $id,
            $name,
            $description,
        );
        if (is_array($result)) {
            http_response_code(400);
            echo json_encode(['errors' => $result]);
        } elseif ($result) {
            echo json_encode(['message' => 'Category updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Category update failed']);
        }
    }

    public function destroy($id)
    {
        if (!$this->requireAuth()) {
            return;
        }
        $result = $this->categoryModel->deleteCategory($id);
        if ($result) {
            echo json_encode(['message' => 'Category deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Category deletion failed']);
        }
    }
}
