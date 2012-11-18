<?php
    define('SYS',getcwd());
    
    require_once('./libs/glue.php');
    require_once('./libs/mysqlidb.php');
    require_once('./libs/simplestview.php');
    require_once('./Controller.php');

    $test = false;
    if($test = true) {
        define('SITE_URL',"http://localhost/voicela/");
        
        $urls = array(
            '/voicela/index.php' => 'home',
            '/voicela/' => 'home',
            '/voicela/vip/(\d+)' => 'vip',
            '/voicela/films' => 'films',
            '/voicela/film/(\d+)' => 'film',
            '/voicela/photo/(\d+)' => 'photo',
        );
    } else {
        define('SITE_URL',"http://voicela.pagodabox.com/");

        $urls = array(
            '/index.php' => 'home',
            '/' => 'home',
            '/vip/(\d+)' => 'vip',
            '/films' => 'films',
            '/film/(\d+)' => 'film',
            '/photo/(\d+)' => 'photo',
        );

    }

    class Home extends Controller {

        function GET() {
            $db = new MysqliDb($this->config["host"], $this->config["user"], $this->config["pass"], $this->config["base"]);
            $results = $db->query('SELECT * from VIP ORDER BY prenom,nom;');
            
            if(!empty($results) && count($results) > 0) {       
                SimplestView::render("header");     
                SimplestView::render('index',array("results" => $results));
                SimplestView::render("footer");
            }
        }
    }

    class vip extends Controller {
        function GET($matches) {
            if ($matches[1]) {
                $data = array();
                $db = new MysqliDb($this->config["host"], $this->config["user"], $this->config["pass"], $this->config["base"]);
                $result = $db->where('idVIP',$matches[1])->get('VIP',1);
                $realisateur = $db->where('realisateur',$matches[1])->get('film');

                $params = array($matches[1]);
                $acteur = $db->rawQuery("SELECT * FROM joue, film WHERE joue.idfilm = film.idfilm AND joue.idVIP = ?", $params);
                $photo  = $db->rawQuery("SELECT photo.idphoto, photo.lieu, photo.date_prise, photo.description FROM vip_photo, photo WHERE photo.idphoto = vip_photo.idphoto AND vip_photo.idVIP = ?", $params);
                $date = "0000-00-00";
                $params2 = array($date,$matches[1],$matches[1]);
                $mariage  = $db->rawQuery("SELECT * FROM mariage WHERE (date_fin = ? OR date_fin IS NULL) AND (mari = ? OR epouse = ? );", $params2);
                
                if(!empty($mariage) && count($mariage) > 0) {
                    if(strtolower($result[0]["sexe"]) == "f") {
                        $conjoint = $db->where('idVIP',$mariage[0]['mari'])->get('VIP',1);
                    } else {
                        $conjoint = $db->where('idVIP',$mariage[0]['epouse'])->get('VIP',1);
                    }
                }
                $divorces = $db->rawQuery("SELECT * FROM mariage WHERE (date_fin != ? AND date_fin IS NOT NULL) AND (mari = ? OR epouse = ? ) ORDER BY date_fin DESC;", $params2);
                if(!empty($divorces) && count($divorces) > 0) {
                    $data["conjoints_divorces"] = array();
                    if(strtolower($result[0]["sexe"]) == "f") {
                        foreach($divorces as $d) 
                            $data["conjoints_divorces"][] = $db->where('idVIP',$d['mari'])->get('VIP',1);
                    } else {
                        foreach($divorces as $d) 
                            $data["conjoints_divorces"][] = $db->where('idVIP',$d['epouse'])->get('VIP',1);
                    }
                }
                
                $data["vip"]         = $result[0];
                $data["acteur"]      = $acteur;
                $data["realisateur"] = $realisateur;
                if(!empty($photo))
                    $data["photo"]       = $photo;
                if(!empty($mariage))
                    $data["mariage"]     = $mariage;
                if(!empty($conjoint[0]))
                    $data["conjoint"]    = $conjoint[0];
                if(!empty($divorces))
                    $data["divorces"]    = $divorces;

                if(!empty($result) && count($result) > 0) {      
                    SimplestView::render("header");      
                    SimplestView::render('vip',$data);
                    SimplestView::render("footer");
                }
            }
        }
    }

    class film extends Controller{
        function GET($matches) {
            if ($matches[1]) {
                $db = new MysqliDb($this->config["host"], $this->config["user"], $this->config["pass"], $this->config["base"]);
                $result = $db->where('idfilm',$matches[1])->get('film',1);
                if(!empty($result) && count($result) > 0) { 
                    SimplestView::render("header");           
                    SimplestView::render('film',array("film" => $result[0]));
                    SimplestView::render("footer");
                }
            }
        }
    }

    class films extends Controller{
        function GET() {
                $db = new MysqliDb($this->config["host"], $this->config["user"], $this->config["pass"], $this->config["base"]);
                $results = $db->query('SELECT * from film ORDER BY titre;');
                if(!empty($results) && count($results) > 0) {            
                    SimplestView::render("header");
                    SimplestView::render('films',array("results"=>$results));
                    SimplestView::render("footer");
            }
        }
    }

    class photo extends Controller {
        function GET($matches) {
            if ($matches[1]) {
                $db = new MysqliDb($this->config["host"], $this->config["user"], $this->config["pass"], $this->config["base"]);

                $params = array($matches[1]);
                $results = $db->rawQuery("SELECT contenu FROM photo WHERE idphoto = ? LIMIT 1;", $params);
                $results = $db->where('idphoto', $matches[1])
                              ->get('photo',1);

                if(!empty($results) && count($results) > 0) {
                    
                    header("Content-Type: image/jpg");
                    header("Content-Length: " . strlen($results[0]["contenu"]));
                    echo $results[0]["contenu"];
                }
            }
        }
    }
    glue::stick($urls);

    function site_url($url = false){
    if(empty($url)){
        return SITE_URL;
    } else {
        return SITE_URL.$url;
    }
}
?>