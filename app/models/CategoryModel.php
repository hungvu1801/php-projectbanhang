<?php
class CategoryModel
{
    private $conn;
    private $table_name = "category";
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getCategories()
    {
        $query = "SELECT id, name, description FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function getCategoryByName($name)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE name = :name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function addCategory($name, $description)
    {
        $errors = [];
        if (trim($name) === '') {
            $errors['name'] = 'Tên danh mục không được để trống';
        }
        if (trim($description) === '') {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (empty($errors) && $this->getCategoryByName(trim($name))) {
            $errors['name'] = 'Tên danh mục đã tồn tại';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $query = "INSERT INTO " . $this->table_name . " (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
