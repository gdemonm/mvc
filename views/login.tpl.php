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
                <?php if ($data['warning']) { ?>
                    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $data['warning']; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php } ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <h1 class="text-center login-title">Sign in</h1>
                    <div class="account-wall">
                        <form class="form-signin" action="/login/" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group required">
                              <input type="text" class="form-control" placeholder="login" name="login" value="<?php echo $data['login'] ?>" required autofocus>
                            </div>
                            <div class="form-group required">
                              <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo $data['password'] ?>"  required>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>

	<footer>

	</footer>

	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.min.js"></script>

</body>
</html>