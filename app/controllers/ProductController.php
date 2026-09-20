<?php

// Require SessionHelper and other necessary files 
require_once('app/config/app.php');
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }
    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/products/list.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/products/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }
    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/products/add.php';
    }
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            $image = '';
            try {
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $image = $this->uploadImage($_FILES['image']);
                }
            } catch (Exception $e) {
                $errors = ['image' => $e->getMessage()];
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/products/add.php';
                return;
            }

            $result = $this->productModel->addProduct(
                $name,
                $description,
                $price,
                $category_id,
                $image
            );
            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/products/add.php';
            } else {
                header('Location: ' . url('Product'));
                exit;
            }
        }
    }
    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/products/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            $image = $_POST['existing_image'] ?? '';
            try {
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $image = $this->uploadImage($_FILES['image']);
                }
            } catch (Exception $e) {
                $errors = ['image' => $e->getMessage()];
                $product = $this->productModel->getProductById($id);
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/products/edit.php';
                return;
            }
            $this->productModel->updateProduct(
                $id,
                $name,
                $description,
                $price,
                $category_id,
                $image
            );
            header('Location: ' . url('Product'));
            exit;
        }
    }
    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: ' . url('Product'));
            exit;
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file) {
        $target_dir = "uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . uniqid('product_', true) . '.' . $imageFileType;

        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh");
        }

        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn");
        }

        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF."); 
        }

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
    }

    public function addToCart($id) {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm";
            return;
        }

        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        if (isset($_SESSION["cart"][$id])) {
            $_SESSION["cart"][$id]["quantity"]++;
        } else {
            $_SESSION["cart"][$id] = [
                "name" => $product->name, 
                "price" => $product->price,
                "quantity" => 1,
                "image" => $product->image,
            ];
        }
        header('Location: ' . url('Product/cart'));
        exit;
    }

    public function cart()
    {
        $cart = $_SESSION['cart'] ?? [];
        include 'app/views/products/cart.php';
    }
    public function checkout()
    {
        include "app/views/products/checkout.php";
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('Product/checkout'));
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if ($name === '' || $phone === '' || $address === '') {
            echo "Vui lòng nhập đầy đủ họ tên, số điện thoại và địa chỉ.";
            return;
        }

        if (empty($_SESSION['cart'])) {
            echo "Giỏ hàng trống";
            return;
        }

        try {
            $this->db->beginTransaction();

            $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':phone', $phone);
            $stmt->bindValue(':address', $address);
            $stmt->execute();
            $order_id = $this->db->lastInsertId();

            foreach ($_SESSION['cart'] as $product_id => $item) {
                $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':order_id', $order_id);
                $stmt->bindValue(':product_id', $product_id);
                $stmt->bindValue(':quantity', $item['quantity']);
                $stmt->bindValue(':price', $item['price']);
                $stmt->execute();
            }

            unset($_SESSION['cart']);
            $this->db->commit();

            header('Location: ' . url('Product/orderConfirmation'));
            exit;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
        }
    }

    public function orderConfirmation()
    {
        include "app/views/products/orderConfirmation.php";
    }

    public function list()
    {
        $this->index();
    }
}
