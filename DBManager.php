<?php
function connect() {
    $mysqli = new mysqli("host", "user", "password", "db");
    if ($mysqli -> connect_errno)
    {
        echo "Failed to connect to DB: " . $mysqli -> connect_errno;
    }
    else
    {
        /* change character set to utf8 */
        if (!$mysqli->set_charset("utf8")) {
            printf("Error loading character set utf8: %s\n", $mysqli->error);
            exit();
        } else {
            //printf("Current character set: %s\n", $mysqli->character_set_name());
            return $mysqli;
        }
    } 
}

/*function show_users() {
    $link = connect();
    $result = $link -> query("SELECT * from uzytkownicy");
    $row = $result -> fetch_row();
    echo $row[1];
}*/

function log_in($login, $passwd) {
    $link = connect();
    if($rslt = $link -> query("SELECT * from uzytkownicy where login='$login' and haslo='$passwd'"))
    {
        $row_count = $rslt -> num_rows;

        if($row_count===1)
        {
            session_start();
            $_SESSION['user_id']=$login;
            //echo "Zalogowano";
            //echo "<a href='../index.php'>Strona główna</a>";
            header("Location: /index.php");
        }
        else
        {
            echo "błąd emaila, bądź hasła";
        }

    }
}

function check_if_login_exist($login) {
    $link = connect();
    if($rslt = $link -> query("SELECT id from uzytkownicy where login='$login'"))
    {
        $row_count = $rslt -> num_rows;

        if($row_count===1)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

}

function get_herd_nr() {
    $link = connect();
    if($rslt = $link -> query("SELECT nr_siedziby_stada from uzytkownicy where login='".$_SESSION['user_id']."'"))
    {
        $rws = $rslt -> fetch_array();
        return "and nr_siedziby_stada='".$rws[0]."'";
    }
}

function get_all_vaccines_select_list() {
    $link = connect();
    if($rslt = $link -> query("SELECT id, nazwa from Szczepionki"))
    {
        while($rw = $rslt->fetch_array())
        {
            ?>
                <option value="<?php echo $rw['id']; ?>"><?php echo $rw['nazwa'] ?></option>
            <?
        }
    }
}

function get_herd_nr_without_and() {
    $link = connect();
    if($rslt = $link -> query("SELECT nr_siedziby_stada from uzytkownicy where login='".$_SESSION['user_id']."'"))
    {
        $rws = $rslt -> fetch_array();
        return $rws[0];
    }
} 

function get_name_and_surname($login) {
    $link = connect();
    if($rslt = $link -> query("SELECT imie, nazwisko, nr_siedziby_stada from uzytkownicy where login='$login'"))
    {
        $rws = $rslt -> fetch_array();
        $names = $rws[0]." ".$rws[1]."<br>".$rws[2];
        return $names;
    }
}

function get_first_available_number() {
    $link = connect();

    $number=1;

    while($number!=20)
    {
        //$query = "select nr_kolczyka from Trzoda where nr_kolczyka=".$number." and data_zbycia=0 and znacznik_maciory='M' ".get_herd_nr();
        //echo $query."<br>";
        if($rslt = $link -> query("select nr_kolczyka from Trzoda where nr_kolczyka=".$number." and data_zbycia=0 and ilosc_w_stadzie=0 ".get_herd_nr()))
        {
            $rw = $rslt -> num_rows;
            if($rw===0)
            {
                return $number;
            }
        }
        $number++;
    }
}

function get_actual_sows() {
    $link = connect();
    if($rslt = $link -> query("select * from Trzoda where data_zbycia=0 and ilosc_w_stadzie=0 ".get_herd_nr()." order by nr_kolczyka asc"))
    {
        while($rw = $rslt -> fetch_array())
        {
            ?>
                <tr class='clickable-row' data-href='sztuka.php?id=<?php echo $rw['id'] ?>'>
                    <th scope="row"><?php echo $rw['nr_kolczyka'] ?></th><th><?php echo $rw['data_urodzenia'] ?></th><th><?php echo latest_event($rw['id']); ?></th>
                </tr>
            <?php
        }
    }
}

function get_actual_swines() {
    $link = connect();
    if($rslt = $link -> query("select * from Trzoda where data_zbycia=0 and ilosc_w_stadzie>0 ".get_herd_nr()." order by id asc"))
    {
        while($rw = $rslt -> fetch_array())
        {
            ?>
                <tr class='clickable-row' data-href='sztuka.php?id=<?php echo $rw['id'] ?>'>
                    <th scope="row"><?php echo $rw['nr_kolczyka'] ?></th><th><?php echo $rw['id'] ?></th><th><?php echo $rw['data_urodzenia'] ?></th><th><?php echo $rw['ilosc_w_stadzie'] ?></th><th></th>
                </tr>
            <?php
        }
    }
}

function get_actual_vaccines() {
    $link = connect();
    if($rslt = $link -> query("select * from Szczepionki order by id asc"))
    {
        while($rw = $rslt -> fetch_array())
        {
            ?>
                <tr class='clickable-row' data-href='sztuka.php?id=<?php echo $rw['id'] ?>'>
                    <th scope="row"><?php echo $rw['nazwa'] ?></th><th><?php echo $rw['okres_karencji'] ?></th><th><?php echo $rw['czas_ponownego_zaszczepienia'] ?></th><th><?php echo $rw['opis_szczepionki'] ?></th>
                </tr>
            <?php
        }
    }
}

function get_one_swine_inoculating($id) {
    $link = connect();
    if($rslt = $link -> query("select * from szczepienia inner join Szczepionki on szczepienia.id_szczepionki=Szczepionki.id where id_zwierzecia=$id order by data_szczepienia desc"))
    {
        while($rw = $rslt -> fetch_array())
        {
            $data_karencji = new Datetime($rw['data_szczepienia']);
            $data_karencji->add(new DateInterval('P'.$rw['okres_karencji'].'D'));

            $data_ponownego_szczepienia = new Datetime($rw['data_szczepienia']);
            $data_ponownego_szczepienia->add(new DateInterval('P'.$rw['czas_ponownego_zaszczepienia'].'D'));
            ?>
                <tr>
                    <th scope="row"><?php echo $rw['data_szczepienia'] ?></th><th><?php echo $rw['nazwa'] ?></th><th><?php echo $data_karencji->format('Y-m-d'); ?></th><th><?php echo $data_ponownego_szczepienia->format('Y-m-d'); ?></th>
                </tr>
            <?php
        }
    }
}

function get_one_swine_insemination($id) {
    $link = connect();
    if($rslt = $link -> query("select * from krycia where id_lochy=$id order by data_krycia desc"))
    {
        while($rw = $rslt -> fetch_array())
        {
            ?>
                <tr
                <?php
                    if($rw['data_porodu']==='0000-00-00 00:00:00')
                    {
                ?>
                 class='clickable-row' data-href='forms/krycie.php?id=<?php echo $rw['id'] ?>&dataprawpor=<?php echo $rw['data_prawdopodobnego_porodu'] ?>&idmaciory=<?php echo $id; ?>'
                <?php
                    }
                ?>
                 >
                    <th scope="row"><?php echo $rw['data_krycia'] ?></th><th><?php echo $rw['data_prawdopodobnego_porodu'] ?></th><th><?php echo $rw['data_porodu']; ?></th><th><?php echo $rw['liczba_w_miocie'] ?></th><th><?php echo $rw['liczba_martwych'] ?></th><th><?php echo $rw['rasa'] ?></th>
                </tr>
            <?php
        }
    }
}

function get_swine_nr($id) {
    $link = connect();
    if($rslt = $link -> query("select nr_kolczyka from Trzoda where id=$id"))
    {
        $rw = $rslt -> fetch_array();
        return $rw[0];
    }
}

function get_all_actual_sow_nbrs() {
    $link = connect();

    if($rslt = $link -> query("select nr_kolczyka from Trzoda where data_zbycia=0 and ilosc_w_stadzie=0 ".get_herd_nr()." order by nr_kolczyka asc"))
    {
        while($rw = $rslt -> fetch_array())
        {
            ?>
                <option value="<?php echo $rw['nr_kolczyka'] ?>"><?php echo $rw['nr_kolczyka'] ?></option>
            <?php
        }
    }
}

function latest_event($id) {
    $link = connect();
    $msg = "";
    $query = "select * from krycia where id_lochy=$id and data_prawdopodobnego_porodu BETWEEN CURDATE() and CURDATE() + INTERVAL 30 DAY";

    if($rslt = $link -> query("select * from Trzoda where id=$id"))
    {
        $rw = $rslt -> fetch_array();
        #echo $rw['ilosc_w_stadzie'];
        if($rw['ilosc_w_stadzie']==0)
        {
            #echo $query;
            #maciory
            if($rslt = $link -> query("select * from krycia where id_lochy=$id and data_prawdopodobnego_porodu BETWEEN CURDATE() and CURDATE() + INTERVAL 30 DAY"))
            {
                $rw_cnt = $rslt -> num_rows;
                #echo "ok";
                if($rw_cnt>0)
                {
                    $msg = "<p>W ciągu najbliższych 30 dni nastąpi oproszenie</p>";
                }
            }
        }
        if($rslt = $link -> query("select data_szczepienia, czas_ponownego_zaszczepienia from szczepienia inner join Szczepionki on szczepienia.id_szczepionki=Szczepionki.id where id_zwierzecia=$id"))
        {
            #echo "ok";
            while($rw = $rslt -> fetch_array())
            {
                $data_ponownego_szczepienia = new Datetime($rw['data_szczepienia']);
                $data_ponownego_szczepienia = $data_ponownego_szczepienia->add(new DateInterval('P'.$rw['czas_ponownego_zaszczepienia'].'D'));
                #echo $data_ponownego_szczepienia->format('Y-m-d')."<br>";
                $test = new Datetime();
                $test -> add(new DateInterval('P7D'));
                #echo $test->format('Y-m-d')."<br>";
                if($data_ponownego_szczepienia < $test and $data_ponownego_szczepienia > new Datetime(date("Y-m-d")))
                {
                    $msg .= "<p>W ciągu najbliższych 7 dni, będziesz musiał ponownie zaszczepić świnie</p>";
                }
            }
        }
        return $msg;
    }
}

?>