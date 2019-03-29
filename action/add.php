<?php 

    @$nr_kolczyka = $_POST['nr_maciory'];
    @$nr_maciory_matki = $_POST['nr_maciory_matki'];
    $data_urodzenia = $_POST['data_przybycia'];
    @$ilosc_w_stadzie = $_POST['typ'];

    require_once "../DBManager.php";
    session_start();

    //echo $data_urodzenia;

    $link = connect();

    if(isset($data_urodzenia))
    {
        if(Empty($ilosc_w_stadzie))
        {
            $query = "SELECT id from Trzoda where nr_kolczyka=$nr_kolczyka and ilosc_w_stadzie=0 ".get_herd_nr();
            if($check = $link -> query("SELECT id from Trzoda where nr_kolczyka=$nr_kolczyka and ilosc_w_stadzie=0 ".get_herd_nr()))
            {
                $rw = $check -> num_rows;
        
                if($rw===0)
                {
                    if($insert = $link -> query("insert into Trzoda values (NULL, $nr_kolczyka, '$data_urodzenia', '0', 0, '".get_herd_nr_without_and()."')")) {
                        header("Location: /trzoda.php");
                    }
                    else {
                        header("Location: /trzoda.php");
                    }
                }
                else {
                    header("Location: /trzoda.php");
                }
    
            }
            else {
                header("Location: /trzoda.php");
            }
        }
        else {
            if($insert = $link -> query("insert into Trzoda values (NULL, $nr_maciory_matki, '$data_urodzenia', '0', $ilosc_w_stadzie, '".get_herd_nr_without_and()."')")) {
                header("Location: /trzoda.php");
            }
        }
    }
    else {
        header("Location: /trzoda.php");
    }

?>