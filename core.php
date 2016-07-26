<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 09.10.2015
 * Time: 20:54
 */
require 'Recordset.php';
include 'page.php';
session_start();
$host = "localhost";
$dbname = "Concept";
$user = "root";
$pass = "";
Page::$db = new Recordset();
Page::$db->connect($host, $dbname, $user, $pass);

$code = "main";
$view_type = "intro";
$art = 1;
$routes = explode('/', $_SERVER['REQUEST_URI']);
array_shift($routes);

if (!empty($_GET['view'])) {
    $r = array_pop($routes);
    $view_type = $_GET['view'];
}
if (!empty($_GET['article'])) {
    $r = array_pop($routes);
    $art = $_GET['article'];
}
if (!empty($routes[0])) {
    $code = $routes[0];
    if ($code=='concept') {
        $art = $routes[1];
    }
}
if (isset($_GET['exit'])) {
    if ($_GET['exit'] == 1) {
        $_SESSION = array();
        session_destroy();
        echo '<script type="text/javascript">window.location.href="/"</script>';
        $code = "main";
    }
}
if (!empty($routes[1]) && $routes[0]!='concept') {//$routes[0] === 'browse' || $routes[0] === 'edit' || $routes[0] === 'add' || $routes[0] === 'delete'){
    $route = 'admin/'.$routes[0].'.php';
    if ($_SESSION['is_auth']) {
        if (file_exists($route)) {
            include $route;
        } else {
            include '/views/header.php';
            include '/views/404_view.php';
            include '/views/footer.php';
        }
    } else {
        include '/views/header.php';
        include '/views/404_view.php';
        include '/views/footer.php';
    }
} elseif($routes[0] == 'admin-page') {
    include '/views/header.php';
    include '/views/admin_page_view.php';
    include '/views/footer.php';
} else {
    $page = new Page($code, $view_type, $art, true, null);
    $data = $page->getContent();
    $title = $page->getTitle();
    include 'views/header.php';
    $page->publish($data);
    include 'views/footer.php';
}