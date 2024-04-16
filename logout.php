<?php
// Function to clear the cookie
function clearCookie() {
    setcookie('cfw', '', time() - 1);
}

// Clear the cookie when the user logs out
clearCookie();

header('Location: enter_passphrase.php');
exit();
?>
