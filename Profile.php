<?php
// start the session
session_start();

// if user wants to logout, destroy the session and redirect to login page
if (isset($_GET['logout']))
{
    session_unset();
    session_destroy();
    header('Location: Login.php');
    exit();
}

// if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id']))
{
    header('Location: Login.php');
    exit();
}
if(isset($_GET['error']) && $_GET['error'] == 'user_not_found') {
  $message = 'Complete gamer profile';
}
// connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'test') or die('Connection failed');

// get the user id from the session
$user_id = $_SESSION['user_id'];

// fetch the user data from the database
$select = mysqli_query($conn, "SELECT * FROM `registration` WHERE id = '$user_id'") or die('Query failed');

// if user data is found, display it on the profile page
if (mysqli_num_rows($select) > 0)
{
    $fetch = mysqli_fetch_assoc($select);
}

if (isset($_POST['my_messages']))
{
    // check if user's nickname is in the usergame table
    $nickname = $fetch['nickname'];
    $select_usergame = mysqli_query($conn, "SELECT * FROM `usergame` WHERE Nickname = '$nickname'") or die('Query failed');
    if (mysqli_num_rows($select_usergame) > 0)
    {
        // display a button that links to My_messages.php
        header('location:My_messages.php');
    }
    else
    {
        $message = 'Complete gamer profile';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="myprofile">
        <div class="topnav">
        <a href="Main.php">Home</a>
        <a href="Dota2.php">Dota 2</a>
        <a href="CSGO.php">CS:GO</a>
        <a href="Valorant.php">Valorant</a>
        <a href="Minecraft.php">Minecraft</a>
        <a href="LeagueOfLegends.php">League of Legends</a>
        <a href="Searcher.php">Search a Companion</a>
        <div class="topnav-right">
            <a class="active" href="Profile.php">My Profile
            <?php
if (isset($_SESSION["user_id"]))
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
            <div class="profile">
                <?php
// display the user's avatar
if ($fetch['image'] == '')
{
    echo '<img src="img/avatar.png">';
}
else
{
    echo '<img src="uploaded_img/' . $fetch['image'] . '">';
}
// display the user's nickname
echo '<h3>' . $fetch['nickname'] . '</h3>';
if (isset($message))
{
    echo '<div class="message">' . $message . '</div>';
}
?>
                <input type="submit" value="My messages" name="my_messages" class="btn">
               <?php

// display buttons for the user to manage his profile
echo '<a href="Update_profile.php" class="btn">Update personal profile</a>';
// display buttons for the user to manage his gamer profile
echo '<a href="Update_profile_for_gamers.php" class="btn">Update gamer profile</a>';

// display a logout button
echo '<a href="Profile.php?logout=1" class="delete-btn">Logout</a>';
?>
            </div>
        </form>
    </div>
    <div class="author">Author: Eriks Latvels</div>
</body>
</html>
