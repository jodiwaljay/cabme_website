<?php
//$to = "mailhostingserver@gmail.com";
$to = "sujithreddy.212@gmail.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "tabrezullakhan13@cabme.in";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?>
