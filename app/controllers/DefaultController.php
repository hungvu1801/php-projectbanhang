<?php

require_once('app/config/database.php');
require_once('app/models/ProductModel.php');

class DefaultController
{
    public function index()
    {
        $db = (new Database())->getConnection();
        $productModel = new ProductModel($db);
        $products = $productModel->getProducts();
        include 'app/views/home.php';
    }
}
