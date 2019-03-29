<?php 

    $vaccine_name = $_POST['nazwa_szczepionki'];
    $grace_peroid = $_POST['dlugosc_karencji'];
    $time_to_inoculating = $_POST['czas_do_ponownego_zaszczepienia'];
    $description = $_POST['opis'];

    require_once "../DBManager.php";
    session_start();

    //echo $data_urodzenia;

    $link = connect();

    if($insert = $link -> query("insert into Szczepionki values (NULL, '$vaccine_name', $grace_peroid, $time_to_inoculating, '$description')")) {
        header("Location: /szczepionki.php");
    }
    else {
        header("Location: /szczepionki.php");
    }

?>