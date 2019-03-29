<?php

function draw_login_form() {
    ?>
        <div class="row">
            <form method="POST" action="action/login.php" class="col-lg-5 col-xs-5 center_div p-5 bg-white rounded">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Wpisz Emial" name="email" />
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Hasło" name="password" />
                </div>
                <button type="submit" class="btn btn-dark">Submit</button>
            </form>
        </div>
    <?php
}

function draw_logged_in_panel() {
    ?>
        <div class="row">
            <?php draw_menu('Strona główna'); ?>
                        
            <div class=" text-white col-lg-10 col-xs-10 h-100">
            </div>
        </div>
    <?php
}

function draw_swines_panel() {
    ?>
        <div class="row">             
            <?php draw_menu('trzoda'); ?>
                        
            <div class=" text-white col-lg-10 col-xs-10 p-3 text-center">
                <a href="/forms/dodaj-swinie.php" class="btn btn-danger">Dodaj świnię</a>
                <?php draw_actual_sow_table(); ?>
                <?php draw_actual_swines_table(); ?>
            </div>
        </div>
    <?php
}

function draw_one_swine_panel($id) {
    ?>
        <div class="row">             
            <?php 
                draw_menu('trzoda');

                $link = connect();
                $rslt = $link -> query("select * from Trzoda where id=$id");
                $rw = $rslt -> fetch_array();
            ?>
                        
            <div class=" text-white col-lg-10 col-xs-10 p-3 text-center">
                <h3>
                <?php
                    if($rw['ilosc_w_stadzie']==0) echo "Maciora nr: "; else echo "Stado o nr: ".$rw['id']." Od maciory nr: ";
                ?>
                <?php echo get_swine_nr($id); ?></h3>
                <h5>Historia szczepień</h5>
                <table class="table table-dark table-striped table-bordered text-left table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Data szczepienia</th>
                            <th scope="col">Nazwa szczepionki</th>
                            <th scope="col">Termin upływu karencji</th>
                            <th scope="col">Data ponownego szczepienia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            get_one_swine_inoculating($id) 
                        ?>
                    </tbody>
                </table>
                <?php 
                    if($rw['ilosc_w_stadzie']==0)
                    {
                 ?>
                <h5>Histroia Kryć</h5>
                <table class="table table-dark table-striped table-bordered text-left table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Data krycia</th>
                            <th scope="col">Prawdopodobny termin oproszenia</th>
                            <th scope="col">Rzeczywisty termin oproszenia</th>
                            <th scope="col">Ilość w miocie</th>
                            <th scope="col">Ilość martwych prosiąt</th>
                            <th scope="col">Rasa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            get_one_swine_insemination($id) 
                        ?>
                    </tbody>
                </table>
                <a href="forms/dodaj-krycie.php?id=<?php echo $id; ?>" class="btn btn-danger">Dodaj krycie</a>
                <?php
                    }
                    else
                    {
                        ?>
                            <a href="action/wydziel-maciore.php?id=<?php echo $id; ?>" class="btn btn-danger">Wydziel maciorę ze stada</a>
                        <?php
                    }
                ?>
                <a href="forms/dodaj-szczepienie.php?id=<?php echo $id; ?>" class="btn btn-danger">Dodaj szczepienie</a>
            </div>
        </div>
    <?php
}

function draw_cattle_panel() {
    ?>
        <div class="row">             
            <?php draw_menu('bydlo'); ?>
                        
            <div class=" text-white col-lg-10 col-xs-10 h-100">
            </div>
        </div>
    <?php
}

function draw_field_card_panel() {
    ?>
        <div class="row">             
            <?php draw_menu('karta-pola'); ?>
                        
            <div class=" text-white col-lg-10 col-xs-10 h-100">
            </div>
        </div>
    <?php
}

