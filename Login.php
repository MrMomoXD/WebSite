<?php
($conn = mysqli_connect("localhost", "root", "", "test")) or die("connection failed");
session_start();

if (isset($_POST["submit"]))
{
    $email_or_nickname = mysqli_real_escape_string($conn, $_POST["email_or_nickname"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    ($select = mysqli_query($conn, "SELECT * FROM `registration` WHERE (email = '$email_or_nickname' OR nickname = '$email_or_nickname') AND password = '$password'")) or die("query failed");

    if (mysqli_num_rows($select) > 0)
    {
        $row = mysqli_fetch_assoc($select);
        $_SESSION["user_id"] = $row["id"];
        header("location:Main.php");
    }
    else
    {
        $message[] = "Incorrect email/nickname or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="main.css">

</head>

<body>
    <div class="login">
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
} ?>
                </a>
            </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Sign in or <a href="Register.php">Sign up</a></h3>
            <?php if (isset($message))
{
    foreach ($message as $message)
    {
        echo '<div class="message">' . $message . "</div>";
    }
} ?>
            <input type="text" name="email_or_nickname" placeholder="enter email or nickname" class="box" required>
            <input type="password" name="password" placeholder="enter password" class="box" required>
            <input type="submit" name="submit" value="login now" class="btn">
            <p>forgot password? <a href="Restore.php">remember me</a></p>
            <div class="author">Author: Eriks Latvels</div>
        </form>
    </div>
</body>

</html>
