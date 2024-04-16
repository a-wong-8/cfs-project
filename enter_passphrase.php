<?
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEnteredPassphrase = $_POST['passphrase'];

    function setCookieWithPassphrase($passphrase) {
        setcookie('cfw', md5($passphrase), time() + 30 * 24 * 3600);
    }
    
    if ($userEnteredPassphrase === 'cfw') {
        setCookieWithPassphrase($userEnteredPassphrase);

        header("Location: codes.php");
        exit();
    } else {
        $errorMessage = "Incorrect passphrase. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectd for Schools: Enter Passphrase</title>
    <link rel="icon" type="image/x-icon" href="./favicon.png">
    <link rel="stylesheet" href="./styles.css">
</head>

<header><span>Connectd for Schools</span></header>

<body class="passphrase-body">
    <img class="logo" src=./cfs-logo.png></img>
    <form method="post" action="">
        <label for="passphrase">Enter Passphrase:&nbsp</label>
        <input type="password" id="passphrase" name="passphrase" required>
        <button type="submit">Submit</button>
    </form>
    <?php if (isset($errorMessage)): ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>
</body>

</html>