<!DOCTYPE html>
<html lang="pl">
    <?php require_once "head.php" ?>
    <body class="bg-dark">
        <div class="container-fluid">
            <?php //echo $_SESSION['user_id']; ?>
            <?php if(check_if_login_exist(@$_SESSION['user_id'])===false) draw_login_form(); else draw_cattle_panel(); ?>
        </div>
    </body>
    <?php require_once "footer.php" ?>
</html>