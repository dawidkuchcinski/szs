<?php

require_once "../DBManager.php";

$login = hash('sha256',$_POST['email']);
$passwd = hash('sha256',$_POST['password']);

log_in($login, $passwd);

?>