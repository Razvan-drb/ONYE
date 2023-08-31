<?php //
//1. connection to DB with init file

require_once 'inc/init.inc.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}


// 2- Sélection d'un article en particulier
if (isset($_GET['product_id'])) {

    $article = $pdoOnye->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $article->execute(array(
        ':product_id' => $_GET['product_id'],
    ));

    // 3- Si la personne arrive sur la page avec un product_id dans l'url qui n'existe pas // redirection vers la page products.php
    if ($article->rowCount() == 0) {
        header('location:products.php');
        exit();
    }

    $ficheArticle = $article->fetch(PDO::FETCH_ASSOC);
} else { // 4- Si la personne arrive sans id_article dans l'url // redirection vers la page products.php
    header('location:products.php');
    exit();
}
/* shopping cart */


if (isset($_POST["add-to-cart"])) {
    $id = $_POST["product_id"];
    $name = $_POST["product_name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];

    $product = array(
        "id" => $id,
        "name" => $name,
        "price" => $price,
        "quantity" => $quantity
    );

    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = array();
    }

    array_push($_SESSION["cart"], $product);
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

    <main class="container   py-4" id="signInBgc">
        <section class="row mx-auto ">
            <?php echo $contenu; ?>
            <div class="">
                <a href="products.php" class="text-decoration-none text-dark fs-4"><i class="bi bi-arrow-left-circle fs-3 p-4"></i>Go back</a>
            </div>

            <div class="text-center my-4">
                <img src="<?php echo $ficheArticle['image1']; ?>" class="img-fluid w-50">
                <br>
                <img src="<?php echo $ficheArticle['image2']; ?>" class="img-fluid w-50">
                <br>
                <img src="<?php echo $ficheArticle['image3']; ?>" class="img-fluid w-50">
                <br>
                <img src="<?php echo $ficheArticle['image4']; ?>" class="img-fluid w-50">
            </div>

            <div class="w-75 mx-auto my-4 text-center fs-3">

                <?php //

                echo 'Name: ';
                echo html_entity_decode($ficheArticle['product_name']);
                echo '<br>';
                echo 'Description: ';
                echo html_entity_decode($ficheArticle['description']);
                echo '<br>';
                echo 'Price: ';
                echo html_entity_decode($ficheArticle['price']) . ' $';


                ?>
            </div>



            <!-- <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $_GET["product_id"]; ?>">
                <input type="hidden" name="product_name" value="<?php echo $_GET["product_name"]; ?>">
                <input type="hidden" name="price" value="<?php echo $_GET["price"]; ?>">
                <label>Quantity: </label>
                <input type="number" name="quantity" value="1" min="1">

                <a href="panier.php?action=ajout&amp;l=product_name&amp;q=quantity&amp;p=price" onclick="window.open(this.href, '', 
'toolbar=no, location=no, directories=no, status=yes, scrollbars=yes, resizable=yes, copyhistory=no, width=600, height=350'); return false;">Ajouter au panier</a>



                <button type="submit" name="add_to_cart">Add to Cart
                    <?php
                    // Get the number of items in the cart
                    $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

                    // Display the cart count
                    echo "($cart_count)";
                    ?>
                </button>
            </form> -->

            <form action="#" method="POST" class="text-center d-flex justify-content-center align-items-center p-4">
                <input type="hidden" name="product_id" value="<?php echo $_GET["product_id"]; ?>">
                <input class="form-control w-25 text-center " type="number" name="quantity" value="1" min="1">
                <button type="submit" class="btn btn-success mx-4">Add to cart</button>
            </form>

            <?php
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }

            ?>







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