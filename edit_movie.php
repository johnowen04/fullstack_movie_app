<?php 
	$mysqli = new mysqli("localhost", "root", "", "fullstack_db");

	if ($mysqli->connect_errno) {
		die("Failed to connect to MySQL: ".$mysqli->connect_error);
	}

	$idmovie = $_GET['idmovie'];

	$stmt = $mysqli->prepare("Select * From movie Where idmovie=?");
	$stmt->bind_param('i', $idmovie);
	$stmt->execute();
	$res = $stmt->get_result();  
	$row = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Week 1 - Database Edit Movie</title>
</head>
<body>
	<form method="post" action="editmovie_proses.php">
		Judul:
		<?php echo "<input type='text' name='judul' value='".$row['judul']."' required>";  ?>
		<br><br>
		Tgl Rilis:
		<?php 
			$date = date_create($row['rilis']);
			$date_formatted = date_format($date, "Y-m-d");
			echo "<input type='date' name='rilis' value='".$date_formatted."'>";
		?>
		<br><br>
		Serial:
		<?php 
			if ($row['serial']) {
				echo "<input type='radio' name='serial' value=1 checked> Ya";
				echo "<input type='radio' name='serial' value=0> Tidak";
			} else {
				echo "<input type='radio' name='serial' value=1> Ya";
				echo "<input type='radio' name='serial' value=0 checked> Tidak";
			}
		 ?>
		<br><br>
		Skor:
		<?php echo "<input type='number' name='skor' value=".$row['skor'].">"; ?>
		<br><br>
		Sinopsis:
		<?php echo "<textarea name='sinopsis' col=70 row=6>".$row['sinopsis']."</textarea>"; ?>
		<br><br>
		Genre:
		<select name="genre" required>
			<option value="">-- Pilih Genre --</option>
			<option value="Action">Action</option>
			<option value="Comedy">Comedy</option>
			<option value="Horror">Horror</option>
			<option value="Thriller">Thriller</option>
		</select>
		<br><br>
		<input type=submit name="submit" value="Simpan">
	</form>
</body>
</html>
<?php
	$mysqli->close();
?>