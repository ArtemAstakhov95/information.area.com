<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 23.09.2015
 * Time: 14:45
 */
include_once('DB.php');
class Recordset
{
    private $database;
    private $sth;
    private $dbh;

    public function __construct()
    {
        $this->database = DB::get();
    }

    public function connect($host, $dbname, $user, $pass)
    {
        $this->dbh = $this->database->connect($host, $dbname, $user, $pass);
    }

    public function nextRow()
    {
        return $this->sth->fetch();
    }

    public function allRows()
    {
        return $this->sth->fetchAll();
    }

    public function getColumn()
    {
        return $this->sth->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getSTH()
    {
        return $this->sth;
    }

    public function SQL()
    {
        $args = func_get_args();
        $query = $args[0];
        $argsCount = count($args);
        if ($argsCount > 1) {
            if (is_array($args[1])) {
                $this->sth = $this->dbh->prepare($query);
                $this->sth->execute($args[1]);
            } else {
                array_shift($args);
                $this->sth = $this->dbh->prepare($query);
                $this->sth->execute($args);
            }
        } else {
            $this->sth = $this->dbh->query($query);
        }
    }
}
?>