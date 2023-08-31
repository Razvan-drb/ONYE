<?php
require_once 'inc/init.inc.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>_ONYE_about</title>
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
    <link rel="stylesheet" href="aboutStyle.css">

</head>

<body>
    <!-- header ************************ -->
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


    <!-- end of header    *************************** -->

    <!-- bgc video """""""""""""""""" -->
    <video  loop autoplay muted id="bgcVideo">
        <source src="video/bgcVideo.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <!-- main ******************************************************* -->



    <main class="container w-75">
        <div class="parallaxBG"></div>

        <section class="row">

            <p class="text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero asperiores vitae quam autem recusandae
                iste adipisci mollitia exercitationem at molestias harum facilis, accusantium suscipit, eos rem.
                Temporibus quae iusto exercitationem?
            </p>

            <div class="slide1"></div>

            <p class="text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero asperiores vitae quam autem recusandae
                iste adipisci
                mollitia exercitationem at molestias harum facilis, accusantium suscipit, eos rem. Temporibus quae iusto
                exercitationem?
            </p>

            <div class="slide2"></div>

            <p class="text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero asperiores vitae quam autem recusandae
                iste adipisci
                mollitia exercitationem at molestias harum facilis, accusantium suscipit, eos rem. Temporibus quae iusto
                exercitationem?
            </p>

            <p class="text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero asperiores vitae quam autem recusandae
                iste adipisci
                mollitia exercitationem at molestias harum facilis, accusantium suscipit, eos rem. Temporibus quae iusto
                exercitationem?
            </p>

            <div class="slide3"></div>

            <p class="text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero asperiores vitae quam autem recusandae
                iste adipisci
                mollitia exercitationem at molestias harum facilis, accusantium suscipit, eos rem. Temporibus quae iusto
                exercitationem?
            </p>

        </section>




    </main>
    <!-- enf of main ********************************** -->




    <footer>
        <div class="social">
            <a href="https://instagram.com/onye____?igshid=YmMyMTA2M2Y=" target="_blank"><i class="bi bi-instagram"></i></a>
        </div>
        <a href="https://razvan-drb33-terms.mynotice.io/" target="_blank">- Legal Terms -</a>

        <a href="https://app.termly.io/dashboard/website/d85d8939-3942-4040-9a87-8f3fa9efe765/cookie-policy#" target="_blank">- Cookie
            Policy -</a>

        <a href="https://app.termly.io/dashboard/website/d85d8939-3942-4040-9a87-8f3fa9efe765/shipping-policy#" target="_blank">- Shipping -</a>

        <p>© - ONYE - Limited - 2022</p>
    </footer>








    <!-- script link to bootstrap !!! -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>


    <script src="script.js"></script>


</body>

</html>