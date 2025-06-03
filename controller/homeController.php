<?php
class HomeController
{
    public function home()
    {
        
        header("Location: view/index.php");
                exit;
    }
}
