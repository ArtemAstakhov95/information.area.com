<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 09.11.2015
 * Time: 11:11
 */
include_once 'Recordset.php';
include_once 'ParseContent.php';

class Page{
    private static $host = "localhost";
    private static $dbname = "Concept";
    private static $user = "root";
    private static $pass = "";

    public static $db;
    private $id,$page_code,$caption,$intro,$content,$date, $image,$main,$parentCode,$isContainer, $view, $year_start, $year_end;
    private $filename, $admin='',$title='Історі України', $article, $dat=array(), $pages=array(), $concept_id_in_these=array(), $concept_id=array();
    private $pageConcepts=array(), $conceptPages=array(), $relatedConcepts=array();
    private $personConcepts=array(), $institutionsConcepts=array(), $actionConcepts=array(),$documentConcepts=array(),$conceptDefinition=array();
    private $minYear,$maxYear;

    public function __construct($code, $view_type, $article, $init, $data){
        $this->article = $article;
        $this->code = $code;
        $a = array();
        if($init) {

            self::$db->SQL("SELECT * FROM pages WHERE code = ?", $this->code);
            $a = self::$db->nextRow();
        }
        else{
            $a = $data;
        }
        $this->id = $a['id'];
        $this->page_code = $a['code'];
        $this->caption = $a['caption'];
        $this->intro = $a['intro'];
        $this->content = $a['content'];
        $this->date = $a['date'];
        $this->image = $a['image'];
        $this->main = $a['main'];
        $this->parentCode = $a['parentCode'];
        $this->isContainer = $a['isContainer'];
        $this->year_start = $a['year_start'];
        $this->year_end = $a['year_end'];
    }

    public function getContent(){
        $this->title = $this->caption;
        if($this->isContainer === '1') {
            $sql = '';
            if($this->page_code == 'main'){
                $this->view = 'main';
                self::$db->SQL("SELECT min(year_start),max(year_end) FROM pages");
                $m = self::$db->nextRow();
                $this->minYear = $m[0];
                $this->maxYear = $m[1];
                self::$db->SQL("SELECT c.*,cc.class as class_caption FROM Concepts c, Concept_class cc WHERE c.class=cc.code ORDER By c.year_start");
                while($row = self::$db->nextRow()){
                    switch ($row['class']) {
                        case 'person':
                            array_push($this->personConcepts, $row);
                            break;
                        case 'action':
                            array_push($this->actionConcepts, $row);
                            break;
                        case 'institution':
                            array_push($this->institutionsConcepts, $row);
                            break;
                        case 'document':
                            array_push($this->documentConcepts, $row);
                            break;
                    }
                }
                $sql = "SELECT * FROM pages WHERE isContainer=0 AND parentCode<>'main'";
            }
            else{

            }
            self::$db->SQL("SELECT * FROM pages WHERE content<>'null' ORDER BY year_start");
        }
        else{
            if($this->page_code == 'add-article'){
                $this->adminka('add');
            }
            elseif($this->page_code == 'edit-article'){
                $this->adminka('edit');
            }
            elseif($this->page_code == 'login'){
                $this->view = 'login';
            }
            elseif($this->page_code == 'concept'){
                $this->view = "concept";
                self::$db->SQL("SELECT c1.id, c1.concept,c1.year_start,c1.year_end, t.theses, t.page_code FROM Theses t, Concepts c1 WHERE t.concept_id=? AND c1.id=? ORDER BY t.year_start",$this->article,$this->article);
                while($row = self::$db->nextRow()){
                    array_push($this->dat, $row);
                }
                $i = 0;
                foreach($this->dat as $row){
                    $this->dat[$i]['theses'] = ParseContent::parseConcept($row['theses'], $row['year_start']-30, $row['year_end']+40, self::$db);
                    foreach($this->concept_id_in_these as $cid) {
                        if (!in_array($cid, $this->concept_id)) {
                            array_push($this->concept_id, $cid);

                            self::$db->SQL("SELECT p.caption, t.page_code FROM pages p, Theses t WHERE t.concept_id=?", $cid);
                            array_push($this->pages, self::$db->nextRow());
                        }
                    }
                    $i++;
                }

                self::$db->SQL("SELECT pc.page_code, p.caption FROM pages p, page_concept pc WHERE pc.concept_id=? AND pc.page_code=p.code",$this->article);
                while($row = self::$db->nextRow()){
                    array_push($this->conceptPages, $row);
                }
                $this->relatedConcepts = ParseContent::getRelatedConcepts(self::$db, $this->article);
                if($this->relatedConcepts) {
                    foreach ($this->relatedConcepts as $row) {
                        switch ($row['class']) {
                            case 'person':
                                array_push($this->personConcepts, $row);
                                break;
                            case 'action':
                                array_push($this->actionConcepts, $row);
                                break;
                            case 'institution':
                                array_push($this->institutionsConcepts, $row);
                                break;
                            case 'document':
                                array_push($this->documentConcepts, $row);
                                break;
                        }
                    }
                }
            }
            else {
                $this->view = "article";
                $this->parse_macro();
                $this->content = ParseContent::parseConcept($this->content, $this->year_start-30, $this->year_end+40, self::$db);
                $this->pageConcepts = ParseContent::getPageConcepts();
                $this->conceptDefinition = ParseContent::getConceptDefinition(self::$db);
                ParseContent::setPageConcept($this->code, self::$db);
            }
        }

        //self::$db->SQL("SELECT * FROM pages");
        $data = array();
        while ($row = self::$db->nextRow()) {
            $page = new Page($row['code'], '', '', false, $row);
            array_push($data, $page);
        }

        $this->filename = 'views/'.$this->view.'_view.php';
        return $data;
    }

