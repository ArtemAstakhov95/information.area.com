<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 20.12.2015
 * Time: 10:13
 */

if(isset($_COOKIE['pass']) and isset($_COOKIE['login'])){
    if(($_COOKIE['login'] !== 'admin') or ($_COOKIE['pass'] !== 'qwerty')){
        setcookie('pass', '');
        setcookie('login', '');
        print "Something wrong";
    }
    else{
        print "Hello, "/$_COOKIE['login']."!";
    }
}