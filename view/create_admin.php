<?php
require_once '../model/dbConnect.php';
require_once '../controller/UserController.php';

UserModel::setConnection($pdo);
UserController::createAdminUser();
//This file is opened to create an admin.