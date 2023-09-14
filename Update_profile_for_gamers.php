<?php
($conn = mysqli_connect("localhost", "root", "", "test")) or die("connection failed");
session_start();
$user_id = $_SESSION["user_id"];
if (!isset($user_id))
{
    header("location:Login.php");
}
if (isset($_POST["submit"]))
{
    $usergame = $_POST["usergame"];
    if (empty($_POST["nickname"]))
    {
        ($select_nickname = mysqli_query($conn, "SELECT `Nickname` FROM `registration` WHERE `id` = '$user_id'")) or die("query failed");
        if (mysqli_num_rows($select_nickname) > 0)
        {
            $fetch_nickname = mysqli_fetch_assoc($select_nickname);
            $nickname = $fetch_nickname["Nickname"];
        }
        else
        {
            $nickname = "";
        }
    }
    else
    {
        $nickname = $_POST["nickname"];
    }
    $hours = $_POST["hours"];
    $rating = $_POST["rating"];
    $description = $_POST["description"];

    // Check if the user has already added the game
    ($check_game = mysqli_query($conn, "SELECT * FROM `usergame` WHERE `UserId` = '$user_id' AND `UserGame` = '$usergame'")) or die("query failed");
    $row = mysqli_fetch_assoc($check_game);
    $changes = [];
    if (mysqli_num_rows($check_game) > 0)
    {
        $message[] = "You have already added this game";
    }
    else
    {
        // Insert the game
        if (empty($hours))
        {
            $message[] = "Hours field cannot be empty";
        }
        else
        {
            ($insert = mysqli_query($conn, "INSERT INTO `usergame` (`UserId`, `Nickname`, `UserGame`, `Hours`, `Rating`, `Description`) VALUES ('$user_id', '$nickname', '$usergame', '$hours', ' $rating', '$description')")) or die("insert failed");
            if ($insert)
            {
                $messageSuccessful[] = "Game added successfully";
            }
            else
            {
                $message[] = "Game adding failed";
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
   <title>Update Gamer profile</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<div class="profile-update">
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
        <h3>update gaming profile</h3>
    <?php
($select = mysqli_query($conn, "SELECT * FROM `registration` WHERE id = '$user_id'")) or die("query failed");
if (mysqli_num_rows($select) > 0)
{
    $fetch = mysqli_fetch_assoc($select);
}
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
    <div class="profile-select">
      <select name="usergame" id="usergame">
        <option value="Dota2">Dota 2</option>
        <option value="Csgo">CS:GO</option>
        <option value="Valorant">Valorant</option>
        <option value="Minecraft">Minecraft</option>
        <option value="Lol">League of Legends</option>
      </select>
    </div>
    <div class="flex">
      <div class="input">
        <span>Hours:</span>
        <input type="number" name="hours" placeholder="0+" class="box">
      </div> 
      <div class="input">
        <span>Rating:</span>
        <input type="text" name="rating" placeholder="if the game has a rating" class="box">
      </div>
    </div>
    <div class="flex2">
          <span>Description:</span>
        <textarea name="description" placeholder="about yourself or who you are looking for"></textarea>
        </div>
    <input type="submit" value="submit" name="submit" class="btn">
    <a href="Profile.php" class="delete-btn">go back</a>
  </form>
</div>
<div class="author">Author: Eriks Latvels</div>
</body>
</html>
