<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $data['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/style.css">
</head>
<body>
	
	<header></header>

	<div id="content">
		<div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">

                <?php if ($data['success']) { ?>
                    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $data['success']; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php } ?>

                </div>
            </div>
            <?php if(!$data['isLogged']) { ?>
                <div class="row">

                    <div class="col-sm-6 col-md-4 col-md-offset-4">
                        <a class="btn btn-lg btn-primary btn-block" href="/login">Sign in</a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">

                    <div class="col-sm-6 col-md-4 col-md-offset-4">
                        <a class="btn btn-lg btn-primary btn-block" href="/login/logout">Sign out</a>
                    </div>
                </div>
            <?php } ?>
            <div class="row task">
                <div class="col-sm-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                            <?php if ($data['sort'] == 'name') { ?>
                                <a href="<?php echo $data['sort_name']; ?>" class="<?php echo strtolower($data['order']); ?>">имя пользователя</a>
                            <?php } else { ?>
                                <a href="<?php echo $data['sort_name']; ?>">имя пользователя</a>
                            <?php } ?>
                            </th>
                            <th>
                            <?php if ($data['sort'] == 'email') { ?>
                                <a href="<?php echo $data['sort_email']; ?>" class="<?php echo strtolower($data['order']); ?>">email</a>
                            <?php } else { ?>
                                <a href="<?php echo $data['sort_email']; ?>">email</a>
                            <?php } ?>
                            </th>
                            <th>текст задачи</th>
                            <th><?php if ($data['sort'] == 'completed') { ?>
                                    <a href="<?php echo $data['sort_completed']; ?>" class="<?php echo strtolower($data['order']); ?>">статус</a>
                                <?php } else { ?>
                                    <a href="<?php echo $data['sort_completed']; ?>">статус</a>
                                <?php } ?>
                            </th>
                        </tr>
                        </thead>
                        <tbod
                        <?php foreach($data['tasks'] as $task) { ?>
                            <tr>
                                <td><?php echo $task['name']; ?></td>
                                <td><?php echo $task['email']; ?></td>
                                <td>
                                    <?php if($data['isLogged']) { ?>
                                        <textarea class="form-control" rows="3" data-taskId="<?php echo $task['id']; ?> name="text" placeholder="Текст задачи" required><?php echo $task['text']; ?></textarea>
                                        <button type="submit" class="btn btn-primary save">save</button>
                                    <?php } else {?>
                                        <?php echo $task['text']; ?>
                                    <?php } ?>
                                </td>
                                <td>

                                    <?php if($data['isLogged']) { ?>
                                        <?php if($task['completed']==1){ ?>
                                            <input type="checkbox" data-taskId="<?php echo $task['id']; ?>" checked class="form-check-input сheckstatus" name="completed">
                                        <?php } else {?>
                                            <input type="checkbox" data-taskId="<?php echo $task['id']; ?>" class="form-check-input сheckstatus" name="completed">
                                        <?php } ?><br>
                                        <?php if($task['completed']){ ?>
                                            Выполнено<br>
                                        <?php } ?>
                                        <?php if($task['edited']==1){ ?>
                                            Отредактировано администратором
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php if($task['completed']){ ?>
                                            Выполнено<br>
                                        <?php } ?>
                                    <?php }  ?>

                                </td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>

                </div>
            </div>
            <?php if($data['pagination']) { ?>
            <div class="row addtask">
                <div class="col-sm-12">
                    <?php echo $data['pagination']; ?>
                </div>
            </div>
            <?php } ?>

                <div class="row addtask">
                    <div class="col-sm-12">
                        <h2 class="text-center login-title">Добавить задачу</h2>
                    </div>
                </div>
                <div class="row addtask">
                    <div class="col-sm-12">
                        <form class="form-addtask" action="/index/addTask" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group">
                                <label for="inputName">Введите имя пользователя</label>
                                <input type="text" class="form-control" id="inputName" name="name" placeholder="Имя пользователя" required>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Введите email</label>
                                <input type="email" class="form-control" id="inputEmail" name="email" placeholder="email" required>
                            </div>
                            <div class="form-group">
                                <label for="inputText">Введите текст задачи</label>
                                <textarea class="form-control" id="inputText" rows="3" name="text" placeholder="Текст задачи" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Добавить задачу</button>
                        </form>
                    </div>
                </div>

        </div>
	</div>

	<footer>

	</footer>

	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.min.js"></script>
    <script>
        $('.save').on('click',function(){

            taskid = $(this).prev().data('taskid');
            text = $(this).prev().val();
            node = this;
            $.ajax({
                url: '/index/changeText',
                type: 'post',
                data: {'taskid':taskid,'text':text},
                dataType: 'json',
                success: function(json) {
                    if(json['success']){
                        $(node).after('<i class="icon-ok icon-2x"></i>');
                        setTimeout(function(){
                            $('.icon-ok').remove();
                        }, 2000);
                    } else if(json['error']){
                        location = '/login';
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });

        $('.сheckstatus').on('change',function(){
            if($(this).is(':checked')){
                completed = 1;
            } else {
                completed = 0;
            }
            taskid = $(this).data('taskid');
            node = this;
            $.ajax({
                url: '/index/changeStatus',
                type: 'post',
                data: {'taskid':taskid,'completed':completed},
                dataType: 'json',
                success: function(json) {
                    if(json['success']){
                        $(node).after('<i class="icon-ok icon-2x"></i>');
                        setTimeout(function(){
                            $('.icon-ok').remove();
                        }, 2000);
                    } else if(json['error']){
                        location = '/login';
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });
    </script>

</body>
</html>