<?php //

require_once 'inc/init.inc.php';

?>




<!doctype html>
<html lang="fr">

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>_ONYE_Contact</title>
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
                <?php
                // define variables and set to empty values
                $nameErr = $emailErr = $messageErr = "";  // error variables for each field
                $name = $email = $message = "";  // variables to hold user input

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // if the form was submitted via POST

                    if (empty($_POST["first_name"])) {
                        // if the name field is empty
                        $nameErr = "First Name is required";  // set the error message for name field
                    } else {
                        $name = test_input($_POST["first_name"]);  // sanitize and set the name variable
                        // check if name only contains letters and whitespace
                        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                            // if name contains anything other than letters and spaces
                            $nameErr = "Only letters and white space allowed";  // set the error message for name field
                        }
                    }

                    if (empty($_POST["email"])) {
                        // if the email field is empty
                        $emailErr = "Email is required";  // set the error message for email field
                    } else {
                        $email = test_input($_POST["email"]);  // sanitize and set the email variable
                        // check if e-mail address is well-formed
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            // if email is not in a valid format
                            $emailErr = "Invalid email format";  // set the error message for email field
                        }
                    }

                    if (empty($_POST["message"])) {
                        // if the message field is empty
                        $messageErr = "Message is required";  // set the error message for message field
                    } else {
                        $message = test_input($_POST["message"]);  // sanitize and set the message variable
                    }

                    if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
                        // if there are no error messages
                        $to = "razvan.drb.33@gmail.com";  // set the recipient email address
                        $subject = "Contact Form Submission";  // set the email subject
                        $body = "Name: $name\nMessage: $message";  // create the email body
                        $headers = "From: $email\r\n";  // set the from header
                        $headers .= "Reply-To: $email\r\n";  // set the reply-to header

                        if (mail($to, $subject, $body, $headers)) {
                            // if the email was sent successfully
                            echo "<p class=\"text-dark\">Your message has been sent. Thank you!</p>";  // display success message
                            $name = $email = $message = "";  // reset the input variables
                        } else {
                            // if there was an error sending the email
                            echo "<p>Sorry, there was an error sending your message. Please try again later.</p>";  // display error message
                        }
                    }
                }

                function test_input($data)
                {
                    // sanitize user input
                    $data = trim($data);  // remove whitespace from beginning and end of input
                    $data = stripslashes($data);  // remove backslashes from input
                    $data = htmlspecialchars($data);  // convert special characters to HTML entities
                    return $data;  // return sanitized input
                }
                ?>


                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3 " id="form-group">
                        <label for="first_name">Your Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control">
                        <span class="error"><?php echo $nameErr; ?></span>
                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="email">E-Mail</label>
                        <input type="text" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
                        <span class="error"><?php echo $emailErr; ?></span>
                    </div>

                    <div class="mb-3" id="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" class="form-control" rows="5"><?php echo $message; ?></textarea>
                        <span class="error"><?php echo $messageErr; ?></span>
                    </div>

                    <div class="mb-3 text-center">
                        <div class="mb-3 text-center">
                            <input type="submit" name="submit" value="Submit" class="btn btn-sub">
                        </div>
                </form>




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