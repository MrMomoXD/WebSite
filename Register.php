<?php
($conn = mysqli_connect("localhost", "root", "", "test")) or die("connection failed");

if (isset($_POST["submit"]))
{
    $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $country = mysqli_real_escape_string($conn, $_POST["country"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $nickname = mysqli_real_escape_string($conn, $_POST["nickname"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $image = $_FILES["image"]["name"];
    $image_size = $_FILES["image"]["size"];
    $image_tmp_name = $_FILES["image"]["tmp_name"];
    $image_folder = "uploaded_img/" . $image;

    // Set the maximum length for first name, last name, country, email, and nickname
    $max_length = 50;

    // Check the length of first name, last name, country, email, and nickname
    if (strlen($firstname) > $max_length)
    {
        $message[] = "First name cannot be longer than " . $max_length . " characters";
    }
    else
    {
        if (strlen($lastname) > $max_length)
        {
            $message[] = "Last name cannot be longer than " . $max_length . " characters";
        }
        else
        {
            if (strlen($country) > $max_length)
            {
                $message[] = "Country cannot be longer than " . $max_length . " characters";
            }
            else
            {
                if (strlen($email) > $max_length)
                {
                    $message[] = "Email cannot be longer than " . $max_length . " characters";
                }
                else
                {
                    if (strlen($nickname) > $max_length)
                    {
                        $message[] = "Nickname cannot be longer than " . $max_length . " characters";
                    }
                    else
                    {
                        // Check the length of the password
                        $max_password_length = 20;
                        if (strlen($password) > $max_password_length)
                        {
                            $message[] = "Password cannot be longer than " . $max_password_length . " characters";
                        }
                        else
                        {
                            // Check the email format and if the email or nickname already exists
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, "@") === false || strpos($email, ".") === false)
                            {
                                $message[] = "Invalid email format";
                            }
                            else
                            {
                                ($select = mysqli_query($conn, "SELECT * FROM `registration` WHERE email = '$email' OR nickname = '$nickname'")) or die("query failed");
                                if (mysqli_num_rows($select) > 0)
                                {
                                    $message[] = "User with this email or nickname already exists";
                                }
                                else
                                {
                                    if ($image_size > 2000000)
                                    {
                                        $message[] = "Image size is too large!";
                                    }
                                    else
                                    {
                                        ($insert = mysqli_query($conn, "INSERT INTO `registration`(firstname, lastname, country, email, nickname, password, image) VALUES('$firstname', '$lastname', '$country', '$email', '$nickname', '$password', '$image')")) or die("query failed");

                                        if ($insert)
                                        {
                                            move_uploaded_file($image_tmp_name, $image_folder);
                                            $messageSuccessful[] = "Registered successfully!";
                                        }
                                        else
                                        {
                                            $message[] = "Registration failed!";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   <link rel="stylesheet" href="main.css">

</head>
<body>
   
<div class="register">
<div class="topnav">
        <a href="Main.php">Home</a>
        <a href="Dota2.php">Dota 2</a>
        <a href="CSGO.php">CS:GO</a>
        <a href="Valorant.php">Valorant</a>
        <a href="Minecraft.php">Minecraft</a>
        <a href="LeagueOfLegends.php">League of Legends</a>
        <a href="Searcher.php">Search a Companion</a>
        <div class="topnav-right">
            <a href="Profile.php">My Profile
            <?php if (isset($_SESSION["user_id"]))
{
    $user_id = $_SESSION["user_id"];
    $query = "SELECT * FROM `registration` WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query) or die("Query failed");
    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
        if (empty($row["image"]))
        {
            echo '<img src="img/avatar.png">';
        }
        else
        {
            echo '<img src="uploaded_img/' . $row["image"] . '">';
        }
    }
} ?></a>
        </div>
    </div>
   <form action="" method="post" enctype="multipart/form-data">
      <h3>register now</h3>
      <?php
if (isset($message))
{
    foreach ($message as $message)
    {
        echo '<div class="message">' . $message . "</div>";
    }
}
if (isset($messageSuccessful))
{
    foreach ($messageSuccessful as $messageSuccessful)
    {
        echo '<div class="messageSuccessful">' . $messageSuccessful . "</div>";
    }
}
?>
      <input type="text" name="firstname" placeholder="enter name" class="box" required>
      <input type="text" name="lastname" placeholder="enter surname" class="box" required>
      <input type="text" name="country" placeholder="enter country" class="box" required>
      <input type="email" name="email" placeholder="enter email" class="box" required>
      <input type="text" name="nickname" placeholder="enter nickname" class="box" required>
      <input type="password" name="password" placeholder="enter password" class="box" required>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="Login.php">login now</a></p>
   </form>
</div>
      <div class="author">Author: Eriks Latvels</div>
</body>
</html>
