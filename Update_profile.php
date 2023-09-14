<?php
($conn = mysqli_connect("localhost", "root", "", "test")) or die("connection failed");
session_start();
$user_id = $_SESSION["user_id"];
if (!isset($user_id))
{
    header("location:Login.php");
}
if (isset($_POST["update_profile"]))
{
    $update_firstname = mysqli_real_escape_string($conn, $_POST["update_firstname"]);
    $update_lastname = mysqli_real_escape_string($conn, $_POST["update_lastname"]);
    $update_country = mysqli_real_escape_string($conn, $_POST["update_country"]);
    $update_nickname = mysqli_real_escape_string($conn, $_POST["update_nickname"]);

    $query = mysqli_query($conn, "SELECT * FROM `registration` WHERE id = '$user_id'");
    $row = mysqli_fetch_assoc($query);

    $changes = [];

    if ($row["firstname"] != $update_firstname)
    {
        $changes[] = "First Name";
        mysqli_query($conn, "UPDATE `registration` SET firstname = '$update_firstname' WHERE id = '$user_id'") or die("query failed");
    }

    if ($row["lastname"] != $update_lastname)
    {
        $changes[] = "Last Name";
        mysqli_query($conn, "UPDATE `registration` SET lastname = '$update_lastname' WHERE id = '$user_id'") or die("query failed");
    }

    if ($row["country"] != $update_country)
    {
        $changes[] = "Country";
        mysqli_query($conn, "UPDATE `registration` SET country = '$update_country' WHERE id = '$user_id'") or die("query failed");
    }

    if ($row["nickname"] != $update_nickname)
    {
        $changes[] = "Nickname";
        mysqli_query($conn, "UPDATE `registration` SET nickname = '$update_nickname' WHERE id = '$user_id'") or die("query failed");
    }

    if (!empty($changes))
    {
        $messageSuccessful[] = implode(", ", $changes) . " updated successfully!";
    }

    $old_pass = $_POST["old_pass"];
    $new_update_pass = mysqli_real_escape_string($conn, $_POST["update_pass"]);
    $new_new_pass = mysqli_real_escape_string($conn, $_POST["new_pass"]);
    $new_confirm_pass = mysqli_real_escape_string($conn, $_POST["confirm_pass"]);

    if (!empty($new_update_pass) || !empty($new_new_pass) || !empty($new_confirm_pass))
    {
        if ($new_update_pass != $old_pass)
        {
            $message[] = "old password not matched!";
        }
        elseif ($new_new_pass != $new_confirm_pass)
        {
            $message[] = "confirm password not matched!";
        }
        else
        {
            if (empty($new_new_pass) || empty($new_confirm_pass))
            {
                $message[] = "cannot be empty password!";
            }
            else
            {
                mysqli_query($conn, "UPDATE `registration` SET password = '$new_confirm_pass' WHERE id = '$user_id'") or die("query failed");
                $messageSuccessful[] = "password updated successfully!";
            }
        }
    }

    $uploaded_image = $_FILES["new_image"]["name"];
    $uploaded_image_size = $_FILES["new_image"]["size"];
    $uploaded_image_tmp_name = $_FILES["new_image"]["tmp_name"];
    $uploaded_image_folder = "uploaded_img/" . $uploaded_image;

    if (!empty($uploaded_image))
    {
        if ($uploaded_image_size > 2000000)
        {
            $message[] = "image is too large";
        }
        else
        {
            ($image_update_query = mysqli_query($conn, "UPDATE `registration` SET image = '$uploaded_image' WHERE id = '$user_id'")) or die("query failed");
            if ($image_update_query)
            {
                move_uploaded_file($uploaded_image_tmp_name, $uploaded_image_folder);
            }
            $messageSuccessful[] = "image updated succssfully!";
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
   <title>Update profile</title>
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
   <?php
($select = mysqli_query($conn, "SELECT * FROM `registration` WHERE id = '$user_id'")) or die("query failed");
if (mysqli_num_rows($select) > 0)
{
    $fetch = mysqli_fetch_assoc($select);
}
?>
   <form action="" method="post" enctype="multipart/form-data">
        <h3>update personal profile</h3>
      <?php
if ($fetch["image"] == "") {
    echo '<img src="img/avatar.png">';
} else {
    echo '<img src="uploaded_img/' . $fetch["image"] . '">';
}
if (!empty($message)) {
    foreach ($message as $msg) {
        echo '<div class="message">' . $msg . "</div>";
    }
}
if (!empty($messageSuccessful)) {
    foreach ($messageSuccessful as $msgSucc) {
        echo '<div class="messageSuccessful">' . $msgSucc . "</div>";
    }
}
?>
      <div class="flex">
         <div class="input">
            <span>First Name:</span>
            <input type="text" name="update_firstname" value="<?php echo $fetch["firstname"]; ?>" class="box">
            <span>Your country:</span>
            <input type="country" name="update_country" value="<?php echo $fetch["country"]; ?>" class="box">
            <span>Your nickname:</span>
            <input type="nickname" name="update_nickname" value="<?php echo $fetch["nickname"]; ?>" class="box">
            <span>Update your picture:</span>
            <input type="file" name="new_image" accept="image/png, image/jpeg, image/jpg" class="box">
         </div>
         <div class="input">
            <span>Last Name:</span>
            <input type="text" name="update_lastname" value="<?php echo $fetch["lastname"]; ?>" class="box">
            <input type="hidden" name="old_pass" value="<?php echo $fetch["password"]; ?>">
            <span>Old password:</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>New password:</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>Confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <input type="submit" value="update profile" name="update_profile" class="btn">
      <a href="Profile.php" class="delete-btn">go back</a>
   </form>
</div>
<div class="author">Author: Eriks Latvels</div>
</body>
</html>
