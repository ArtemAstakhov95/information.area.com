<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 09.11.2015
 * Time: 11:34
 */
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title><?=$title?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">

        <script src="/script/jquery-1.11.3.min.js"></script>
        <?if(isset($_SESSION['is_auth'])){
            if($_SESSION['is_auth']){?>
                <script type="text/javascript" src="/admin/script/search.js"></script>
                <script type="text/javascript" src="/script/admin_fw_src.js"></script>
            <?}}?>
        <link rel="stylesheet" href="/css/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/style.css"/>
        <link rel="stylesheet" type="text/css" href="/css/jquery-ui-timepicker-addon.css">
        <link rel="stylesheet" type="text/css" href="/script/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="/FontAwesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/admin.css"/>

        <link rel="stylesheet" type="text/css" href="/css/slider.css">
    </head>
    <body>
        <div class="navbar-wrapper ">
            <div class="container">
                <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="/"><img src="/images/logo.jpg" class="logo"></a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px; ">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="/">Головна</a>
                                </li>
                                <li>
                                    <a>Про нас</a>
                                </li>
                                <li>
                                    <a>Контакти</a>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <?if(isset($_SESSION['is_auth'])){
                                    if($_SESSION['is_auth']){
                                        ?>
                                        <li>
                                            <a href="/admin-page"><?=$_SESSION['login']?></a>
                                        </li>
                                        <li><a href="?exit=1">Вийти</a></li>
                                    <?}else{?>
                                        <li><a href="/login">Увійти</a></li>
                                        <li>Зареєструватись</li>
                                    <?
                                    }
                                }else{?>
                                    <li><a href="/login">Увійти</a></li>
                                    <li>Зареєструватись</li>
                                <?}?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="page-content-div">