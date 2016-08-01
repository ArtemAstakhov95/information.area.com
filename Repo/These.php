<?php

/**
 * Created by PhpStorm.
 * User: artem
 * Date: 31.07.2016
 * Time: 16:14
 */
class These
{
    private $id, $conceptId, $these, $class, $pageCode, $dayStart, $monthStart, $yearStart, $dayEnd, $monthEnd, $yearEnd;

    public function __construct()
    {
        $args = func_get_args();
        $argsNum = func_num_args();
        if ($argsNum == 1 && is_array($args)){
            call_user_func_array(array($this, '__constructArray'), $args);
        } elseif (method_exists($this, $method = '__construct'.$argsNum)) {
            call_user_func_array(array($this, $method), $args);
        }
    }

    function __constructArray(Array $these)
    {
        $this->id = $these['id'];
        $this->conceptId = $these['concept_id'];
        $this->these = $these['theses'];
        $this->class = $these['class'];
        $this->pageCode = $these['page_code'];
        $this->dayStart = $these['day_start'];
        $this->monthStart = $these['month_start'];
        $this->yearStart = $these['year_start'];
        $this->dayEnd = $these['day_end'];
        $this->monthEnd = $these['month_end'];
        $this->yearEnd = $these['year_end'];
        $this->conceptCase = $these['concept_case'];
    }

    function __construct2($these, $pageCode)
    {
        $this->these = $these;
        $this->pageCode = $pageCode;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getConceptId()
    {
        return $this->conceptId;
    }

    public function getThese()
    {
        return $this->these;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getPageCode()
    {
        return $this->pageCode;
    }

    public function getDayStart()
    {
        return $this->dayStart;
    }

    public function getMonthStart()
    {
        return $this->monthStart;
    }

    public function getYearStart()
    {
        return $this->yearStart;
    }

    public function getDayEnd()
    {
        return $this->dayEnd;
    }

    public function getMonthEnd()
    {
        return $this->monthEnd;
    }

    public function getYearEnd()
    {
        return $this->yearEnd;
    }

    public function setThese($these){
        $this->these = $these;
    }
}