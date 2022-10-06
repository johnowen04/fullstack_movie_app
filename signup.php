<?php
if(isset($_GET['err'])) {
    if($_GET['err']) {
        echo "Password tidak sama";
    }
}

if (isset($_GET['success'])) {
    if ($_GET['success']) {
        echo "Registrasi berhasil";
    } else {
        echo "Registrasi gagal";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>

<body>
    <form action="signupprocess.php" method="post">
        <p>
            <label>Nama:</label>
            <input type="text" name="txtNama">
        </p>

        <p>
            <label>Username:</label>
            <input type="text" name="txtUsername">
        </p>

        <p>
            <label>Password:</label>
            <input type="password" name="txtPassword">
        </p>

        <p>
            <label>Ulangi Password:</label>
            <input type="password" name="txtUlangiPassword">
        </p>

        <p>
            <input type="submit" name="btnSignup" value="Sign Up">
        </p>
    </form>
</body>

</html>