<?php
class HomeController
{
    public function home()
    {
        
        include __DIR__ . '/../view/home.php';
    }
}
$controller = new HomeController();

if (isset($_GET['page']) && $_GET['page'] === 'users') {
    // include_once '../model/dbConnect.php';
    $controller->home();
} else {
    $controller->home(); // عرض الصفحة الرئيسية
}