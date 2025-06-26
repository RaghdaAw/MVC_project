<?php

require_once 'model/CartModel.php';
require_once 'model/LikeModel.php';

class ContactController
{
    public function index()
    {
        session_start();

        $userId = $_SESSION['user_id'] ?? null;
        $cartCount = $userId ? CartModel::getCartItemCount($userId) : 0;
        $likeCount = $userId ? LikeModel::getLikeCount($userId) : 0;
        $messageSent = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);
            $messageSent = true;
        }

        require 'view/contact.php';
    }
}
