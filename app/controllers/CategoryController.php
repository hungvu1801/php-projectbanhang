<?php

require_once('app/config/app.php');
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    public function add()
    {
        include 'app/views/category/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('Category/add'));
            exit;
        }

        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $result = $this->categoryModel->addCategory($name, $description);

        if (is_array($result)) {
            $errors = $result;
            include 'app/views/category/add.php';
            return;
        }

        header('Location: ' . url('Category/list'));
        exit;
    }
    public function delete($id)
    {
        if ($this->categoryModel->deleteCategory($id)) {
            header('Location: ' . url('Category/list'));
            exit;
        } else {
            echo "Đã xảy ra lỗi khi xóa danh mục.";
        }
    }
    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        if ($category) {
            include 'app/views/category/edit.php';
        } else {
            echo "Không thấy danh mục.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('Category/list'));
            exit;
        }

        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $result = $this->categoryModel->updateCategory($id, $name, $description);

        if (is_array($result)) {
            $errors = $result;
            $category = $this->categoryModel->getCategoryById($id);
            include 'app/views/category/edit.php';
            return;
        }

        header('Location: ' . url('Category/list'));
        exit;
    }
}
