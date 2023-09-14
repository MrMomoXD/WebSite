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
    <title>Dota 2</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div class="topnav">
        <a href="Main.php">Home</a>
        <a class="active" href="Dota2.php">Dota 2</a>
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
    <div class="games">
        <div class="profile">
            <h1>Brief information about <a href="https://en.wikipedia.org/wiki/Dota_2" target="_blank">Dota 2</a></h1>
            <p>Dota 2 is a popular multiplayer online battle arena (MOBA) game developed by Valve Corporation. It is the
                sequel to Defense of the Ancients (DotA), a community-created mod for Blizzard Entertainment's Warcraft
                III: Reign of Chaos. Dota 2 is free-to-play and is available on Windows, Linux, and macOS.</p>
            <p>In Dota 2, two teams of five players compete to destroy each other's ancient, a heavily fortified
                structure located at opposite corners of the map. Each player controls a hero with unique abilities and
                plays a specific role, such as carry, support, or initiator. Players gain experience and gold by killing
                enemy units, completing objectives, and destroying enemy structures, which can be used to buy items and
                upgrade their hero's abilities.</p>
            <p>Dota 2 is known for its deep strategic gameplay, fast-paced action, and competitive scene. It has a large
                and passionate player base, with regular updates and new heroes added to the game. The game is also
                famous for its annual tournament, "The International," which has a multi-million dollar prize pool and
                attracts players and fans from around the world.</p>
            <iframe width="800" height="345" src="https://www.youtube.com/embed/m5sjA6W3nPw">
            </iframe>
        </div>
    </div>
    <div class="author">Author: Eriks Latvels</div>
</body>

</html>
