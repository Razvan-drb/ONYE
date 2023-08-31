<?php //
//1. connectiong to DB with init file

require_once 'inc/init.inc.php';

//2. query to show the products

$requete = $pdoOnye->query("SELECT * FROM products ORDER BY product_id DESC");


//3. adding article
if (!empty($_POST)) { // if form not empty
    $_POST['product_name'] = htmlspecialchars($_POST['product_name']);
    $_POST['description'] = htmlspecialchars($_POST['description']);
    $_POST['price'] = htmlspecialchars($_POST['price']);
    $_POST['image1'] = htmlspecialchars($_POST['image1']);
    $_POST['image2'] = htmlspecialchars($_POST['image2']);
    $_POST['image3'] = htmlspecialchars($_POST['image3']);
    $_POST['image4'] = htmlspecialchars($_POST['image4']);


    //preparing insert query

    $insertion = $pdoOnye->prepare("INSERT INTO products (product_name, description, image1, image2, image3, image4, price, user_id) VALUES(:product_name, :description, :image1, :image2, :image3, :image4, :price, :user_id)");
    //adding the markers
    $insertion->execute(array(
        ':product_name' => $_POST['product_name'],
        ':description' => $_POST['description'],
        ':price' => $_POST['price'],
        ':image1' => $_POST['image1'],
        ':image2' => $_POST['image2'],
        ':image3' => $_POST['image3'],
        ':image4' => $_POST['image4'],
        ':user_id' => $_SESSION['users']['user_id'], // recovering the user id from the current logged in user

    ));
    $product_id = $_GET['product_id'];
    header('location:product.php?product_id=' . $product_id);
    exit();
}



//4. deleting article
if (isset($_GET['action']) && $_GET['action'] == 'suppression' && isset($_GET['product_id'])) {
    /* We check that action exists and that it equals suppersion. we also check if we recovered the id_employes and  if all that is good... then we execute de request, delete article. All this data(action,suppersion, product_id) is found in the link ok the suppresion button. */

    $requeteSup = $pdoOnye->prepare("DELETE FROM products WHERE product_id=:product_id");
    /* when we use 'prepare' the ':' means that we are creating a marker.
    Here the marker ':id_employes' is empty for now. */

    $requeteSup->execute(array(
        ':product_id' => $_GET['product_id'],
        /* we execute the query, with giving our empty marker a  value/information : i'm looking for the link id. */
    ));

    header('location:products.php');
    exit();
}


?>




<!doctype html>
<html lang="fr">

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>_ONYE_products</title>
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

    <main class="container py-4 w-75 " id="signInBgc">
        <?php echo $contenu; ?>
        <section class="row">


            <?php while ($article = $requete->fetch(PDO::FETCH_ASSOC)) { ?>
                <!-- col md 4 ------- 12 columns divided by 4 = 3 columns -->
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