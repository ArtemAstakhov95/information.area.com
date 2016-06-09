<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 08.11.2015
 * Time: 13:43
 */

include_once('DBMethods.php');
//include_once('Filter.php');

/*if($_POST['news']) {
    $n = json_decode($_POST['news']);

    $method = $n->method;
    if (method_exists('Table', $method)) {
        Table::$method($_POST['news']);
    }
}
else*/if($_POST['selection']) {
    $sel = json_decode($_POST['selection'], true);//преобразовывает в асоциативный массив
    $result = '{ "DBselect" : [';
    for ($i = 1; $i <= count($sel); $i++) {
        $param = '';
        if (method_exists('DBMethods', $sel['method' . $i]))
            $result .= DBMethods::$sel['method' . $i]($param);
    }
    echo $result .= ' ]}';
}
elseif($_POST['insert']){
    $insert = json_decode($_POST['insert']);
    $method = $insert->method;
    if(method_exists('DBMethods', $method))
        DBMethods::$method($insert);
}
elseif($_POST['autoComp']){
    $aut = json_decode($_POST['autoComp']);
    $method = $aut->method;
    if(method_exists('DBMethods', $method))
        DBMethods::$method($aut);
}
