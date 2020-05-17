<?php

class Routing {

	public static function buildRoute() {

		/*Контроллер и action по умолчанию*/
		$controllerName = "IndexController";
		$modelName = "IndexModel";
		$action = "index";

		$route = explode("/", trim(strtok($_SERVER['REQUEST_URI'],'?'),'/'));

		foreach ($route as $key => $rout){
		    if(strpos('?',$rout)===true){
		        unset($route[$key]);
            }
        }

		/*Определяем контроллер*/
		if($route[0] != '') {
			$controllerName = ucfirst($route[0]. "Controller");
			$modelName = ucfirst($route[0]. "Model");
		}

		require_once CONTROLLER_PATH . $controllerName . ".php";
		require_once MODEL_PATH . $modelName . ".php";

		if(isset($route[1]) && $route[1] !='') {
			$action = $route[1];
		}

		$controller = new $controllerName();
		$controller->$action();

	}

	public function errorPage() {

	}


}