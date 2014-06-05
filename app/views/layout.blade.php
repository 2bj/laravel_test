<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Тестовое задание</title>

    <!-- Bootstrap core CSS -->
    <?php /* <link href="/bootstrap/bootstrap.min.css" rel="stylesheet"> */ ?>
    {{ HTML::style('/bootstrap/bootstrap.min.css') }}

    <!-- Custom styles for this template -->
    <?php /* <link href="/bootstrap/jumbotron-narrow.css" rel="stylesheet"> */ ?>
    {{ HTML::style('/bootstrap/jumbotron-narrow.css') }}


    {{ HTML::style('/bootstrap/font-awesome.min.css') }}

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>{ HTML::style('/bootstrap/ie8-responsive-file-warning.js') }}<![endif]-->

    {{ HTML::script('/js/jquery-1.11.1.min.js') }}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">
    <div class="header">
        <ul class="nav nav-pills pull-right">
            <li class="<?php echo ($activeMenu == 'form') ? 'active' : false; ?>"><a href="/">Форма</a></li>
            <li class="<?php echo ($activeMenu == 'admin') ? 'active' : false; ?>"><a href="/backend/">Админка</a></li>
        </ul>
        <h3 class="text-muted">База анкет</h3>
    </div>

    @yield('content')


</div> <!-- /container -->

</body>
</html>
