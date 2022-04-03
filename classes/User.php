<?php
class User
{
    public function isAdmin()
    {
        return isset($_SESSION['user_role']) && 'admin' == $_SESSION['user_role'];
    }
    public function isLoggedIn()
    {
        return isset($_SESSION['logged_in']);
    }
    public function userName()
    {
        return isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'guest';
    }
}