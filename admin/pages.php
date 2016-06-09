<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 09.03.2016
 * Time: 17:00
 */
include '/views/header.php';
include_once('iDataSet.php');

$table = new Tables('pages', 'Сторінки', 'code', 'year_start', Page::$db, 'Таблиця: Сторінки');
$table->addField('id', 'int', 'ID', true, false, true);
$table->addField('code', 'text', 'Код', false, false, true);
$table->addField('caption', 'text', 'Назва', false, true, true);
$table->addField('intro', 'text', 'Опис', false, true, false);
$table->addField('content', 'varchar', 'Зміст', false, true, false);
$table->addField('date', 'datetime', 'Дата', false, true, false);
$table->addField('image', 'image', 'Зображення', false, true, false);
$table->addField('main', 'boolean', 'Головна', false, true, false);
$table->addField('parentCode', 'lookup', 'Розділ', false, true, false);
//$table->addLookupField('parentCode', 'categories', 'category', 'title');
$table->addField('isContainer', 'boolean', 'Контейнер', false, true, false);
$table->addField('day_start', 'int', 'День початку', false, true, true);
$table->addField('month_start', 'int', 'Місяць початку', false, true, true);
$table->addField('year_start', 'int', 'Рік початку', false, true, true);
$table->addField('day_end', 'int', 'День завершення', false, true, true);
$table->addField('month_end', 'int', 'Місяць завершення', false, true, true);
$table->addField('year_end', 'int', 'Рік завершення', false, true, true);
$subTable = new SubTable($table, 'page_concept', 'Поняття сторінки', 'id', 'page_code', Page::$db);
$subTable->addField('id','int','ID',true,false,true);
$subTable->addField('page_code','text','Сторінка',false,false,true);
$subTable->addField('concept','text','Поняття',false,true,true);
$table->parseUrl();
echo $table->handle();

include '/views/footer.php';