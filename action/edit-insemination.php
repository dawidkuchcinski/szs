<?php 

    @$id_maciory = $_POST['id_maciory'];
    $data_urodzenia = $_POST['data_oproszenia'];
    @$ilosc_w_stadzie = $_POST['ilosc_w_stadzie'];
    @$ilosc_martwych = $_POST['ilosc_martwych'];
    @$id_krycia = $_POST['id_krycia'];


    require_once "../DBManager.php";
    session_start();

    //echo $data_urodzenia;

    $link = connect();

    if(isset($data_urodzenia) && isset($ilosc_w_stadzie) && isset($ilosc_martwych))
    {
        $query = "update krycia set data_porodu='$data_urodzenia', liczba_w_miocie=$ilosc_w_stadzie, liczba_martwych=$ilosc_martwych where id=$id_krycia";
        if($link->query($query))
        {
            $query = "insert into Trzoda values (NULL, ".get_swine_nr($id_maciory).", '$data_urodzenia', 0, $ilosc_w_stadzie, '".get_herd_nr_without_and()."');";
            if($link->query($query))
            {
                //echo "dodano";
                header("Location: /trzoda.php");
            }
            else {
                //echo $query;
                header("Location: /trzoda.php");
            }
        }
        else {
            //echo $query;
            header("Location: /trzoda.php");
        }
    }
    else {
        header("Location: /trzoda.php");
    }

?>