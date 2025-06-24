<?php

class UserView
{
    public static function renderRegister()
    {
        echo <<<HTML
        <h2>Account maken</h2>
        <form method="POST" action="?page=register">
            <input type="text" name="firstname" placeholder="Firstname" required><br><br>
            <input type="text" name="lastname" placeholder="Lastname" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <input type="text" name="username" placeholder="Username" required><br><br>
            <button type="submit">Register</button>
        </form>
        HTML;
    }

    public static function renderLogin()
    {
        echo <<<HTML
        <h2>Login Page</h2>
        <form method="POST" action="?page=login">
            <input type="text" name="username" placeholder="Username" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit" name='login'>Login</button>
        </form>
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
