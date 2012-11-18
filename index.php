<?php
    define('SYS',getcwd());
    define('SITE_URL',"http://voicela.pagodabox.com/");
    require_once('./libs/glue.php');
    require_once('./libs/mysqlidb.php');
    require_once('./libs/simplestview.php');
    require_once('./Controller.php');

    $urls = array(
        '/index.php' => 'home',
        '/' => 'home',
        '/vip/(\d+)' => 'vip',
        '/films' => 'films',
        '/film/(\d+)' => 'film',
        '/photo/(\d+)' => 'photo',
    );
    

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
                $db = new MysqliDb($this->config["host"], $this->config["user"], $this->config["pass"], $this->config["base"]);
                $result = $db->where('idVIP',$matches[1])->get('VIP',1);
                $realisateur = $db->where('realisateur',$matches[1])->get('film');

                $params = array($matches[1]);
                $acteur = $db->rawQuery("SELECT * FROM joue, film WHERE joue.idfilm = film.idfilm AND joue.idVIP = ?", $params);
                $photo  = $db->rawQuery("SELECT photo.idphoto, photo.lieu, photo.date_prise, photo.description FROM vip_photo, photo WHERE photo.idphoto = vip_photo.idphoto AND vip_photo.idVIP = ?", $params);
                
                $data = array();
                $data["vip"]         = $result[0];
                $data["acteur"]      = $acteur;
                $data["realisateur"] = $realisateur;
                $data["photo"]       = $photo;

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