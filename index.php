<?php

session_start();
require_once 'app/config/app.php';
require_once 'app/models/ProductModel.php';
require_once 'app/helpers/SessionHelper.php';
require_once 'app/controllers/ProductApiController.php';
require_once 'app/controllers/CategoryApiController.php';


$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Kiểm tra phần đầu tiên của URL để xác định controller 
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' :
    'DefaultController';

// Kiểm tra phần thứ hai của URL để xác định action 
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';


// Định tuyến các yêu cầu API
if ($controllerName === 'ApiController' && isset($url[1])) {
    $apiControllerName = ucfirst($url[1]) . 'ApiController';
    $apiControllerFile = 'app/controllers/' . $apiControllerName . '.php';
    if (file_exists($apiControllerFile)) {
        require_once $apiControllerFile;
        $controller = new $apiControllerName();
        $method = $_SERVER['REQUEST_METHOD'];
        $methodOverride = $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] ?? '';
        if ($method === 'POST' && $methodOverride !== '') {
            $method = strtoupper($methodOverride);
        }
        $id = $url[2] ?? null;
        $action = null;
        switch ($method) {
            case 'GET':
                $action = $id ? 'show' : 'index';
                break;
            case 'POST':
                $action = 'store';
                break;
            case 'PUT':
                $action = $id ? 'update' : null;
                break;
            case 'DELETE':
                $action = $id ? 'destroy' : null;
                break;
            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method Not Allowed']);
                exit;
        }
        if ($action && method_exists($controller, $action)) {
            if ($id) {
                call_user_func_array([$controller, $action], [$id]);
            } else {
                call_user_func_array([$controller, $action], []);
            }
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Action not found']);
        }
        exit;
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Controller not found']);
        exit;
    }
}

// die ("controller=$controllerName - action=$action");
// Kiểm tra xem controller và action có tồn tại không 
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    // Xử lý không tìm thấy controller 
    die('Controller not found');
}
require_once 'app/controllers/' . $controllerName . '.php';
$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    // Xử lý không tìm thấy action 
    die('Action not found');
}
// Gọi action với các tham số còn lại (nếu có) 
call_user_func_array([$controller, $action], array_slice($url, 2));
