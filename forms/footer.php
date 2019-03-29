<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="../js/bootstrap.min.js"></script>
<script>
 jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});


function typ_swin(typ) {
    var type = typ;
    if(type==1) {
        document.getElementById("typ_swini").innerHTML = "Nr maciory";
        document.getElementById("nr_do_wyboru1").style.display = "";
        document.getElementById("nr_do_wyboru2").style.display = "none";
        document.getElementById("pola_formularza_stado").innerHTML = null;
    }
    else if(type==2) {
        document.getElementById("typ_swini").innerHTML = "Nr matki tucznika";
        document.getElementById("pola_formularza_stado").innerHTML = "<input type='number' name='typ' class='form-control'>Liczba prosiąt w stadzie</span>";
        document.getElementById("nr_do_wyboru2").style.display = "";
        document.getElementById("nr_do_wyboru1").style.display = "none";
    }
    else {
        document.getElementById("typ_swini").innerHTML = "Nr matki prosiaka";
    }
}
</script>
 