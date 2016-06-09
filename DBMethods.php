<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 29.01.2016
 * Time: 10:31
 */

include_once('Recordset.php');

class DBMethods{
    private static $host = "localhost";
    private static $dbname = "Concept";
    private static $user = "root";
    private static $pass = "";

    public static function getConceptClass($result){
        $db = new Recordset();
        $db->connect(self::$host, self::$dbname, self::$user, self::$pass);

        try{
            $db->SQL("SELECT code, class FROM Concept_class");
            $result .= '{ "ConceptClass" : [';
            while($row = $db->nextRow()){
                $result .= '{"code":"'.$row['code'].'", "class" : "'.$row['class'].'"},';
            }
            $result .= '{"code":"2","class":"3"}';
            $result .= ' ]}';
        }
        catch(Exception $e){
            echo $e;
        }
        return $result;
    }

    public static function addConcept($dat){
        try{
            $db = new Recordset();
            $db->connect(self::$host, self::$dbname, self::$user, self::$pass);
            echo $dat->yearStart;
            $db->SQL("INSERT INTO Concepts(concept, class, day_start, month_start, year_start, day_end, month_end, year_end) VALUES(?,?,?,?,?,?,?,?)",
                $dat->concept, $dat->class, $dat->dayStart, $dat->monthStart, $dat->yearStart, $dat->dayEnd, $dat->monthEnd, $dat->yearEnd);
        }
        catch(Exception $e){
            echo $e;
        }
    }

    public static function getTheseClass($result){
        $db = new Recordset();
        $db->connect(self::$host, self::$dbname, self::$user, self::$pass);

        try{
            $db->SQL("SELECT code, class FROM Theses_class");
            $result .= '{ "TheseClass" : [';
            while($row = $db->nextRow()){
                $result .= '{"code":"'.$row['code'].'", "class" : "'.$row['class'].'"},';
            }
            $result .= '{"code":"2","class":"3"}';
            $result .= ' ]}';
        }
        catch(Exception $e){
            echo $e;
        }
        return $result;
    }

    public static function addThese($dat){
        $routes = explode('/', $dat->page);
        array_shift($routes);
        try{
            $db = new Recordset();
            $db->connect(self::$host, self::$dbname, self::$user, self::$pass);
            $db->SQL("INSERT INTO Theses(concept_id, theses, class, page_code, day_start, month_start, year_start, day_end, month_end, year_end) VALUES(?,?,?,?,?,?,?,?,?,?)",
                $dat->conceptId, $dat->these, $dat->class, $routes[0], $dat->dayStart, $dat->monthStart, $dat->yearStart, $dat->dayEnd, $dat->monthEnd, $dat->yearEnd);
        }
        catch(Exception $e){
            echo $e;
        }
    }

    public static function autoComplete($str){
        $db = new Recordset();
        $db->connect(self::$host, self::$dbname, self::$user, self::$pass);
        try{
            $query = "SELECT id,concept,year_start,year_end FROM Concepts WHERE concept LIKE '%".$str->str."%' ";
            $db->SQL($query);
            $result = '{ "SearchResult" : [';
            $comma = false;
            while($row = $db->nextRow()){
                if($comma)
                    $result.=',';
                $result .= '{"id":"'.$row['id'].'", "concept" : "'.$row['concept'].'", "year_start" : "'.$row['year_start'].'", "year_end":"'.$row['year_end'].'"}';
                $comma=true;
            }
            echo $result.= ']}';
        }
        catch(Exception $e){
            echo $e;
        }
    }

    public static function getPeriodData($dat){
        $db = new Recordset();
        $db->connect(self::$host, self::$dbname, self::$user, self::$pass);
        $query = "SELECT id,code,caption,year_start,year_end FROM pages WHERE year_start between $dat->year_start and $dat->year_end
                  or year_end between $dat->year_start and $dat->year_end or year_start<$dat->year_start and year_end>$dat->year_end
                  ORDER BY year_start";
        $db->SQL($query);
        $result = '{ "pages" : [';
        $comma = false;
        while($row = $db->nextRow()){
            if($comma)
                $result.=',';
            $result .= '{"id":"'.$row['id'].'", "code" : "'.$row['code'].'", "caption" : "'.$row['caption'].'", "year_start" : "'.$row['year_start'].'", "year_end" : "'.$row['year_end'].'"}';
            $comma=true;
        }
        $result .= '], "concepts" : [';
        $query = "SELECT id,concept,class,year_start,year_end FROM Concepts WHERE year_start between $dat->year_start and $dat->year_end
                  or year_end between $dat->year_start and $dat->year_end or year_start<$dat->year_start and year_end>$dat->year_end
                  ORDER BY year_start";
        $db->SQL($query);
        $comma = false;
        while($row = $db->nextRow()){
            if($comma)
                $result.=',';
            $result .= '{"id":"'.$row['id'].'", "concept" : "'.$row['concept'].'", "class" : "'.$row['class'].'", "year_start" : "'.$row['year_start'].'", "year_end" : "'.$row['year_end'].'"}';
            $comma=true;
        }
        echo $result .= ']}';
    }
}