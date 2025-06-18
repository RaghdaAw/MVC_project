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
        echo "<h2>All Users</h2>";
        echo "<ul>";
        foreach ($users as $user) {
            $id = htmlspecialchars($user['user_id']);
            $username = htmlspecialchars($user['username']);
            echo "<li>$username - <a href='public.php?page=delete&del=$id'>Delete</a></li>";
        }
        echo "</ul>";
    }
}
