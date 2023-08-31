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