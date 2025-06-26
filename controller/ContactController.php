<?php

require_once 'model/CartModel.php';
require_once 'model/LikeModel.php';

class ContactController
{
    public function index()
    {
        // session_start();

        // إذا المستخدم مسجّل دخول، جيب عدد السلة واللايكات
        $userId = $_SESSION['user_id'] ?? null;
        $cartCount = $userId ? CartModel::getCartItemCount($userId) : 0;
        $likeCount = $userId ? LikeModel::getLikeCount($userId) : 0;

        $messageSent = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // معالجة الرسالة
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);

            // هنا بإمكانك حفظ الرسالة في قاعدة البيانات أو إرسالها عبر بريد إلكتروني

            $messageSent = true;
        }

        // تمرير البيانات إلى الـ view
        require 'view/contact.php';
    }
}
