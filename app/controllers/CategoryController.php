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
}
