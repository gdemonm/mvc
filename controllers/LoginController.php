<?php

class LoginController extends Controller {

	private $pageTpl = '/views/login.tpl.php';
	private $error = array();

	public function __construct() {

		$this->view = new View();
        $this->loginmodel = new LoginModel();
	}


	public function index() {

        if ($this->loginmodel->isLogged()) {
            header("Location: /");
            exit();
        }

        $data = array();

		if (($_SERVER['REQUEST_METHOD'] == 'POST')&&isset($_POST['login'])&& isset($_POST['password'])) {
            $this->validate();
		}

        $data['title'] = "Авторизация пользователя";

		

        $data['warning'] = $this->error['warning']??'';
        $data['login'] = $_POST['login']??'';
        $data['password'] = $_POST['password']??'';
        
		
		$this->view->render($this->pageTpl, $data);
	
	}

	protected function validate() {

		if (!$this->loginmodel->login($_POST['login'], $_POST['password'])) {
			$this->error['warning'] = 'Ошибка авторизации';
		} else {
            $_SESSION['success'] = "Вы успешно авторизированы";
        }

		return !$this->error;
	}

    public function logout() {

	    unset($_SESSION['user_id']);
        header("Location: /");
        exit();

	}

}