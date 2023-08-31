<?php //
//connect to db
require_once 'inc/init.inc.php';


// redirection to page connexion if the user is not connected 
if (!estConnecte()) {
    header('location:connect.php');
    exit();
}
//deconnexion
if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') { //i check that i recover action = deconnexion
    session_destroy(); //destroy all traces of the session
    $contenu .= '<div class="alert alert-success">You Have Been Disconnected. <a href="connexion.php"> Reconnect </a>  </div>';
    echo $contenu;
}



?>


<!doctype html>
<html lang="fr">

<head>
    <title>My Blog - Profil de <?php echo $_SESSION['users']['first_name'] . ' ' . $_SESSION['users']['last_name'] ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.1/morph/bootstrap.min.css" integrity="sha512-A0X5tAzeIL+roI0rF0u3gt3AJ534dIJGmvmjVDKZQpH6GjiFq1lK1BnqjI63P6Uk2gbOuZplo9r4Ws8hf3Z1FA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!-- <?php include_once 'inc/nav.inc.php'; ?> -->

    <header class="p-5 mb-4 bg-warning rounded-3 text-white">
        <section class="container-fluid py-5">
            <h1 class="display-5 fw-bold">My Blog - Profil</h1>
            <p class="col-md-8 fs-4">Le profil de <?php echo $_SESSION['users']['first_name'] . ' ' . $_SESSION['users']['last_name'] ?>
                <br>
                <?php if (estAdmin()) {
                    echo "Welcome Admin!";
                } else {
                    echo "You are connected";
                }

                ?>
            </p>
        

        </section>
    </header>
    <main class="container">

        <section class="row">
            <div class="card text-center">
                <div class="card-header">
                    <?php echo $_SESSION['users']['first_name'] . ' ' . $_SESSION['users']['last_name']  ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $_SESSION['users']['email'] ?></h5>
                    
                    <p class="card-text"><?php
                                            if ($_SESSION['users']['statut'] == 1) {
                                                echo "Admin";
                                            } else {
                                                echo "Regular user";
                                            }
                                            ?></p>
                </div>
               
            </div>
        </section>



    </main>
    <br><br>
    <footer class="text-center">
        <a href="profile.php?action=deconnexion" class="btn btn-info">Disconnect</a>
    </footer>
    <?php //
    include_once 'inc/footer.inc.php';
    ?>
    <br><br><br><br><br><br><br><br>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>