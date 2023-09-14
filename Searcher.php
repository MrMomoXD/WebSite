<?php
($conn = mysqli_connect("localhost", "root", "", "test")) or die("connection failed");
session_start();
if (!isset($_SESSION["user_id"]))
{
    header("Location: Login.php");
    exit();
}
$user_id = $_SESSION["user_id"];

($select = mysqli_query($conn, "SELECT * FROM `registration` WHERE id = '$user_id'")) or die("query failed");
if (mysqli_num_rows($select) > 0)
{
    $fetch = mysqli_fetch_assoc($select);
}
// check if sorting order is specified in the URL
$sorting_order = "";
if (isset($_GET["sorting_order"]))
{
    $sorting_order = $_GET["sorting_order"];
}
$result = "";
if (isset($_POST["submit"]) && isset($_POST["usergame"]))
{
    $usergame = $_POST["usergame"];
    $result = "<div class='flex'><div class='input'>
                        <span>Game: " . $usergame . "</span>
                    </div></div>
        <div class='flex'>
                    <div class='input'>
                        <span>Nickname:</span>
                    </div>
                    <div class='input'>
                        <span><a href='Searcher.php?sorting_order=" . ($sorting_order === "asc" ? "desc" : "asc") . "'>Hours:</a></span>
                    </div>
                    <div class='input'>
                        <span>Rating:</span>
                    </div>
                    <div class='input'>
                        <span>Description :</span>
                    </div>
                    <div class='input'>
                        <span>Send message:</span>
                    </div>
                </div>";

    // construct the SQL query with sorting order
    $sql_query = "SELECT * FROM `usergame` WHERE UserGame = '$usergame'";
    if ($sorting_order === "asc")
    {
        $sql_query .= " ORDER BY Hours ASC";
        $messageSuccessful[] = "Sorted from low to high";
    }
    elseif ($sorting_order === "desc")
    {
        $sql_query .= " ORDER BY Hours DESC";
        $messageSuccessful[] = "Sorted from high to low";
    }
    ($select2 = mysqli_query($conn, $sql_query)) or die("query failed");

    $results = "";
    if (mysqli_num_rows($select2) > 0)
    {
        while ($fetch2 = mysqli_fetch_assoc($select2))
        {
            $results .= "<div class='flex'>
                            <div class='input'>
                                <input type='text' name='Nickname' value='" . $fetch2["Nickname"] . "' class='box' readonly>
                            </div>
                            <div class='input'>
                                <input type='text' name='Hours' value='" . $fetch2["Hours"] . "' class='box' readonly>
                            </div>
                            <div class='input'>
                                <input type='text' name='Rating' value='" . $fetch2["Rating"] . "' class='box' readonly>
                            </div>
                            <div class='input'>
                                <input type='text' name='Description' value='" . $fetch2["Description"] . "' class='box' readonly>
                            </div>
                            <div class='input'>
                                <a href='My_messages.php?nickname=" . $fetch2["Nickname"] . "'>
                                    <img src='message/message.png'>
                                </a>
                            </div>
                        </div>";
        }
    }
    if ($results == "")
    {
        $message[] = "No one is playing " . $usergame;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Searcher</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<div class="searcher">
    <div class="topnav">
        <a href="Main.php">Home</a>
        <a href="Dota2.php">Dota 2</a>
        <a href="CSGO.php">CS:GO</a>
        <a href="Valorant.php">Valorant</a>
        <a href="Minecraft.php">Minecraft</a>
        <a href="LeagueOfLegends.php">League of Legends</a>
        <a class="active" href="Searcher.php">Search a Companion</a>
        <div class="topnav-right">
            <a href="Profile.php">My Profile
            <?php
if (isset($_SESSION["user_id"]))
{
    // Retrieve the user's profile image
    $user_id = $_SESSION["user_id"];
    $select_query = "SELECT * FROM `registration` WHERE id = '$user_id'";
    $select_result = mysqli_query($conn, $select_query) or die("Query failed");
    if (mysqli_num_rows($select_result) > 0)
    {
        $fetch = mysqli_fetch_assoc($select_result);
        if ($fetch["image"] == "")
        {
            echo '<img src="img/avatar.png">';
        }
        else
        {
            echo '<img src="uploaded_img/' . $fetch["image"] . '">';
        }
    }
}
?></a>
        </div>
    </div>
  <form action="" method="post" enctype="multipart/form-data">
    <h3>Searcher</h3>
    <?php if (isset($message))
{
    foreach ($message as $message)
    {
        echo '<div class="message-small">' . $message . "</div>";
    }
}
if (isset($messageSuccessful))
{
    foreach ($messageSuccessful as $messageSuccessful)
    {
        echo '<div class="messageSuccessful">' . $messageSuccessful . "</div>";
    }
} ?>
    <div class="searcher-select">
      <select name="usergame" id="usergame">
        <option value="Dota2">Dota 2</option>
        <option value="Csgo">CS:GO</option>
        <option value="Valorant">Valorant</option>
        <option value="Minecraft">Minecraft</option>
        <option value="Lol">League of Legends</option>
      </select>
    </div>
      <input type="submit" name="submit" value="Show" class="btn">
      <a href="Profile.php" class="delete-btn">go back</a>
            <?php
if (isset($result))
{
    echo $result;
}
if (isset($results))
{
    echo $results;
}
?>
      <div class="author">Author: Eriks Latvels</div>
       </form>
</div>
</body>
</html>
