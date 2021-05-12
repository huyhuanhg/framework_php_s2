<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Client layout</title>
    <link rel="stylesheet" href="<?= __WEB_ROOT ?>/public/assets/clients/css/root.css">
</head>
<body>
<?php
$this->render('blocks/header');
?>
<div><p>
        <?php
        $this->render('home/register', [
            'title' => 'Register Page',
            'msg' => $msg ?? [],
            "cur" => $cur ?? []
        ]);
        ?>
    </p></div>
<?php
$this->render('blocks/footer');
?>
</body>
</html>