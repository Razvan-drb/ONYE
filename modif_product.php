<?php //
error_reporting(E_ALL);
ini_set('display_errors', 1);



//connect to db
require_once 'inc/init.inc.php';

// 2- Sélection d'un product en particulier
if (isset($_GET['product_id'])) {

    $products = $pdoOnye->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $products->execute(array(
        ':product_id' => $_GET['product_id'],
    ));

    // 3- Si la personne arrive sur la page avec un product_id dans l'url qui n'existe pas // redirection vers la page products.php
    if ($products->rowCount() == 0) {
        header('location:products.php');
        exit();
    }

    $ficheProduct = $products->fetch(PDO::FETCH_ASSOC);
} else { // 4- Si la personne arrive sans id_article dans l'url // redirection vers la page articles.php
    header('location:products.php');
    exit();
}

// redirection to page connexion if the user is not connected 
if (!estConnecte()) {
    header('location:products.php');
    exit();
}


// modif product **********

if (!empty($_POST)) {
    //avoiding SQL injecting in the input field
    $_POST['product_name'] = htmlspecialchars($_POST['product_name']);
    $_POST['description'] = htmlspecialchars($_POST['description']);
    $_POST['price'] = htmlspecialchars($_POST['price']);
    $_POST['image1'] = htmlspecialchars($_POST['image1']);
    $_POST['image2'] = htmlspecialchars($_POST['image2']);
    $_POST['image3'] = htmlspecialchars($_POST['image3']);
    $_POST['image4'] = htmlspecialchars($_POST['image4']);


    //update query ************
    $update = $pdoOnye->prepare("UPDATE products SET product_name = :product_name, description = :description, price =:price, image1 =:image1, image2 = :image2, image3 = :image3, image4 =:image4 WHERE product_id = :product_id");

    /*   $error = $update->errorInfo();
    if ($error[0] != '00000') {
        echo 'Error message: ' . $error[2];
    } */


    $update->execute(array(
        ':product_id' => $_GET['product_id'],
        ':product_name' => $_POST['product_name'],
        ':description' => $_POST['description'],
        ':price' => $_POST['price'],
        ':image1' => $_POST['image1'],
        ':image2' => $_POST['image2'],
        ':image3' => $_POST['image3'],
        ':image4' => $_POST['image4'],


    ));

    /* header('location:product.php');
    exit(); */
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
            <div class="card text-center">
                <div class="fs-3 py-4 text-white">

                    <img src="<?php echo $ficheProduct['image1'] ?>" alt="">
                    <br>
                    <?php echo 'Name: ' . $ficheProduct['product_name'] ?>
                    <br>
                    <?php echo 'Description: ' . $ficheProduct['description'] ?>
                </div>
                <div class="card-body text-white">

                    <h5 class="card-title"><?php echo 'Price: ' . $ficheProduct['price'] ?></h5>

                </div>

            </div>

            <!-- form for update -->

            <div class="col-12 col-md-7 mx-auto py-5 my-5">
                <form action="#" method="POST" id="form">
                    <h3 class="text-center py-4">Below you can update your product</h3>
                    <div class="mb-3 " id="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo isset($ficheProduct['product_name']) ? $ficheProduct['product_name'] : ''; ?>">

                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control" value="<?php echo isset($ficheProduct['description']) ? $ficheProduct['description'] : ''; ?>">

                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="price">Price</label>
                        <input type="text" name="price" id="price" class="form-control" value="<?php echo isset($ficheProduct['price']) ? $ficheProduct['price'] : ''; ?>">

                    </div>


                    <div class="mb-3" id="form-group">
                        <label for="image1">Image 1</label>
                        <input type="image1" name="image1" id="image1" class="form-control" value="<?php echo isset($ficheProduct['image1']) ? $ficheProduct['image1'] : ''; ?>">

                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="image2">Image 2</label>
                        <input type="image2" name="image2" id="image2" class="form-control" value="<?php echo isset($ficheProduct['image2']) ? $ficheProduct['image2'] : ''; ?>">

                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="image3">Image 3</label>
                        <input type="image3" name="image3" id="image3" class="form-control" value="<?php echo isset($ficheProduct['image3']) ? $ficheProduct['image3'] : ''; ?>">

                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="image4">Image 4</label>
                        <input type="image4" name="image4" id="image4" class="form-control" value="<?php echo isset($ficheProduct['image4']) ? $ficheProduct['image4'] : ''; ?>">

                    </div>


                    <div class=" fs-5 text-center">
                        <input type="submit" class="align-items-center text-decoration-none btn-sub rounded w-50" value="Update product">
                    </div>


                </form>

            </div>



            <!-- end form for update -->



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