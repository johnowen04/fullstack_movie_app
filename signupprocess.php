<?php
require_once('class/user.php');

if(isset($_POST['btnSignup'])) {
    if($_POST['txtPassword'] == $_POST['txtUlangiPassword']) {
        $objUser = new user();
        
        $hasil = $objUser->signup($_POST['txtNama'], $_POST['txtUsername'], $_POST['txtPassword']);

        if ($hasil) {
            header("location: signup.php?success=".$hasil);
        } else {
            header("location: signup.php?success=0");
        }
        
    } else {
        header("location: signup.php?err=1");
    }
}