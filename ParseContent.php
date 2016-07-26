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
        $dbPageConceptsId = array();
        $db->SQL("SELECT concept_id FROM page_concept WHERE page_code=?",$page);
        while ($row = $db->nextRow()) {
            array_push($dbPageConceptsId, $row['concept_id']);
        }
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
            $sql = "SELECT id,concept,class,year_start,year_end FROM Concepts WHERE";
            foreach (self::$pageConceptsId as $pc) {
                if ($or) {
                    $sql .= ' OR';
                }
                $or = true;
                $sql .= ' id=' . $pc;
            }
            $db->SQL($sql);
            $relatedConcepts = array();
            while ($row = $db->nextRow()) {
                array_push($relatedConcepts, $row);
            }
            return $relatedConcepts;
        }
        else
            return null;
    }

    public static function getConceptContent(&$page)
    {
        $page::$db->SQL("SELECT c1.id, c1.concept,c1.year_start,c1.year_end, t.theses, t.page_code FROM Theses t, Concepts c1 WHERE t.concept_id=? AND c1.id=? ORDER BY t.year_start",$page->article,$page->article);
        while($row = $page::$db->nextRow()) {
            array_push($page->dat, $row);
        }
        $i = 0;
        foreach ($page->dat as $row) {
            $page->dat[$i]['theses'] = ParseContent::parseConcept($row['theses'], $row['year_start']-30, $row['year_end']+40, $page::$db);
            foreach ($page->concept_id_in_these as $cid) {
                if (!in_array($cid, $page->concept_id)) {
                    array_push($page->concept_id, $cid);
                    $page::$db->SQL("SELECT p.caption, t.page_code FROM pages p, Theses t WHERE t.concept_id=?", $cid);
                    array_push($page->pages, $page::$db->nextRow());
                }
            }
            $i++;
        }
        $page::$db->SQL("SELECT pc.page_code, p.caption FROM pages p, page_concept pc WHERE pc.concept_id=? AND pc.page_code=p.code",$page->article);
        while ($row = $page::$db->nextRow()) {
            array_push($page->conceptPages, $row);
        }
        $page->relatedConcepts = ParseContent::getRelatedConcepts($page::$db, $page->article);
        if ($page->relatedConcepts) {
            foreach ($page->relatedConcepts as $row) {
                switch ($row['class']) {
                    case 'person':
                        array_push($page->personConcepts, $row);
                        break;
                    case 'action':
                        array_push($page->actionConcepts, $row);
                        break;
                    case 'institution':
                        array_push($page->institutionsConcepts, $row);
                        break;
                    case 'document':
                        array_push($page->documentConcepts, $row);
                        break;
                }
            }
        }
    }
}