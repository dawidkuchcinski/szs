<?php 

    @$id_stada = $_GET['id'];

    require_once "../DBManager.php";
    session_start();

    //echo $data_urodzenia;

    $link = connect();

    if(isset($id_stada) && $rslt = $link->query("SELECT * from Trzoda where id=$id_stada"))
    {
        $rw = $rslt->fetch_array();
        $query = "insert into Trzoda values (NULL, ".get_first_available_number().", '".$rw['data_urodzenia']."', '0', 0, '".get_herd_nr_without_and()."')";
        if($link->query($query))
        {
            $ilosc_w_stadzie = $rw['ilosc_w_stadzie']-1;
            $query = "update Trzoda set ilosc_w_stadzie=$ilosc_w_stadzie where id=$id_stada";
            if($link->query($query))
            {
                header("Location: /trzoda.php");
            }
            else
            {
                echo $query;
            }
        }
        else {
            //echo $query;
            header("Location: /trzoda.php");
        }
    }
    else {
        header("Location: /trzoda.php");
        //echo $id_stada;
    }

?>