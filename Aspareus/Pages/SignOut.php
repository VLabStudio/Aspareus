<?php

  if (!isset($_SESSION))
   {
     session_start();
   }
    // Remove all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    header('Location: SignIn.php');
?>
