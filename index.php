<?php
    require_once('glue.php');
    require_once('mysqlibd.php');
    require_once('simplestview.php');
    require_once('config.php');
    $urls = array(
        '/' => 'index',
        '/vip/(\d+)' => 'vip',
        '/film/(\d+)' => 'film',
        '/photo/(\d+)' => 'photo',
    );
    class index {
        function GET() {
            $db = new MysqliDb($config["host"], $config["user"], $config["pass"], $config["base"]);
            $results = $db->get('VIP');
            if(!empty($results) && count($results) > 0) {            
                SimplestView::print('index',array($result));
            }
        }
    }

    class vip {
        function GET($matches) {
            if ($matches[1]) {
                $db = new MysqliDb($config["host"], $config["user"], $config["pass"], $config["base"]);
                $results = $db->where('idVIP',$matches[1])->get('VIP',1);
                if(!empty($results) && count($results) > 0) {            
                    SimplestView::print('vip',array($result));
                }
            }
        }
    }

    class film {
        function GET($matches) {
            if ($matches[1]) {
                $db = new MysqliDb($config["host"], $config["user"], $config["pass"], $config["base"]);
                $results = $db->where('idfilm',$matches[1])->get('film',1);
                if(!empty($results) && count($results) > 0) {            
                    SimplestView::print('film',array($result));
                }
            }
        }
    }

    class photo {
        function GET($matches) {
            if ($matches[1]) {
                $db = new MysqliDb($config["host"], $config["user"], $config["pass"], $config["base"]);

                $results = $db->where('idphoto', $matches[1])
                              ->get('photo',1);

                if(!empty($results) && count($results) > 0) {
                    $finfo = new finfo(FILEINFO_MIME);
                    header("Content-Type: ". $finfo->buffer($results[0]["contenu"]));
                    header("Content-Length: " . strlen($results[0]["contenu"]));
                    echo $results[0]["contenu"];
                }
            }
        }
    }
    glue::stick($urls);
?>