<?php

Class Controller {

	protected $config;

	public function __construct(){
		require_once('config.php');
		$this->config = $config;
	}
	

}