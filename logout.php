<?php
session_start();        // Start the session so PHP knows what to destroy
session_destroy();      // Destroy all session data (log the user out)
header("Location: login.php");  // Send the user back to the login page
exit;