    public function publish($data){
        if(file_exists($this->filename)) {
            include $this->filename;
            if(isset($_SESSION['login'])){
                if($_SESSION['login'] == 'admin'){
                    include '/views/admin_panel_view.php';
                }
            }
        }
        elseif($this->admin != ''){
            echo $this->admin;
        }
    }

    public function getTitle(){
        return $this->title;
    }

    private function parse_macro(){
        while (strpos($this->content, '~~')) {
            $macro_start = strpos($this->content, '~~');
            $this->text1 = substr($this->content, 0, $macro_start);
            $this->content = str_replace($this->text1, "", $this->content);
            $this->content = substr_replace($this->content, "", 0, 2);
            $macro_end = strpos($this->content, '~~');
            $this->text2 = substr($this->content, $macro_end + 2);
            $this->content = str_replace($this->text2, "", $this->content);
            //clear macro!!!
            $this->content = substr_replace($this->content, "", strpos($this->content, '~~'), strpos($this->content, '~~') + 2);
            //
            $open_bracket = strpos($this->content, '(');
            $this->macro_name = substr($this->content, 0, $open_bracket);
            $this->content = str_replace($this->macro_name, "", $this->content);
            $this->content = preg_replace('/\(|\)/', "", $this->content);
            $this->macro_args = explode(',', $this->content);

            $func_name = 'macro_' . $this->macro_name;
            if (method_exists($this, $func_name)) {
                $this->result = $this->$func_name($this->macro_args);
            }
            if ($this->content == 'end') {
                $this->result = '</a>';
            }
            $this->content = $this->text1 . $this->result . $this->text2;
        }
    }

    private function macro_img($args){
        $class = $args[1];
        return '<div class="content-image-div"><div class="content-image-div-center">
            <img src="/images/'.$args[0].'" class="content-image '.$class.'" style="display:block"><span class="content-image-text">'.$args[2].'</span></div></div>';
    }

    private function macro_link($args){
        return '<a target="_blank" href="'.$args[0].'">';
    }

    private function macro_video($args){
        return '<div class="video-div">'.htmlspecialchars_decode($args[0]).'</div>';
    }

/*
    private function adminka($e){
        $table = new Table('pages');
        if($e == 'edit'){
            $this->admin = $table->edit($this->article);
        }
        else{
            $this->admin = $table->add();
        }
    }
*/

}
