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
    <title>Valorant</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="topnav">
        <a href="Main.php">Home</a>
        <a href="Dota2.php">Dota 2</a>
        <a href="CSGO.php">CS:GO</a>
        <a class="active" href="Valorant.php">Valorant</a>
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
    <div class="games">
        <div class="profile">
            <h1>Brief information about <a href="https://en.wikipedia.org/wiki/Valorant" target="_blank">Valorant</a></h1>
            <p>Valorant is a team-based tactical shooter game developed and published by Riot Games. It was released in 2020 and is available on Microsoft Windows.</p>
            <p>In Valorant, two teams of five players compete against each other in rounds, with each round lasting up to two minutes. One team plays as the attackers, attempting to plant a bomb called the Spike, while the other team plays as defenders, trying to prevent the attackers from planting the Spike or defusing it if it's already planted. The first team to win 13 rounds wins the match.</p>
            <p>Players choose from a roster of unique characters, known as agents, each with their own set of abilities that can be used to gain an advantage over the opposing team. Players earn money throughout the game, which can be used to purchase weapons, shields, and abilities.</p>
            <p>Valorant is known for its precise gunplay, strategic gameplay, and emphasis on team communication and coordination. It also has an esports scene, with multiple tournaments and leagues held throughout the year. Riot Games has also been active in releasing regular updates and new content for the game, such as new agents, maps, and game modes, to keep the game fresh and engaging for players.</p>
            <iframe width="800" height="345" src="https://www.youtube.com/embed/9omyVqrXhOg">
</iframe>
        </div>
    </div>
    <div class="author">Author: Eriks Latvels</div>
</body>
</html>
