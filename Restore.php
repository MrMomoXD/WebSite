<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    // retrieve email from form submission
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

    if ($email)
    {
        // connect to database
        $conn = mysqli_connect("localhost", "root", "", "test");
        if (!$conn)
        {
            die("Connection failed: " . mysqli_connect_error());
        }

        // retrieve password associated with email
        $sql = "SELECT nickname, password FROM `registration` WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $password = $row ? $row["password"] : null;

        if ($password)
        {
            // send password to user's email address
            $to = $email;
            $subject = "Password Recovery";
            $message = "Your nickname is: " . $row["nickname"] . PHP_EOL . "Your password is: " . $row["password"];
            $headers = "From: ffinder1199@gmail.com";
            mail($to, $subject, $message, $headers);

            // display success message
            $messageSuccessful[] = "Nickname and password sent to email";
        }
        else
        {
            // display error message if email not found in database  gufik0109@inbox.lv
            $message[] = "Email not found";
        }

        // close database connection
        mysqli_close($conn);
    }
    else
    {
        // display error message if email not valid
        $message[] = "Invalid email";
    }
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Password Recovery</title>
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
} ?></a>
        </div>
    </div>
   <form action="" method="post" enctype="multipart/form-data">
      <h3>Password recovery</h3>
      <?php if (isset($message) && is_array($message))
{
    foreach ($message as $message)
    {
        echo '<div class="message">' . $message . "</div>";
    }
}
elseif (isset($messageSuccessful))
{
    foreach ($messageSuccessful as $messageSuccessful)
    {
        echo '<div class="messageSuccessful">' . $messageSuccessful . "</div>";
    }
} ?>
      <input type="email" name="email" placeholder="enter email" class="box" required>
      <input type="submit" name="submit" value="Restore" class="btn">
      <p>remembered the password? <a href="Login.php">back</a></p>
      <div class="author">Author: Eriks Latvels</div>
   </form>
</body>
</html>
