<?php
require_once '../model/dbConnect.php';
require_once '../model/User.php';

$userModel = new User($pdo);

// سجل الأدمن
if ($userModel->registerAdmin('Admin', 'Super', 'admin123', 'admin')) {
    echo "✅ Admin user created successfully!";
} else {
    echo "❌ Failed to create admin.";
}
