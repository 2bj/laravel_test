<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Добавлена новая анкета на сайт</h2>

<div>На сайт добавлена новая анкета. Для её редактирования перейдите по ссылке {{ URL::to('backend/form/', array($model->id)) }}
</div>
</body>
</html>
