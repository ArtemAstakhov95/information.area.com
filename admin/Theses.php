<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 17.04.2016
 * Time: 13:06
 */

include '/views/header.php';
include_once('iDataSet.php');

$table= new Tables('Theses','Тези','id', 'year_start', Page::$db, 'Таблиця: Теза');
$table->addField('id','int','ID',true,false,true);
$table->addField('concept_id','int','id поняття тези',false,true,true);
$table->addField('theses','varchar','Теза',false,true,true);
$table->addField('class','lookup','Клас тези',false,true,true);
$table->addLookupField('class','Theses_class','class','class');
$table->addField('page_code','text','Сторінка тези',false,true,true);
$table->addField('day_start','int','День початку',false,true,true);
$table->addField('month_start','int','Місяць початку',false,true,true);
$table->addField('year_start','int','Рік початку',false,true,true);
$table->addField('day_end','int','День завершення',false,true,true);
$table->addField('month_end','int','Місяць завершення',false,true,true);
$table->addField('year_end','int','Рік завершення',false,true,true);

$table->addSearchField('concept_id','Введіть id поняття');

$table->parseUrl();
echo $table->handle();

include '/views/footer.php';