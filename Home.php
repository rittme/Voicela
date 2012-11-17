<?php 
class Home extends Controller {

        function GET() {
            $db = new MysqliDb($this->config["host"], $this->config["user"], $this->config["pass"], $this->config["base"]);
            $results = $db->get('VIP');
            if(!empty($results) && count($results) > 0) {            
                SimplestView::render('index',array("results" => $results));
            }
        }
    }
