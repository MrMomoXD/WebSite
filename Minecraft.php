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
    <title>Minecraft</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="topnav">
        <a href="Main.php">Home</a>
        <a href="Dota2.php">Dota 2</a>
        <a href="CSGO.php">CS:GO</a>
        <a href="Valorant.php">Valorant</a>
        <a class="active" href="Minecraft.php">Minecraft</a>
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
            <h1>Brief information about <a href="https://en.wikipedia.org/wiki/Minecraft" target="_blank">Minecraft</a></h1>
            <p>Minecraft is a popular sandbox video game developed by Mojang Studios. It was first released in 2011 and is available on multiple platforms, including Windows, macOS, Linux, Xbox, PlayStation, Nintendo Switch, and mobile devices.</p>
            <p>In Minecraft, players explore and interact with a procedurally generated 3D world, made up of blocks that represent various materials and objects. Players can gather resources, such as wood and stone, to craft tools, weapons, and structures, which can be used to survive and thrive in the game's open world. The game features different modes, including survival mode, where players must manage hunger and health while avoiding dangerous creatures, and creative mode, which allows players to build and create without restrictions.</p>
            <p>Minecraft has a massive player base and a strong community of modders and content creators, who have created countless mods, texture packs, and custom maps that can be downloaded and used in the game. Minecraft has also been used as an educational tool, with versions of the game specifically designed for classroom use to teach subjects such as programming and history.</p>
            <iframe width="800" height="345" src="https://www.youtube.com/embed/HgjO8sOmQrM">
</iframe>
        </div>
    </div>
    <div class="author">Author: Eriks Latvels</div>
</body>
</html>
