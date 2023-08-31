<?php
require_once 'inc/init.inc.php';

$requete = $pdoOnye->query("SELECT * FROM products ORDER BY product_id DESC");
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONYE minimalistic furniture</title>
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

    <div class="containerH2">
        <h2>Make Space</h2>
        <div class="arrow">
            <a href="#products"><i class="bi bi-arrow-down-circle"></i></a>
        </div>
    </div>

    <main class="container">

        <!--  <h1>_ONYE_</h1> -->

        <!-- <div class="containerH2">
            <h4>Some of our products</h4>
        </div> -->
        <!-- product photos ******************** -->

      
        <section class="row" id="products">


            <?php while ($article = $requete->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="col-12 col-md-4 my-4">
                    <div class="card h-100">
                        <div class="carousel" data-interval="false">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="<?php echo $article['image1']; ?>" class="card-img-top mx-auto align-items-center justify-content-center" alt="chair" style="width: 450px; height: 300px; object-fit: cover; align-items: center;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-white"><?php echo $article['product_name']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-white"><?php echo  $article['price']; ?> $</h6>
                            <p class="card-text"><?php echo $article['description']; ?></p>
                            <a href="product.php?product_id=<?php echo $article['product_id'] ?>" class="btn btn-sub">Go to product page</a>
                            <br>
                            <br>
                            <?php if (estConnecte() && estAdmin()) { ?>
                                <a href="products.php?action=suppression&product_id=<?php echo $article['product_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>





        </section>
        <div id="cookiePopup" class="hide">
            <img src="img/cookie3.png" />
            <p>
                Our website uses cookies to provide you with a better browsing experience and relevant information.
                Before continuing please accept our <a href="https://app.termly.io/dashboard/website/d85d8939-3942-4040-9a87-8f3fa9efe765/cookie-policy#" target="_blank">Cookie Policy & Privacy</a>
            </p>
            <div class="d-flex">
                <button id="acceptCookie">Accept</button>
                <button id="refuseCookie">Refuse</button>
            </div>
        </div>



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