<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 17.04.2016
 * Time: 11:42
 */

include '/views/header.php';
include_once('iDataSet.php');
$action = 'browse';
$page_code = 0;

$table = new Tables('Concepts', 'Поняття', 'id', 'year_start', Page::$db, 'Таблиця: Поняття');
$table->addField('id','int','ID',true,false,true);
$table->addField('concept','text','Поняття',false,true,true);
$table->addField('class','lookup','Клас поняття',false,true,true);
$table->addLookupField('class','Concept_class','code','class');
$table->addField('day_start','int','День початку',false,true,true);
$table->addField('month_start','int','Місяць початку',false,true,true);
$table->addField('year_start','int','Рік початку',false,true,true);
$table->addField('day_end','int','День завершення',false,true,true);
$table->addField('month_end','int','Місяць завершення',false,true,true);
$table->addField('year_end','int','Рік завершення',false,true,true);
$table->addField('concept_case','text','Відмінки поняття',false,true,true);

$table->parseUrl();
echo $table->handle();

include '/views/footer.php';