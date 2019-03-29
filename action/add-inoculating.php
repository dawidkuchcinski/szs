<?php 

    $id_lochy = $_POST['id_maciory'];
    $id_szczepionki = $_POST['id_szczepionki'];
    $data_szczepienia = $_POST['data_szczepienia'];

    require_once "../DBManager.php";
    session_start();

    //echo $data_urodzenia;

    $link = connect();

    if($insert = $link -> query("insert into szczepienia values (NULL, $id_lochy, '$data_szczepienia', $id_szczepionki)")) {
        header("Location: /trzoda.php");
    }
    else {
        header("Location: /trzoda.php");
    }

?>