<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 20.12.2015
 * Time: 22:46
 */
?>
<div class="side-bar">
    <div class="panel-open">
        <div class="icon-menu">
            <i class="fa fa-bars"></i>
            Меню
        </div>
    </div>
    <div class="admin-right-panel">
        <div class="close-panel"><i class="fa fa-times"></i></div>
        <label for="page-concepts">Поняття сторінки</label>
        <select multiple name="page-concepts">
            <?foreach($this->pageConcepts as $c){?>
                <option><?=$c?></option>
            <?}?>
        </select>
        <div class="add-concept">
            <textarea rows="3" placeholder="Поняття" id="concept"></textarea><input type="submit" value="Вибрати поняття" class="select-concept-button">
        </div>
        <div class="add-these">
            <textarea rows="4" placeholder="Теза" id="these"></textarea><input type="submit" value="Вибрати тезу" class="select-these-button">
        </div>
        <a href="/add-article"><input type="submit" value="Створити статтю" class="add-article-button"></a>
    </div>
</div>


<style>
    .close-panel{
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 30px;
    }
    .panel-open{
        float: left;
        cursor: pointer;
        font-family: 'Open Sans', sans-serif;
        font-size: 15px;
        text-decoration: none;
        text-transform: uppercase;
    }
    .side-bar{
        width: 370px;
        height: 100%;
        position: fixed;
        right: -300px;
        top: 70px;
    }
    .admin-right-panel{
        width: 300px;
        float: right;
        padding: 15px;
        height: 100%;
        background-color: #EEEFED;
        border-color: #5e5e5e;
        overflow: auto;
    }
    .add-article-button{
        height: 35px;
        margin-bottom: 5px;
        border-radius: 4px;
        border: 1px solid #5e5e5e;
        color: #666869;
    }
    .add-concept{
        margin: 15px 0;
    }
    .admin-right-panel input[type='text']{
        border: 1px solid grey;
        border-radius: 3px;
        padding: 5px;
        width: 100%;
        margin-bottom: 7px;
    }

    .admin-right-panel textarea{
        border: 1px solid grey;
        border-radius: 3px;
        padding: 5px;
        width: 100%;
        max-width: 100%;
        max-height: 110px;
        margin-bottom: 7px;
    }

    #search-result{
        border: 1px solid grey;
        border-radius: 3px;
        width: 100%;
        margin-bottom: 7px;
    }

    .admin-right-panel input[type='submit']{
        border: 1px solid grey;
        border-radius: 3px;
        padding: 4px;
        margin-top: 10px;
    }

    .concept-fields{
        margin-top: 15px;
    }

    .admin-right-panel select,input[type="number"]{
        width: 180px;
        padding: 4px;
        border: 1px solid grey;
        border-radius: 3px;
    }

    .admin-right-panel input[type="number"]{
        margin-top: 10px;
    }

    .select-these-button{
        margin-bottom: 10px;
    }

    #search-result{
        border-top: none;
        margin-top: -7px;
        background-color: #fff;
    }
    #search-result ul{
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    #search-result li{
        cursor: pointer;
    }

    #search-result li:hover{
        background-color: #aeb3b9;
    }

    #concept-search{
        padding-left: 5px;
    }

    .search-result-li-div{
        padding: 5px;
    }
</style>