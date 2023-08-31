<?php //

require_once 'inc/init.inc.php';





//2 . Form treatment
if (!empty($_POST)) { // check form not empty
    $_POST['first_name'] = htmlspecialchars($_POST['first_name']);
    $_POST['last_name'] = htmlspecialchars($_POST['last_name']);

    $_POST['email'] = htmlspecialchars($_POST['email']);
    $_POST['password'] = htmlspecialchars($_POST['password']);

    if (!isset($_POST['first_name']) || strlen($_POST['first_name']) < 2 || strlen($_POST['first_name']) > 20) {
        $contenu .= "<div class='alert alert-danger hide'> Prenom entre 2 et 20 caracteres </div>";
    }
    if (!isset($_POST['last_name']) || strlen($_POST['last_name']) < 2 || strlen($_POST['last_name']) > 20) {
        $contenu .= "<div class='alert alert-danger hide'> Nom entre 2 et 20 caracteres </div>";
    }
    if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { // check that email is not empty and check it with filter_var and filter validate  email(regex).
        $contenu .= '<div class="alert alert-danger hide"> Email not up to requierements </div>';
    }

    if (empty($contenu)) { // if empty that means the user correctly filled in the infos.
        //we want the pseudo to be unique in our given field
        $membre = $pdoOnye->prepare("SELECT * FROM users WHERE first_name = :first_name");
        $membre->execute(array(
            ':first_name' => $_POST['first_name']
        ));
        // check if the infos do not already exist.
        if ($membre->rowCount() > 0) { //ask if the previous query gives results(> 0), if yes, must give another pseudo. because current one is taken.
            /* $contenu .= '<div class="alert alert-warning"> Unavailable pseudo, choose another </div>'; */
        } else { //pseudo is available. send to DB
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hashing the password, with the help of PASSWORD_DEFAULT constant method and predefined function password_hash.
            //We can also define our own algorythm instead of usig PASSWORD_DEFAULT.
            $insertion = $pdoOnye->prepare("INSERT INTO users (first_name, last_name, email, password, statut) VALUES(:first_name, :last_name, :email, :password, 0)");
            //inserting into DB, Empty markers which will equal the values input by user. 
            // the only different field is statut, automatically set to 0. not admin.
            $insertion->execute(array(
                ':first_name' => $_POST['first_name'],
                ':last_name' => $_POST['last_name'],
                ':email' => $_POST['email'],
                ':password' => $password, //here we are recovering the password that we hashed above.

            ));

            if ($insertion) {
                $contenu .= '<div class="alert alert-success"> You have successfully subscribed. Click here to log in <a href="connect.php"> Log In</a> </div>';


                //once online the email will be sent
                // send email to new user
                //email variables 
                $emailSubject = 'Welcome to My ONYE';
                $emailBody = "Hello " . $_POST['first_name'] . ",\r\n\r\n" .
                    "Thank you for signing up on our website. We are excited to have you as a customer.\r\n\r\n" .
                    "Best regards,\r\n" .
                    "The Onye Team";


                $to = $_POST['email'];
                $headers = 'From: ONYE <noreply@onye.com>' . "\r\n";
                mail($to, $emailSubject, $emailBody, $headers);
            } else {
                $contenu .=
                    '<div class="alert alert-danger"> Subscription error. </div>';
            }
        }
    }
}



?>




<!doctype html>
<html lang="fr">

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>_ONYE_singIn</title>
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

            <div class="col-12 col-md-7 mx-auto py-5 my-5">
                <form action="#" method="POST" id="form">
                    <h3 class="text-center">Please sign in/up</h3>
                    <div class="mb-3 " id="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control">
                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control">
                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="email">E-Mail</label>
                        <input type="text" name="email" id="email" class="form-control">
                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="mb-3 text-center">
                        <input type="submit" name="submit" id="submit" value="Subscribe" class="btn btn-sub">
                    </div>
                </form>
                <div class="alert fs-5">
                    <p class="text-dark">If you already have an account<a href="connect.php" class="text-decoration-none btn-sub rounded">Click here to connect !</a></p>
                </div>
            </div>

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