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
    <title>CS:GO</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div class="topnav">
        <a href="Main.php">Home</a>
        <a href="Dota2.php">Dota 2</a>
        <a class="active" href="CSGO.php">CS:GO</a>
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
            <h1>Brief information about <a href="https://en.wikipedia.org/wiki/Counter-Strike:_Global_Offensive"
                    target="_blank">CS:GO</a></h1>
            <p>Counter-Strike: Global Offensive (CS:GO) is a popular first-person shooter game developed by Valve
                Corporation. It is the fourth game in the Counter-Strike series and was released in 2012. CS:GO is
                available on Windows, macOS, Linux, Xbox 360, and PlayStation 3.</p>
            <p>In CS:GO, two teams, terrorists and counter-terrorists, compete in various game modes, such as bomb
                defusal and hostage rescue. Each player starts each round with a set amount of money to buy weapons and
                equipment, and players earn more money by completing objectives and winning rounds. The game is known
                for its emphasis on tactical gameplay, precise aiming, and skillful teamwork.</p>
            <p>CS:GO has a thriving esports scene, with multiple professional leagues and tournaments held throughout
                the year. The game's competitive matchmaking system allows players to compete against other players of
                similar skill levels and ranks, with the ultimate goal of reaching the highest rank, Global Elite. CS:GO
                also has a large community of modders and custom map creators, who have contributed to the game's
                longevity and popularity.</p>
            <iframe width="800" height="345" src="https://www.youtube.com/embed/0PPPsA3zHTI">
            </iframe>
        </div>
    </div>
    <div class="author">Author: Eriks Latvels</div>
</body>
</html>
