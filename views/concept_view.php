<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 31.03.2016
 * Time: 22:21
 */
?>
<div class="body col-md-8 col-md-offset-1">
    <div class="article-content col-xs-12 ">
        <H1><?=$this->dat[0]['concept']?></H1>
        <?foreach($this->dat as $row){?>
            <p><?=htmlspecialchars_decode($row['theses'])?></p>
        <?}?>
        <?if($this->personConcepts){?>
            <H2>Пов'язані особи:</H2>
            <?foreach($this->personConcepts as $row){?>
                <p class="links"><a href="/concept/<?=$row['id']?>"><?=$row['concept']?></a></p>
            <?}?>
        <?}?>
        <?if($this->actionConcepts){?>
            <H2>Пов'язані події:</H2>
            <?foreach($this->actionConcepts as $row){?>
                <p class="links"><a href="/concept/<?=$row['id']?>"><?=$row['concept']?></a></p>
            <?}?>
        <?}?>
        <?if($this->institutionsConcepts){?>
            <H2>Пов'язані інституції:</H2>
            <?foreach($this->institutionsConcepts as $row){?>
                <p class="links"><a href="/concept/<?=$row['id']?>"><?=$row['concept']?></a></p>
            <?}?>
        <?}?>
        <?if($this->documentConcepts){?>
            <H2>Пов'язані документи:</H2>
            <?foreach($this->documentConcepts as $row){?>
                <p class="links"><a href="/concept/<?=$row['id']?>"><?=$row['concept']?></a></p>
            <?}?>
        <?}?>
        <H2>Статті по темі:</H2>
        <?foreach($this->conceptPages as $row){?>
            <p class="links"><a href="/<?=$row['page_code']?>"><?=$row['caption']?></a></p>
        <?}?>
    </div>


<style>
    .article-content{
        font-family: Georgia, serif;
        font-size: 13pt;
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
</style>