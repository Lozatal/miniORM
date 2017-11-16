<?php

namespace peopleapp\utils;

class HttpRequest extends AbstractHttpRequest {
        
	public function __construct(){
		if (isset($_SERVER)){
			$this->script_name = $_SERVER['SCRIPT_NAME']; 
			if (isset($_SERVER['PATH_INFO'])){
				$this->path_info = $_SERVER['PATH_INFO']; 
			}
			$this->root = dirname($_SERVER['SCRIPT_NAME'],1);
    			$this->method = $_SERVER['REQUEST_METHOD']; 
			$this->get = $_GET;
			$this->post = $_POST;
		}
	}
}
