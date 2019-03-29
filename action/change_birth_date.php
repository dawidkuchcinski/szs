<?php 

    $data_urodzenia = $_POST['data_porodu'];
    $data_krycia = $_POST['data_krycia'];
    $id = $_POST['id'];

    require_once "../DBManager.php";
    session_start();

    //echo $data_urodzenia;

    $link = connect();

    if(isset($data_urodzenia) && $data_urodzenia>$data_krycia)
    {
        $query = "update krycia set data_porodu='".$data_urodzenia."' where id=".$id;
        if($check = $link -> query("update krycia set data_porodu='".$data_urodzenia."' where id=".$id))
        {
            header("Location: /sztuka.php?id=".$id."");
        }
        else {
            header("Location: /sztuka.php?id=".$id."");
        }
    }
    else {
        header("Location: /sztuka.php?id=".$id."");
    }

?>