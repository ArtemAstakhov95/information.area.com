<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 17.04.2016
 * Time: 13:28
 */
include '/views/header.php';
include_once('iDataSet.php');

$table = new Tables('Theses_class','Клас тез','id','id',Page::$db, 'Таблиця: Клас тези');
$table->addField('id','int','ID',true,false,true);
$table->addField('code','text','Код',false,true,true);
$table->addField('class','text','Клас',false,true,true);

$table->parseUrl();
echo $table->handle();

include "/views/footer.php";