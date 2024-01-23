<?php
// include our connect script
require_once("conf.php");

// check to see if there is a user already logged in, if so redirect them
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['userid']))
    header("Location: $_SERVER[PHP_SELF]");
if (isset($_POST['registerBtn'])){
    // get all of the form data
    $username = $_POST['username'];
    $passwd = $_POST['passwd'];
    $passwd_again = $_POST['passwd_again'];


    // query the database to see if the username is taken
    global $yhendus;
    $kask= $yhendus->prepare("SELECT * FROM kasutaja WHERE kasutaja=?");
    $kask->bind_param("s",$username);
    $kask->execute();
    //$query = mysqli_query($yhendus, "SELECT * FROM kasutajad WHERE nimi='$username'");
    if (!$kask->fetch()){

        // create and format some variables for the database
        $id = '';
        $sool='superpaev';
        $krypt=crypt($passwd, $sool);
        $passwd_hashed = $krypt;
        $date_created = time();
        $last_login = 0;
        $status = 1;



        // verify all the required form data was entered
        if ($username != "" && $passwd != "" && $passwd_again != ""){
            // make sure the two passwords match
            if ($passwd === $passwd_again){
                // make sure the password meets the min strength requirements
                if ( strlen($passwd) >= 5){
                    // insert the user into the database
                    mysqli_query($yhendus, "INSERT INTO kasutaja (kasutaja, parool) VALUES ('$username', '$passwd_hashed')");
                    //echo "<script>alert('rrrr')</script>";
// verify the user's account was created
                    $query = mysqli_query($yhendus, "SELECT * FROM kasutaja WHERE kasutaja='{$username}'");
                    if (mysqli_num_rows($query) == 1){

                        /* IF WE ARE HERE THEN THE ACCOUNT WAS CREATED! YAY! */
                        /* WE WILL SEND EMAIL ACTIVATION CODE HERE LATER */
//echo "<script>alert('yay')</script>";
                        $success = true;
                    }
                }
                else
                    $error_msg = 'Teie parool ei ole piisavalt tugev. Palun kasutage teist.';
            }
            else
                $error_msg = 'Teie paroolid ei sobinud.';
        }
        else
            $error_msg = 'Palun täitke kõik nõutavad väljad.';
    }
    else
        $error_msg = 'Kasutajanimi <i>'.$username.'</i> on juba võetud. Palun kasutage teist.';
}

else
    $error_msg = 'Tekkis viga ja teie kontot ei loodud.';


?>


<head>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<form action="./register.php" class="form" method="POST">

    <h1>Registreeri uus kasutaja</h1>

    <div class="">
        <?php
        // check to see if the user successfully created an account
        if (isset($success) && $success){
            echo '<p color="green">Teie konto on loodud. <a href="login.php">Vajuta siia</a> sisse logida!<p>';
        }
        // check to see if the error message is set, if so display it
        else if (isset($error_msg))
            echo '<p color="red">'.$error_msg.'</p>';

        ?>
    </div>

    <div class="">
        <input type="text" name="username" value="" placeholder="Nimi" autocomplete="off" required />
    </div>
    <div class="">
        <input type="password" name="passwd" value="" placeholder="Salasona" autocomplete="off" required />
    </div>
    <div class="">
        <p>Salasõna peab olema vähemalt 5 tähemärki</font></p>
    </div>
    <div class="">
        <input type="password" name="passwd_again" value="" placeholder="Kinnitage oma salasõna" autocomplete="off" required />
    </div>

    <div class="">
        <input class="" type="submit" name="registerBtn" value="Konto loomine" />
    </div>

    <p class="center"><br />
        Kas teil on juba konto? <a href="login.php">Logi sisse</a>
    </p>
</form>