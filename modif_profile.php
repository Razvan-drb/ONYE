<?php //
error_reporting(E_ALL);
ini_set('display_errors', 1);



//connect to db
require_once 'inc/init.inc.php';

// 2- Sélection d'un user en particulier
if (isset($_SESSION['users']['user_id'])) {

    $users = $pdoOnye->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $users->execute(array(
        ':user_id' => $_SESSION['users']['user_id'],
    ));

    // 3- Si la personne arrive sur la page avec un id_article dans l'url qui n'existe pas // redirection vers la page articles.php
    if ($users->rowCount() == 0) {
        header('location:sign_in.php');
        exit();
    }

    $ficheUsers = $users->fetch(PDO::FETCH_ASSOC);
} else { // 4- Si la personne arrive sans id_article dans l'url // redirection vers la page articles.php
    header('location:sign_in.php');
    exit();
}

// redirection to page connexion if the user is not connected 
if (!estConnecte()) {
    header('location:connect.php');
    exit();
}
//deconnexion
if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') { //i check that i recover action = deconnexion
    session_destroy(); //destroy all traces of the session
    $contenu .= '<div class="alert btn-sub text-center">You Have Been Disconnected. <a href="connect.php" class="text-decoration-none text-white "> Click Here To Reconnect <i class="bi bi-person-circle fs-3"></i> </a>  </div>';
    /*  echo $contenu; */
}

// modif profile **********

if (!empty($_POST)) {
    //avoiding SQL injecting in the input field
    $_POST['first_name'] = htmlspecialchars($_POST['first_name']);
    $_POST['last_name'] = htmlspecialchars($_POST['last_name']);
    $_POST['email'] = htmlspecialchars($_POST['email']);
    $_POST['address'] = htmlspecialchars($_POST['address']);
    $_POST['city'] = htmlspecialchars($_POST['city']);
    $_POST['country'] = htmlspecialchars($_POST['country']);
    $_POST['zip_code'] = htmlspecialchars($_POST['zip_code']);
    $_POST['phone_number'] = htmlspecialchars($_POST['phone_number']);

    //update query ************
    $update = $pdoOnye->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email =:email, address =:address, city = :city, country = :country, zip_code =:zip_code, phone_number =:phone_number WHERE user_id = :user_id");

    /*   $error = $update->errorInfo();
    if ($error[0] != '00000') {
        echo 'Error message: ' . $error[2];
    }
 */

    $update->execute(array(
        ':user_id' => $_SESSION['users']['user_id'],
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':address' => $_POST['address'],
        ':city' => $_POST['city'],
        ':country' => $_POST['country'],
        ':zip_code' => $_POST['zip_code'],
        ':phone_number' => $_POST['phone_number'],

    ));

    header('location:profile.php');
    exit();
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
                    <h3 class="text-center py-4">You are connected as:</h3>
                    <?php echo $ficheUsers['first_name'] . ' ' . $ficheUsers['last_name']  ?>
                </div>
                <div class="card-body text-white">

                    <h5 class="card-title"><?php echo $_SESSION['users']['email'] ?></h5>

                    <p class="card-text text-white"><?php
                                                    if (estAdmin()) {
                                                        echo "Admin";
                                                    } else {
                                                        echo "Regular user";
                                                    }
                                                    ?></p>
                </div>

            </div>

            <!-- form for update -->

            <div class="col-12 col-md-7 mx-auto py-5 my-5">
                <form action="#" method="POST" id="form">
                    <h3 class="text-center py-4">Below you can change your info</h3>
                    <div class="mb-3 " id="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo isset($_SESSION['users']['first_name']) ? $_SESSION['users']['first_name'] : ''; ?>">

                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo isset($_SESSION['users']['last_name']) ? $_SESSION['users']['last_name'] : ''; ?>">

                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="email">E-mail</label>
                        <input type="text" name="email" id="email" class="form-control" value="<?php echo isset($_SESSION['users']['email']) ? $_SESSION['users']['email'] : ''; ?>">

                    </div>


                    <div class="mb-3" id="form-group">
                        <label for="address">Address</label>
                        <input type="address" name="address" id="address" class="form-control" value="<?php echo isset($_SESSION['users']['address']) ? $_SESSION['users']['address'] : ''; ?>">

                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="city">City</label>
                        <input type="city" name="city" id="city" class="form-control" value="<?php echo isset($_SESSION['users']['city']) ? $_SESSION['users']['city'] : ''; ?>">

                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="country">Country</label>
                        <input type="country" name="country" id="country" class="form-control" value="<?php echo isset($_SESSION['users']['country']) ? $_SESSION['users']['country'] : ''; ?>">

                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="zip_code">Zip code</label>
                        <input type="zip_code" name="zip_code" id="zip_code" class="form-control" value="<?php echo isset($_SESSION['users']['zip_code']) ? $_SESSION['users']['zip_code'] : ''; ?>">

                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="phone_number">Phone number</label>
                        <input type="phone_number" name="phone_number" id="phone_number" class="form-control" value="<?php echo isset($_SESSION['users']['phone_number']) ? $_SESSION['users']['phone_number'] : ''; ?>">

                    </div>

                    <div class=" fs-5 text-center">
                        <input type="submit" class="align-items-center text-decoration-none btn-sub rounded w-50" value="Update profile">
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