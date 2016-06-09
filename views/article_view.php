<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 15.12.2015
 * Time: 21:18
 */
?>
<div class="body col-md-12">
    <div class="article-content col-xs-8 col-md-offset-1 ">
        <div class="article" >
            <div class="edit-article">
                <a href="/pages/edit/<?=$this->page_code?>"><span><img src="../images/edit.gif"></span></a>
            </div>
            <H2><?=$this->caption?></H2>
            <p style="font-style: italic; font-size: 13pt;"><?=$this->intro?></p>
            <?if($this->image){?><img class="col-xs-12" src="../images/<?=$this->image?>" style="display: block;margin-bottom: 15px;"><?}?>
            <div style="font-size: 13pt;">
                <?=htmlspecialchars_decode($this->content)?>
            </div>
        </div>
        <?if($this->conceptDefinition){?>
            <h2>Читайте також:</h2>
            <?foreach($this->conceptDefinition as $row){
                if($row['page_code'] != $this->page_code){?>
                <p class="links"><a href="/<?=$row['page_code']?>"><?=$row['caption']?></a></p>
        <?}}}?>
    </div>
    <div class="concept-side-bar col-xs-3">
        <h2 id="concept-side-bar-title">Поняття сторінки</h2>
        <?if($this->conceptDefinition)foreach($this->conceptDefinition as $row){?>
            <div class="concept-definition"><div class="concept"><a href="/concept/<?=$row['id']?>"><strong><?=$row['concept']?></strong></a></div>
                <?=htmlspecialchars_decode($row['theses'])?></div>
        <?}?>
    </div>

<style>
    .article-content{
        font-family: Georgia, serif;
        margin-bottom: 45px;

    }
    .article-content h1{
        margin-top: 0;

    }
    .links{
        font-size: 14pt;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .edit-article{
        float: right;
        margin-right: 20px;
    }
    #concept-side-bar-title{
        text-align: center;
    }
    .concept-side-bar{

    }
    .concept-definition{
        padding: 3px 20px;
        font-size: 12pt;
        margin-top: 45px;
    }
    .concept{
        font-size: 13pt;
        margin-bottom: 8px;
    }
</style>