<?php
session_start();

// Connect to the database
($conn = mysqli_connect("localhost", "root", "", "test")) or die("Connection failed");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League of Legends</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="topnav">
        <a href="Main.php">Home</a>
        <a href="Dota2.php">Dota 2</a>
        <a href="CSGO.php">CS:GO</a>
        <a href="Valorant.php">Valorant</a>
        <a href="Minecraft.php">Minecraft</a>
        <a class="active" href="LeagueOfLegends.php">League of Legends</a>
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
    <div class="games">
        <div class="profile">
            <h1>Brief information about <a href="https://en.wikipedia.org/wiki/League_of_Legends" target="_blank">League of Legends</a></h1>
            <p>League of Legends (LoL) is a multiplayer online battle arena (MOBA) game developed and published by Riot Games. It was first released in 2009 and is available on Windows and macOS.</p>
            <p>In League of Legends, two teams of five players compete against each other, each team occupying a base at opposite corners of the map. The objective is to destroy the opposing team's Nexus, a structure located in their base, while defending your own. Each player controls a champion with unique abilities and plays a specific role, such as tank, mage, or marksman. Players gain gold and experience by killing minions and opposing champions, which can be used to buy items and upgrade their champion's abilities.</p>
            <p>League of Legends is known for its deep strategic gameplay, fast-paced action, and large selection of champions. The game has a thriving esports scene, with professional leagues and tournaments held throughout the year, including the annual World Championship, which has a multi-million dollar prize pool. Riot Games also releases regular updates and new content for the game, such as new champions, skins, and game modes, to keep the game fresh and engaging for players.</p>
            <iframe width="800" height="345" src="https://www.youtube.com/embed/BGtROJeMPeE">
</iframe>
        </div>
    </div>
    <div class="author">Author: Eriks Latvels</div>
</body>
</html>
