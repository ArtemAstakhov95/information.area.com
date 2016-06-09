<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 17.04.2016
 * Time: 11:29
 */
?>
<div class="body col-md-8 col-md-offset-1">
    <div class="article-content col-xs-12 ">
        <ul class="admin-possibilities">
            <li><a href="/pages/browse">Таблиця сторінок</a></li>
            <li><a href="/Concepts/browse">Таблиця понять</a></li>
            <li><a href="/Theses/browse">Таблиця тез</a></li>
            <li><a href="/Concept_class/browse">Таблиця класів понять</a></li>
            <li><a href="/Theses_class/browse">Таблиця класів тез</a></li>

        </ul>
    </div>

<style>
    .admin-possibilities{
        list-style: none;
        padding:0;
    }
    .admin-possibilities a{
        font-size: 15pt;
        text-decoration: none;
        color: #464646;
    }
    .admin-possibilities a:hover{
        color:#92A2AF;
    }
    .admin-possibilities li{
        padding: 7px 20px;
        margin-bottom: 10px;
        border-radius: 5px;
        border-left: 10px solid #f05d22;
        box-shadow: 2px -2px 5px 0 rgba(0,0,0,.1),
        -2px -2px 5px 0 rgba(0,0,0,.1),
        2px 2px 5px 0 rgba(0,0,0,.1),
        -2px 2px 5px 0 rgba(0,0,0,.1);
        font-size: 20px;
        letter-spacing: 2px;
        background:white;
        transition: 0.3s all linear;
    }
    .admin-possibilities li:nth-child(2){border-color: #8bc63e;/**/}
    .admin-possibilities li:nth-child(3){border-color: #fcba30;/*#fcba30;*/}
    .admin-possibilities li:nth-child(4){border-color: #1ccfc9;}
    .admin-possibilities li:nth-child(5){border-color: #493224;/*#493224;*/}
    .admin-possibilities li:hover {
        border-left: 10px solid transparent;
    }
    .admin-possibilities li:nth-child(1):hover {
        border-right: 10px solid #f05d22;
    }
    .admin-possibilities li:nth-child(2):hover {
        border-right: 10px solid #8bc63e;
    }
    .admin-possibilities li:nth-child(3):hover {
        border-right: 10px solid #fcba30;
    }
    .admin-possibilities li:nth-child(4):hover {
        border-right: 10px solid #1ccfc9;
    }
    .admin-possibilities li:nth-child(5):hover {
        border-right: 10px solid #493224;
    }
    .admin-div h2{
        margin-top: -5px;
    }
</style>