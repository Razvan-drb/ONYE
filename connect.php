<?php //

require_once 'inc/init.inc.php';

if (!empty($_POST)) {
    if (empty($_POST['email']) || empty($_POST['password'])) { //we check if they empty. if empty message with contenu
        $contenu .= '<div class="alert alert-warning" >Email and Password are necessary</div>';
    }
    if (empty($contenu)) { //if contenu is empty it means i have no errors. so we can connect
        $resultat = $pdoOnye->prepare('SELECT * FROM users WHERE email = :email'); //check that email exists in the DB
        $resultat->execute(array(
            ':email' => $_POST['email'],
        ));
        if ($resultat->rowCount() == 1) { //if it sends one line, means that the user(email) exists
            $membre = $resultat->fetch(PDO::FETCH_ASSOC);
            if (password_verify($_POST['password'], $membre['password'])) { //password_verify takes 2 arguments. 1. password from the form. 2. password from the DB. We check they are the same
                $_SESSION['users'] = $membre; // we create a session with the user infos
                /* header('location:profile.php'); //once the session was created we redirect to index
                exit(); */
                $contenu .= '<div class="alert btn-sub text-center">You are connected !</div>';
            } else { //if password is not good
                $contenu .= '<div class="alert alert-danger">Password is not good </div>';
            }
        } else { //if the email no good
            $contenu .= '<div class="alert alert-danger">Email not good</div>';
        }
    }
}



?>




<!doctype html>
<html lang="fr">

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>_ONYE_</title>
<link rel="icon" type="image/x-icon" href="/img/o.png">
<!-- CSS from Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

<!-- google fonts ******************** -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rubik+Moonrocks&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dosis&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet">

<!-- boostrap icons link -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


<!-- css link -->
<link rel="stylesheet" href="IndexStyle.css">

<style>
    .hide {
        animation: hideAnimation 0s ease-out 5s;
        animation-fill-mode: forwards;
        animation-duration: 1s;
    }

    @keyframes hideAnimation {
        to {
            visibility: hidden;
            width: 0;
            height: 0;
        }
    }
</style>

</head>

<body>



    <header>
        <div class="logo"><img src="img/LOGOs-13.png" alt="page logo"></div>
        <nav>

            <!-- <a href="#" class="logo">ONYE</a> -->
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="contact.php">Contact</a>
            <a href="about.php">About</a>
            <a href="sign_in.php">Sign in</a>
            <?php if (estConnecte() && estAdmin()) { ?>
                <a href="admin.php" class="text-success fw-bolder">Admin</a>
            <?php } ?>
            <a href="cart.php"><i class="bi bi-cart4 fs-2"></i></a>
            <?php if (estConnecte()) { ?>
                <a href="profile.php"><i class="bi bi-person-circle fs-2"></i></a>
            <?php } ?>

        </nav>
    </header>

    <video loop autoplay muted id="bgcVideo">
        <source src="video/bgcVideo.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <main class="container w-50 py-4" id="signInBgc">
        <section class="row mx-auto ">
            <?php echo $contenu; ?>

            <?php if (!estConnecte()) { ?>
                <form method="POST">

                    <div class="mb-3" id="form-group">
                        <label for="email">E-Mail</label>
                        <input type="text" name="email" id="email" class="form-control">
                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="mb-3 text-center">
                        <input type="submit" name="submit" id="submit" value="Connect" class="btn btn-sub">
                    </div>

                <?php } ?>

                <?php
                if (estConnecte()) {
                    echo "<div class=\"alert fs-5 text-center\">
                
                    <p class=\"text-dark align-items-center\"><a href=\"profile.php\" class=\"text-decoration-none btn-sub rounded w-25 py-2\">Go to your profile </a> </p>
                </div>";
                }
                ?>



                </form>



        </section>






    </main>


    <?php
    include_once 'inc/footer.inc.php';
    ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>