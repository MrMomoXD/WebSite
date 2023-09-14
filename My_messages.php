<?php
session_start();
if (!isset($_SESSION["user_id"]))
{
    header("Location: Login.php");
    exit();
}
$user_id = $_SESSION["user_id"];

($conn = mysqli_connect("localhost", "root", "", "test")) or die("Connection failed");
if(isset($_GET['nickname'])) {
  $sql = "SELECT * FROM `usergame` WHERE UserId = '$user_id'";
  $result = mysqli_query($conn, $sql);

  // Check if user exists in database
  if(mysqli_num_rows($result) > 0) {
    // User exists, redirect to comments page
     header('location:My_messages.php');
  } else {
    // User doesn't exist, redirect to profile page with error message
    header('location:Profile.php?error=user_not_found');
  }
}
// Check if the user has selected a recipient nickname
if (isset($_POST["show"]))
{
    $recipient_id = $_POST["recipient_id"];

    // Fetch all messages between the logged-in user and the selected recipient
    ($select_messages = mysqli_query($conn, "SELECT m.message, r.nickname, m.sender_id FROM messages m JOIN registration r ON m.sender_id = r.id WHERE (m.sender_id = '$user_id' AND m.recipient_id = (SELECT id FROM registration WHERE nickname = '$recipient_id')) OR (m.sender_id = (SELECT id FROM registration WHERE nickname = '$recipient_id') AND m.recipient_id = '$user_id') ORDER BY m.id ASC")) or die("Query failed");

    $results = "";
    if (mysqli_num_rows($select_messages) > 0)
    {
        while ($fetch_messages = mysqli_fetch_assoc($select_messages))
        {
            $nickname = $fetch_messages["nickname"];
            $message = $fetch_messages["message"];
            $sender_id = $fetch_messages["sender_id"];

            if ($sender_id == $user_id)
            {
                // Message is from the logged-in user
                $results .= "<div class='flex' style='justify-content: flex-end;'>
                    <input type='text' name='Nickname' value='" . substr($message, 0, 50) . "' class='boxsender' style='width: 320px; height: 40px; overflow: auto;'>

                    <span class='sender'>:$nickname</span>
                </div>";
            }
            else
            {
                // Message is from the recipient
                $results .= "<div class='flex' style='justify-content: flex-start;'>
                    <span class='recipient'>$nickname:</span>
                    <input type='text' name='Nickname' value='" . substr($message, 0, 50) . "' class='boxrecipient' style='width: 320px; height: 40px; overflow: auto;'>

                </div>";
            }
        }
    }
    else
    {
        $results = "<div>You have no messages with this user.</div>";
    }
    $messagesend = "<div class='flex'>
                    <textarea name='message' class='flex-container'></textarea>
                        <input class='small-button' type='submit' name='send' value='Send' style='justify-content: flex-end;'>
                </div>";
}

// Fetch all users from the `registration` table
($select_users = mysqli_query($conn, "SELECT Nickname FROM `usergame` GROUP BY Nickname")) or die("Query failed");

$options = "";
if (mysqli_num_rows($select_users) > 0)
{
    while ($fetch_users = mysqli_fetch_assoc($select_users))
    {
        $nickname = $fetch_users["Nickname"];
        $selected = "";
        if (isset($_POST["recipient_id"]))
        {
            $selected = $nickname == $_POST["recipient_id"] ? "selected" : "";
        }
        $user_option = "<option value='$nickname' $selected>$nickname</option>";
        $options .= $user_option;
    }
}

if (isset($_POST["send"]))
{
    $recipient_id = $_POST["recipient_id"];
    $message = $_POST["message"];

    // Check if the message field is empty
    if (empty($message))
    {
        $messageFail[] = "Please enter a message";
    }
    elseif (strlen($message) > 50)
    {
        $messageFail[] = "Message cannot be longer than 50 characters";
    }
    else
    {
        // Check if the recipient is not the logged-in user
        ($select_recipient = mysqli_query($conn, "SELECT id FROM registration WHERE nickname = '$recipient_id'")) or die("Query failed");
        $recipient_row = mysqli_fetch_assoc($select_recipient);
        $recipient_id = $recipient_row["id"];
        if ($recipient_id == $user_id)
        {
            $messageFail[] = "You cannot send a message to yourself";
        }
        else
        {
            // Insert the message into the database
            $query = "INSERT INTO messages (sender_id, recipient_id, message) VALUES ('$user_id', '$recipient_id', '$message')";
            if (mysqli_query($conn, $query))
            {
                $messageSuccessful[] = "Message sent successfully!";
            }
            else
            {
                $messageFail[] = "Error sending message, choose someone";
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
    <title>My Messages</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="my-messages">
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
    <h3>My Messages</h3>
    <?php
if (isset($messageFail))
{
    foreach ($messageFail as $messageFail)
    {
        echo '<div class="message">' . $messageFail . "</div>";
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
    <div class="my-messages-select">
       <select name="recipient_id" id="recipient_id">
                    <?php echo $options; ?>
                </select>
    </div>
    <input type="submit" name="show" value="Show" class="btn">
      <a href="Profile.php" class="delete-btn">go back</a>
      <div class="author">Author: Eriks Latvels</div>
        <div class="messages">
            <?php if (isset($results))
{
    echo $results;
} ?>
            <?php if (isset($messagesend))
{
    echo $messagesend;
} ?> 
  </div>
  </form>
</div>
<div class="author">Author: Eriks Latvels</div>
</body>
</html>
