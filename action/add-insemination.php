<?php 

    $id_lochy = $_POST['nr_maciory'];
    $rasa = $_POST['rasa'];
    $data_krycia = $_POST['data_krycia'];
    $data_prawdopodobnego_porodu = new Datetime($data_krycia);
    $data_prawdopodobnego_porodu->add(new DateInterval('P117D'));

    require_once "../DBManager.php";
    session_start();

    //echo $data_urodzenia;

    $link = connect();

    if($insert = $link -> query("insert into krycia values (NULL, $id_lochy, '$data_krycia', '".$data_prawdopodobnego_porodu->format('Y-m-d')."', '0', 0, 0, '$rasa')")) {
        header("Location: /trzoda.php");
    }
    else {
        header("Location: /trzoda.php");
    }

?>