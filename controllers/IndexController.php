<?php

class IndexController extends Controller {

	private $pageTpl = '/views/main.tpl.php';
	private $error = array();
	private $success = '';

	public function __construct() {
		$this->model = new IndexModel();
		$this->view = new View();
	}


	public function index() {
        $data = array();

        $data['title'] = "Список задач";

        if($_SESSION['success']){
            $data['success'] = $_SESSION['success'];
            unset($_SESSION['success']);
        } else {
            $data['success'] = $this->success;
        }

        $data['isLogged'] = $this->model->isLogged();

        $data['sort'] = $sort = $_GET['sort']??'id';
        $data['order'] = $order = $_GET['order']??'ASC';
        $page = $_GET['page']??1;
        $limit = 3;

        $url ='';
        if (isset($_GET['page'])) {
            $url .= '&page=' . $_GET['page'];
        }
        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        $data['sort_name'] = '?sort=name' . $url;
        $data['sort_email'] = '?sort=email' . $url;
        $data['sort_completed'] = '?sort=completed' . $url;

        $filter_data = array(
            'sort'               => $sort,
            'order'              => $order,
            'start'              => ($page - 1) * $limit,
            'limit'              => $limit
        );

        $totalTasks = $this->model->getTotalTasks();
        $data['tasks'] = $this->model->getTasks($filter_data);

        $url = '?sort=' . $sort.'&order=' . $order;

        $pagination = new Pagination();
        $pagination->total = $totalTasks;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->url = $url . '&page={page}';

        $data['pagination'] = $pagination->render();

		$this->view->render($this->pageTpl, $data);
	
	}

    public function addTask() {

        if (($_SERVER['REQUEST_METHOD'] == 'POST')) {

            if(isset($_POST['name'])&&$_POST['name']){
                $name = $_POST['name'];
            } else {
                $name ='';
            }
            if(isset($_POST['email'])&&$_POST['email']){
                $email = $_POST['email'];
            } else {
                $email ='';
            }
            if(isset($_POST['text'])&&$_POST['text']){
                $text = $_POST['text'];
            } else {
                $text ='';
            }
            if(isset($_POST['completed'])&&$_POST['completed']){
                $completed = 1;
            } else {
                $completed = 0;
            }
            $addTask_data = array(
                'name' => $name,
                'email' => $email,
                'text' => $text,
                'completed' => $completed
            );
            $this->model->addTask($addTask_data);

            $this->success = $data['title'] = "Задача добавлена";
        }
        $this->index();
    }

    public function changeStatus() {


	    $json =array();

	    if (!$this->model->isLogged()) {

            $json['error'] = "Вы не авторизированны!";

        } elseif (($_SERVER['REQUEST_METHOD'] == 'POST')) {

            if(isset($_POST['taskid'])&& isset($_POST['completed'])){
                $this->model->changeStatus($_POST);
                $json['success'] = "1";
            } else {
                $json['error'] = "Ошибка!";
            }

        }

        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public function changeText() {
	    $json =array();

	    if (!$this->model->isLogged()) {

            $json['error'] = "Вы не авторизированны!";

        } elseif (($_SERVER['REQUEST_METHOD'] == 'POST')) {

            if(isset($_POST['taskid'])&& isset($_POST['text'])){
                $this->model->changeText($_POST);
                $json['success'] = "1";
            } else {
                $json['error'] = "Ошибка!";
            }

        }

        header('Content-Type: application/json');
        echo json_encode($json);
    }


}