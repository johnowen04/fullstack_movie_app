<?php
    require_once("class/coba.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $ujiCoba = new coba();
        $ujiCoba->setValue("nilai baru lagi");
        $ujiCoba->displayData();
    ?>
</body>
</html>