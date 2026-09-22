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
    public function getCategoryById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
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
    public function deleteCategory($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateCategory($id, $name, $description)
    {
        $errors = [];
        if (trim($name) === '') {
            $errors['name'] = 'Tên danh mục không được để trống';
        }
        if (trim($description) === '') {
            $errors['description'] = 'Mô tả không được để trống';
        }
        $existing = $this->getCategoryByName(trim($name));
        if (empty($errors) && $existing && (int) $existing->id !== (int) $id) {
            $errors['name'] = 'Tên danh mục đã tồn tại';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $query = "UPDATE " . $this->table_name . " SET name=:name, description=:description WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
