<?php

class UserView
{
    public static function renderRegister()
    {
        echo <<<HTML
        <!doctype html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
                     <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                                 <meta http-equiv="X-UA-Compatible" content="ie=edge">
                     <title>Document</title>
        </head>
        <body class="register-body">
          <form class="register-card" method="POST" action="?page=register">
        <h2 class="make-account">Make an account</h2>
            <input class="register-input" type="text" name="firstname" placeholder="First Name" required><br><br>
            <input class="register-input" type="text" name="lastname" placeholder="Last Name" required><br><br>
            <input class="register-input" type="password" name="password" placeholder="Password" required><br><br>
            <input class="register-input" type="text" name="username" placeholder="Username" required><br><br>
            <button class="register-button" type="submit">Register</button>
        </form>
        </body>
        </html>
        
        HTML;
    }

    public static function renderLogin()
    {
        echo <<<HTML
        <!doctype html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
                     <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                                 <meta http-equiv="X-UA-Compatible" content="ie=edge">
                     <title>Document</title>
        </head>
        <body class="login-body">
          <form class="login-card" method="POST" action="?page=login">
        <h2 class="login-title">Login Page</h2>
            <input class="login-input" type="text" name="username" placeholder="Username" required><br><br>
            <input class="login-input" type="password" name="password" placeholder="Password" required><br><br>
            <button class="login-button" type="submit" name='login'>Login</button>
        </form>
        </body>
        </html>
        
        HTML;
    }

public static function renderUserList($users)
{
    include __DIR__ . '/../navbarAdmin.php';

    echo '<h2 class="page-title">All Users</h2>';
    echo '<div class="user-list">';
    foreach ($users as $user) {
        if (strtolower($user->role) === 'admin') {
            continue;
        }

        $id = htmlspecialchars($user->getID());
        $username = htmlspecialchars($user->username);

        echo <<<HTML
        <div class="user-card">
            <span class="user-name">👤 $username</span>
            <a class="delete-button" href="public.php?page=delete&del=$id" onclick="return confirm('Are you sure you want to delete this user?')">🗑 Delete</a>
        </div>
        HTML;
    }
    echo '</div>';
}


}
