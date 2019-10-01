<?php

if (isset($_POST['uid']) && isset($_POST['key1'])) {
    
    if ($_POST['uid'] == "<USERNAME>" && 
    password_verify($_POST['key1'], '<GENERATED_PASSWORD>')) {
        $_SESSION['auth'] = true;
        header('location: /s/admin');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/skeleton.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <div>
            <input type="text" name="uid" placeholder="UID">
            </div>
            <div><input type="password" name="key1" placeholder="Key-1"></div>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>