<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 14.04.2016
 * Time: 12:18
 */

class ParseContent
{
    private static $pageConcepts=array(), $pageConceptsId=array();

    public static function parseConcept($content, $year_start, $year_end, $db)
    {
        $db->SQL("SELECT * FROM Concepts WHERE year_start between $year_start and $year_end or year_end between $year_start and $year_end or year_start<$year_start and year_end>$year_end");
        while ($row = $db->nextRow()) {
            $concept_case = explode(';',$row['concept_case']);
            if (preg_match('/\b'.$row['concept'].'\b[^\-]/u', $content)) {
                $content = preg_replace('/(\b)'.$row['concept'].'(\b)[^\-]/u', '<a href="/concept/'.$row['id'].'">'.$row['concept'].'</a> ', $content);
                if (!in_array($row['concept'],self::$pageConcepts)) {
                    array_push(self::$pageConcepts, $row['concept']);
                    array_push(self::$pageConceptsId, $row['id']);
                }
            }
            foreach ($concept_case as $cc) {
                if ($cc!='' && preg_match('/\b'.$cc.'\b[^\-<\/a>]/u', $content)) {
                    $content = preg_replace('/\b'.$cc.'\b[^\-<\/a>]/u', '<a href="/concept/'.$row['id'].'">'.$cc.'</a> ', $content);
                    if (!in_array($row['concept'],self::$pageConcepts)) {
                        array_push(self::$pageConcepts, $row['concept']);
                        array_push(self::$pageConceptsId, $row['id']);
                    }
                }
            }
        }
        return $content;
    }

    public static function getPageConcepts()
    {
        return self::$pageConcepts;
    }

    public static function getConceptDefinition($db)
    {
        $sql = "SELECT c.id,c.concept,t.theses,t.page_code,p.caption FROM Concepts c,Theses t,pages p WHERE";
        $or = false;
        foreach (self::$pageConcepts as $concept) {
            if ($or) {
                $sql .= ' or';
            }
            $sql .= ' t.class=\'Визначення\' and c.concept=\''.$concept.'\' and t.concept_id=(SELECT id FROM Concepts
                    WHERE concept=\''.$concept.'\') and t.page_code=p.code and p.caption=(SELECT caption FROM pages
                    WHERE code=t.page_code)';
            $or = true;
        }
        if ($or) {
            $sql .= ' ORDER BY c.year_start';
            $db->SQL($sql);
            $c = array();
            while ($row = $db->nextRow()) {
                array_push($c, $row);
            }
            return $c;
        } else
            return null;
    }

    public static function setPageConcept($page, $db)
    {
        $db->SQL("SELECT concept_id FROM page_concept WHERE page_code=?",$page);
        $dbPageConceptsId[] = $db->getColumn();
        foreach (self::$pageConceptsId as $cid) {
            if (!in_array($cid, $dbPageConceptsId)) {
                $db->SQL("INSERT INTO page_concept(page_code, concept_id) VALUES(?,?)",$page, $cid);
            }
        }
    }

    public static function getRelatedConcepts($db, $currentConceptId)
    {
        while (($i = array_search($currentConceptId, self::$pageConceptsId))!== false) {
            unset(self::$pageConceptsId[$i]);
        }
        if (self::$pageConceptsId) {
            $or = false;
            $sql = "SELECT * FROM Concepts WHERE";
            foreach (self::$pageConceptsId as $pc) {
                if ($or) {
                    $sql .= ' OR';
                }
                $or = true;
                $sql .= ' id=' . $pc;
            }
            $db->SQL($sql);
            $relatedConcepts = array();
            return function() use ($db, &$relatedConcepts) {
                while ($row = $db->nextRow()) {
                    array_push($relatedConcepts, new Concept($row));
                }
                return $relatedConcepts;
            };
        }
        else
            return null;
    }

    public static function getConceptContent(&$page)
    {
        $page::$db->SQL("SELECT c1.id, c1.concept,c1.year_start,c1.year_end, t.theses, t.page_code FROM Theses t, Concepts c1 WHERE t.concept_id=? AND c1.id=? ORDER BY t.year_start",$page->article,$page->article);
        $conceptData = $page::$db->allRows();
        $page->currentConcept = new Concept($conceptData[0]['id'], $conceptData[0]['concept'], $conceptData[0]['year_start'], $conceptData[0]['year_end']);
        foreach ($conceptData as $row) {
            $these = new These($row['theses'], $row['page_code']);
            $these->setThese(ParseContent::parseConcept($row['theses'], $page->currentConcept->getYearStart() - 30, $page->currentConcept->getYearEnd() + 40, $page::$db));
            array_push($page->currentConceptData, $these);
        }
        $page::$db->SQL("SELECT pc.page_code, p.caption FROM pages p, page_concept pc WHERE pc.concept_id=? AND pc.page_code=p.code",$page->article);
        $page->conceptPages = $page::$db->allRows();
        $page->relatedConcepts = ParseContent::getRelatedConcepts($page::$db, $page->article)->__invoke();
        if ($page->relatedConcepts) {
            foreach ($page->relatedConcepts as $row) {
                $row->separateConceptsOnClass($page);
            }
        }
    }


}