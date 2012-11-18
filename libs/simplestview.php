<?php
/**
 * SimplestView Class
 *
 * @category Simple view
 * @package SimplestView
 * @author Bernardo Rittmeyer <bernardo@rittme.com>
 * @copyright Copyright (c) 2012
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version 0.5
 **/
Class SimplestView {

	public static function render($page,$data = false, $return = false){
		if(!is_file("./view/".$page.".php")){
			$page = "404";
		}
		if(!empty($data) && is_array($data)){
			extract($data);
		}
		if($return === TRUE) {
			ob_start();
		}
		require_once SYS."/view/".$page.".php";
		if($return === TRUE) {
			ob_get_clean();
		}
	}

}