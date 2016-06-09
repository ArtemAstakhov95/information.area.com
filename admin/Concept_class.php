<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 17.04.2016
 * Time: 13:33
 */

include '/views/header.php';
include_once('iDataSet.php');

$table = new Tables('Concept_class','Клас понять','id','id',Page::$db, 'Таблиця: Клас поняття');
$table->addField('id','int','ID',true,false,true);
$table->addField('code','text','Код',false,true,true);
$table->addField('class','text','Клас',false,true,true);

$table->parseUrl();
echo $table->handle();

include "/views/footer.php";