function draw_menu($category) {
    $link = connect();
    ?>
        <div class="col-lg-2 col-xs-2 h-100">
            <div class="row p-4 text-white">
                <div class="col-lg-12 col-xs-12 text-center">
                    <h5><?php echo get_name_and_surname($_SESSION['user_id']); ?></h5>
                    <a class="text-white btn btn-danger" href="action/logout.php">Wyloguj</a>
                </div>
            </div>
            <div class="row pt-2 pb-2">
                <div class="col-lg-12 col-xs-12 text-center">
                    <div id="list-example" class="list-group">
    <?php
    if($rslt = $link -> query("show tables where Tables_in_27834924_szs REGEXP BINARY '[A-Z]'"))
    {
        if($category=='Strona główna')
        {
            ?> 
                <a class="list-group-item list-group-item-action text-white bg-light text-dark" href="/index.php">Strona główna</a>
            <?php
        }
        else
        {
            ?> 
                <a class="list-group-item list-group-item-action bg-secondary text-light" href="/index.php">Strona główna</a>
            <?php
        }

        while($row = $rslt -> fetch_array())
        {
            $row_without_spaces = str_replace(' ', '-', $row['Tables_in_27834924_szs']);
            $row_without_spaces = strtolower($row_without_spaces);

            if($row_without_spaces===$category)
            {
                ?> 
                    <a class="list-group-item list-group-item-action text-white bg-light text-dark" href="/<?php echo $row_without_spaces.".php" ?>"><?php echo $row['Tables_in_27834924_szs'] ?></a>
                <?php
            }
            else
            {

                ?> 
                    <a class="list-group-item list-group-item-action bg-secondary text-light" href="/<?php echo $row_without_spaces.".php" ?>"><?php echo $row['Tables_in_27834924_szs'] ?></a>
                <?php
            }
        }
    }  

    ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

function draw_actual_sow_table() {
    ?>
        <h5 class="p-3">Aktualny stan Macior</h5>
        <table class="table table-dark table-striped table-bordered text-left table-hover">
            <thead>
                <tr>
                    <th scope="col">Nr Kolczyka</th>
                    <th scope="col">Data Urodzenia</th>
                    <th scope="col">Najbliższe zdarzenie</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    get_actual_sows();
                ?>
            </tbody>
        </table>
    <?php
}

function draw_actual_swines_table() {
    ?>
        <h5 class="p-3">Aktualny stan Tuczników</h5>
        <table class="table table-dark table-striped table-bordered text-left table-hover">
            <thead>
                <tr>
                    <th scope="col">Nr Kolczyka matki</th>
                    <th scope="col">Nr stada</th>
                    <th scope="col">Data Urodzenia</th>
                    <th scope="col">Ilość w stadzie</th>
                    <th scope="col">Najbliższe zdarzenie</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    get_actual_swines();
                ?>
            </tbody>
        </table>
    <?php
}

function draw_add_swine_form() {
    ?>
        <div class="row">             
            <?php draw_menu('trzoda'); ?>
                        
            <div class=" text-white col-lg-10 col-xs-10 p-3 text-center">
                <h5>Dodaj świnię</h5>
                <form method="POST" action="../action/add.php" class="center_div rounded">
                    <div class="form-group">
                        <label class='m-3' onclick="typ_swin(1)"><input type="radio" name="jedynka" class="form-control h-100" checked>Maciora</label>
                        <label class='m-3' onclick="typ_swin(2)"><input type="radio" name="jedynka" class="form-control h-100">Stado tuczników</label>
                    </div>
                    <div class="form-group" >
                        <label class='m-3' id="nr_do_wyboru1"><input type="number" name="nr_maciory" class="form-control" value="<?php echo get_first_available_number(); ?>"><span id="typ_swini">Nr maciory</span></label>
                        <label class='m-3' id="nr_do_wyboru2" style="display:none;">
                            <select name="nr_maciory_matki">
                                <?php get_all_actual_sow_nbrs(); ?>
                            </select>
                            <span>Nr maciory matki</span>
                        </label>
                        <label class='m-3'><input type="date" name="data_przybycia" class="form-control p-2">Data przybycia</label>
                        <label id="pola_formularza_stado"></label>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Dodaj" class="btn btn-danger" />
                    </div>
                </form>
            </div>
        </div>
    <?php
}

function draw_add_insemination_form($id) {
    ?>
        <div class="row">             
            <?php draw_menu('trzoda'); ?>
                        
            <div class=" text-white col-lg-10 col-xs-10 p-3 text-center">
                <h5>Dodaj Krycie</h5>
                <form method="POST" action="../action/add-insemination.php" class="center_div rounded">
                    <div class="form-group" >
                        <input type="hidden" name="nr_maciory" class="form-control" value="<?php echo $id; ?>">
                        <label class='m-3'><input type="date" name="data_krycia" class="form-control p-2">Data krycia</label>
                        <label class='m-3'><input type="text" name="rasa" class="form-control p-2">Rasa (tutaj pewnie damy możliwość wyboru z wcześiej zdefinowanej listy)</label>
                        <label id="pola_formularza_stado"></label>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Dodaj" class="btn btn-danger" />
                    </div>
                </form>
            </div>
        </div>
    <?php
}

function draw_insemination_edit_form($id, $datprawpor, $idmaciory) {
    ?>
        <div class="row">             
            <?php draw_menu('trzoda'); ?>
                        
            <div class=" text-white col-lg-10 col-xs-10 p-3 text-center">
                <h5>Edytuj Krycie</h5>
                <form method="POST" action="../action/edit-insemination.php" class="center_div rounded">
                    <div class="form-group" >
                        <input type="hidden" name="id_maciory" class="form-control" value="<?php echo $idmaciory; ?>">
                        <input type="hidden" name="id_krycia" class="form-control" value="<?php echo $id; ?>">
                        <label class='m-3'><input type="date" name="data_oproszenia" class="form-control p-2" value="<?php echo $datprawpor; ?>">Data oproszenia</label>
                        <label class='m-3'><input type="number" name="ilosc_w_stadzie" class="form-control p-2">Ilość żywych prosiąt</label>
                        <label class='m-3'><input type="number" name="ilosc_martwych" class="form-control p-2">Ilość martwych prosiąt</label>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Dodaj" class="btn btn-danger" />
                    </div>
                </form>
            </div>
        </div>
    <?php
}

function draw_vaccines_panel() {
    ?>
        <div class="row">             
            <?php draw_menu('szczepionki'); ?>
                        
            <div class=" text-white col-lg-10 col-xs-10 p-3 text-center">
                <a href="/forms/dodaj-szczepionke.php" class="btn btn-danger">Dodaj szczepionkę</a>
                <?php draw_actual_vaccines_table(); ?>
            </div>
        </div>
    <?php
}

function draw_actual_vaccines_table() {
    ?>
        <h5 class="p-3">Aktualnie używane szczepionki</h5>
        <table class="table table-dark table-striped table-bordered text-left table-hover">
            <thead>
                <tr>
                    <th scope="col">Nazwa Szczepionki</th>
                    <th scope="col">Okres karencji</th>
                    <th scope="col">Czas do ponownego zaszczepienia</th>
                    <th scope="col">Opis/Skład</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    get_actual_vaccines();
                ?>
            </tbody>
        </table>
    <?php
}

function draw_add_vaccine_form() {
    ?>
        <div class="row">             
            <?php draw_menu('szczepionki'); ?>
                        
            <div class=" text-white col-lg-10 col-xs-10 p-3 text-center">
                <h5>Dodaj szczepionkę</h5>
                <form method="POST" action="../action/add-vaccine.php" class="center_div rounded">
                    <div class="form-group" >
                        <label class='m-3'><input type="text" name="nazwa_szczepionki" class="form-control p-2">Nazwa szczepionki</label>
                        <label class='m-3'><input type="number" name="dlugosc_karencji" class="form-control p-2">Długość karencji</label>
                        <label class='m-3'><input type="number" name="czas_do_ponownego_zaszczepienia" class="form-control p-2">Czas do ponownego zaszczepienia w dniach</label>
                        <label class='m-3'><textarea name="opis" class="form-control p-2"></textarea>Opis/Skład/Uwagi</label>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Dodaj" class="btn btn-danger" />
                    </div>
                </form>
            </div>
        </div>
    <?php
}

function draw_add_inoculating_form($id) {
    ?>
        <div class="row">             
            <?php draw_menu('trzoda'); ?>
                        
            <div class=" text-white col-lg-10 col-xs-10 p-3 text-center">
                <h5>Dodaj Szczepienie</h5>
                <form method="POST" action="../action/add-inoculating.php" class="center_div rounded">
                    <div class="form-group" >
                        <input type="hidden" name="id_maciory" class="form-control" value="<?php echo $id; ?>">
                        <label class='m-3'><input type="date" name="data_szczepienia" class="form-control p-2">Data szczepienia</label>
                        <label class='m-3'>
                            <select name="id_szczepionki" class="form-control p-2">
                                <?php get_all_vaccines_select_list() ?>
                            </select>
                            Rodzaj szczepionki
                        </label>
                        <label id="pola_formularza_stado"></label>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Dodaj" class="btn btn-danger" />
                    </div>
                </form>
            </div>
        </div>
    <?php
}

?>