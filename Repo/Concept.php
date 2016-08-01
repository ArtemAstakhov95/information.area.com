<?php

/**
 * Created by PhpStorm.
 * User: artem
 * Date: 31.07.2016
 * Time: 14:38
 */
class Concept
{
    private $id, $concept, $class, $dayStart, $monthStart, $yearStart, $dayEnd, $monthEnd, $yearEnd;
    private $conceptCase, $classCaption;

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

    function __constructArray(Array $concept)
    {
        $this->id = $concept['id'];
        $this->concept = $concept['concept'];
        $this->class = $concept['class'];
        $this->dayStart = $concept['day_start'];
        $this->monthStart = $concept['month_start'];
        $this->yearStart = $concept['year_start'];
        $this->dayEnd = $concept['day_end'];
        $this->monthEnd = $concept['month_end'];
        $this->yearEnd = $concept['year_end'];
        $this->conceptCase = $concept['concept_case'];
    }

    function __construct4($id, $concept, $yearStart, $yearEnd)
    {
        $this->id = $id;
        $this->concept = $concept;
        $this->yearStart = $yearStart;
        $this->yearEnd = $yearEnd;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getConcept()
    {
        return $this->concept;
    }

    public function getClass()
    {
        return $this->class;
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

    public function getConceptCase()
    {
        return $this->conceptCase;
    }

    public function separateConceptsOnClass(&$page)
    {
        switch ($this->getClass()) {
            case 'person':
                array_push($page->personConcepts, $this);
                break;
            case 'action':
                array_push($page->actionConcepts, $this);
                break;
            case 'institution':
                array_push($page->institutionsConcepts, $this);
                break;
            case 'document':
                array_push($page->documentConcepts, $this);
                break;
        }
    }
}