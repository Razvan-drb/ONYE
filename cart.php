<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
require_once 'inc/init.inc.php';

// check if product ID is set
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // check if cart session variable is set
    if (isset($_SESSION['cart'])) {
        $cart_items = $_SESSION['cart'];
        // check if product already exists in cart
        if (array_key_exists($product_id, $cart_items)) {
            $cart_items[$product_id]++;
        } else {
            $cart_items[$product_id] = 1;
        }
        $_SESSION['cart'] = $cart_items;
    } else {
        // if cart session variable is not set, create new cart with product ID
        $_SESSION['cart'] = array($product_id => 1);
    }
    // redirect to cart page
    header('location:cart.php');
    exit;
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


            <!--   <div class="text-dark">
                <?php

                if (isset($_SESSION['cart'])) {
                    $cart_items = $_SESSION['cart'];
                    foreach ($cart_items as $product_id => $quantity) {
                        echo "Product ID: $product_id, Quantity: $quantity<br>";
                    }
                } else {
                    echo "Your cart is empty.";
                }
                ?>

            </div> -->


            <div class="text-dark table-responsive-lg">
                <table class="table table-stripped cart">
                    <?php
                    // check if cart session variable is set
                    if (!empty($_SESSION['cart'])) {
                        $cart_items = $_SESSION['cart'];
                        $total_price = 0;

                        foreach ($cart_items as $product_id => $quantity) {
                            // get product information from database based on product ID
                            $sql = "SELECT product_name, image1, price FROM products WHERE product_id = $product_id";
                            $result = mysqli_query($mysqliOnye, $sql);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $product_name = $row['product_name'];
                                $image1 = $row['image1'];
                                $price = $row['price'];
                                $total_product_price = $price * $quantity;
                                $total_price += $total_product_price;


                                
                                // display product information
                                echo "<tr>";
                                echo "<td><img src='$image1' alt='$product_name' width='100'></td>";
                                echo "<td><span>Name: $product_name</span></td>";
                                echo "<td><p class=\"text-dark\">Price per unit: $price $</p></td>";
                                echo "<td><p class=\"text-dark\">Quantity: $quantity</p></td>";
                                echo "<td><p class=\"text-dark\">Total price: $total_product_price $</p></td>";
                                echo "</tr>";
                            
                            }
                        }

                        // display total price for all products in the cart
                        echo "<tr>";
                        echo "<td colspan=\"4\"><h3 class=\"text-dark text-decoration-none\">Total Price:</h3></td>";
                        echo "<td><h3 class=\"text-dark\">$total_price $</h3></td>";
                        echo "</tr>";
                    } else {
                        echo "<tr><td colspan=\"5\">Your cart is empty.</td></tr>";
                    }
                    ?>
                </table>
            </div>


            <div class="my-3 text-center ">
                <button class="btn btn-success">Go to payment and order</button>
                <button onclick="clearCart()" class="btn btn-danger">Clear Cart</button>
            </div>


            <script>
                function clearCart() {
                    if (confirm("Are you sure you want to clear the cart?")) {
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    location.reload();
                                } else {
                                    alert('There was a problem clearing the cart.');
                                }
                            }
                        };
                        xhr.open('POST', 'clear_cart.php');
                        xhr.send();
                    }
                }
            </script>








        </section>




    </main>


    <?php
    include_once 'inc/footer.inc.php';
    ?>
    <script src="script.js"></script>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>