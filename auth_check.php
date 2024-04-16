<?php

function checkCookie() {
    return isset($_COOKIE['cfw']);
}

if (!checkCookie()) {
    header("Location: enter_passphrase.php");
    exit();
}

?>