<?php
session_start();
// Connect to the database
($conn = mysqli_connect("localhost", "root", "", "test")) or
    die("Connection failed");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="topnav">
        <a class="active" href="Main.php">Home</a>
        <a href="Dota2.php">Dota 2</a>
        <a href="CSGO.php">CS:GO</a>
        <a href="Valorant.php">Valorant</a>
        <a href="Minecraft.php">Minecraft</a>
        <a href="LeagueOfLegends.php">League of Legends</a>
        <a href="Searcher.php">Search a Companion</a>
        <div class="topnav-right">
            <a href="Profile.php">My Profile
            <?php    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];
        $query = "SELECT * FROM `registration` WHERE id = '$user_id'";
        $result = mysqli_query($conn, $query) or die("Query failed");
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (empty($row["image"])) {
                echo '<img src="img/avatar.png">';
            } else {
                echo '<img src="uploaded_img/' . $row["image"] . '">';
            }
        }
    } ?></a>
        </div>
    </div>
    <div class="main">
        <div class="profile">
            <h1>Welcome to Author's web application for finding game companions!</h1>
            <p>Do you have trouble finding people to play online games with? Are you tired of searching through social networks or forums with no luck? Look no further, because Author's application is here to help you!</p>
            <p>With Author's easy-to-use interface, you can quickly and easily find other players to team up with for your favorite online games such as Dota2, CS:GO, Valorant, Minecraft, and League of Legends. You can search for players and sort them by hours, making it simple to find someone to play with at any time.</p>
            <p>But that's not all - Author's application also allows you to create a personal and gaming profile, so other users can learn more about you and your gaming preferences. You can also communicate with other players through Author's messaging system, making it easy to coordinate game sessions and strategies.</p>
            <p>To get started, simply create an account or log in to your existing one. Author's platform is user-friendly and accessible via any web browser, so you can use it wherever and whenever you want.</p>
            <p>Don't let a lack of gaming companions hold you back from enjoying your favorite online games. Try Author's web application today and find your perfect gaming companion!</p>
        </div>
    </div>
    <div class="author">Author: Eriks Latvels</div>
</body>
</html>