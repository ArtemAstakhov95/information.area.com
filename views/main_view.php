<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 09.11.2015
 * Time: 11:34
 */
?>
<div class="body col-md-8 col-md-offset-1">
    <div class="main-body col-md-12">
        <h1>Система формалізації даних часопису</h1>
        <div id="options">
            <div id="period-title">
                <h2>Виберіть період, що вас цікавить</h2>
            </div>
            <div id="slider">
                <input  type="range" min="<?=$this->minYear?>" max="<?=$this->maxYear?>">
            </div>
            <div id="date1">
                <label for="date1">Дата початку:
                    <input type="number" name="date1" class="date" value="<?=$this->minYear?>">
                    <input type="hidden" id="min-year" value="<?=$this->minYear?>">
                    <input type="hidden" id="current-min-year" value="<?=$this->minYear?>">
                </label>
            </div>
            <div id="date2">
                <label for="date2">Дата кінця:
                    <input type="number" name="date2" class="date" value="<?=$this->maxYear?>">
                    <input type="hidden" id="max-year" value="<?=$this->maxYear?>">
                    <input type="hidden" id="current-max-year" value="<?=$this->maxYear?>">
                </label>
            </div>
            <input id="view-range-btn" type="submit" value="Переглянути">
        </div>
        <div>
            <div class="range-title-div"></div>
            <div class="articles col-md-6 col-sm-12">
                <h2>Статті до цього періода</h2>
                <?foreach($data as $row){?>
                    <div class="intro-article">
                        <?if($row->image){?><img src="../images/<?=$row->image?>" style="width: 300px; height: 200px;float: left;margin-right: 9px;"><?}?>
                        <div>
                            <a href="/<?=$row->page_code?>"><?=$row->caption?></a> <sub>(<?=$row->year_start?><?if($row->year_end != null || $row->year_end!=0){?> - <?=$row->year_end?><?}?>)</sub>
                        </div>
                    </div>
                <?}?>
            </div>
            <div class="concepts col-md-6 col-sm-12">
                <div class="concepts-container" id="person">
                    <h2>Особистості цього періоду</h2>
                    <?foreach($this->personConcepts as $p){?>
                        <div class="concept">
                            <a href="/concept/<?=$p->getId()?>"><?=$p->getConcept()?></a> <sub>(<?=$p->getYearStart()?><?if($p->getYearEnd() != null || $p->getYearEnd()!=0){?> - <?=$p->getYearEnd()?><?}?>)</sub>
                        </div>
                    <?}?>
                </div>
                <div class="concepts-container" id="action">
                    <h2>Події цього періоду</h2>
                    <?foreach($this->actionConcepts as $p){?>
                        <div class="concept">
                            <a href="/concept/<?=$p->getId()?>"><?=$p->getConcept()?></a> <sub>(<?=$p->getYearStart()?><?if($p->getYearEnd() != null || $p->getYearEnd()!=0){?> - <?=$p->getYearEnd()?><?}?>)</sub>
                        </div>
                    <?}?>
                </div>
                <div class="concepts-container" id="institution">
                    <h2>Інституції цього періоду</h2>
                    <?foreach($this->institutionsConcepts as $p){?>
                        <div class="concept">
                            <a href="/concept/<?=$p->getId()?>"><?=$p->getConcept()?></a> <sub>(<?=$p->getYearStart()?><?if($p->getYearEnd() != null || $p->getYearEnd()!=0){?> - <?=$p->getYearEnd()?><?}?>)</sub>
                        </div>
                    <?}?>
                </div>
                <div class="concepts-container" id="document">
                    <h2>Документи цього періоду</h2>
                    <?foreach($this->documentConcepts as $p){?>
                        <div class="concept">
                            <a href="/concept/<?=$p->getId()?>"><?=$p->getConcept()?></a> <sub>(<?=$p->getYearStart()?><?if($p->getYearEnd() != null || $p->getYearEnd()!=0){?> - <?=$p->getYearEnd()?><?}?>)</sub>
                        </div>
                    <?}?>
                </div>
            </div>
        </div>
    </div>

<style>
    .articles{
        float: left;

        padding: 5px 15px 0 0;
    }
    .concepts{
        float: right;

        padding: 5px 0 0 15px;
    }
    .main-body h2,h1{
        margin-top: 0;
    }
    .concept{
        font-size: 14pt;
        margin-bottom: 5px;
    }
    .concept a{
        color: rgba(91, 81, 90, 0.90);
    }
    .concepts-container{
        margin-bottom: 25px;
    }
    #options{
        margin-top: 35px;
    }
    .range-title-div{
        text-align: center;
        margin-bottom: 30px;
    }
    #period-title{
        text-align: center;
    }
    .intro-article{
        margin-bottom: 15px;
        font-size: 14pt;
    }
    .intro-article:after{
        content: '';
        display: table;
        clear: both;
    }
    .intro-article a{
        color: rgba(91, 81, 90, 0.90);
    }
    .date {
        border:1px solid #074776;
        padding:5px;
        width:80px;
    }
    #date1{
        display: inline-block;
    }
    #date2{
        margin-left: 20px;
        display: inline-block;
    }
    #slider{
        display: block;
        margin-bottom: 15px;
    }
    #options{
        margin-bottom: 40px;
    }
    #view-range-btn{
        padding: 4px;
        margin-left: 20px;
        border: 1px solid grey;
        border-radius: 3px;
    }
</style>