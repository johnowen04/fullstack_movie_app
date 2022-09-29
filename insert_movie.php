<?php 
	$mysqli = new mysqli("localhost", "root", "", "fullstack_db");

	if ($mysqli->connect_errno) {
		die("Failed to connect to MySQL: ".$mysqli->connect_error);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Week 1 - Database Insert Movie</title>
	<script
	  src="https://code.jquery.com/jquery-3.6.0.min.js"
	  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
	  crossorigin="anonymous"></script>
</head>
<body>
	<form method="post" action="insertmovie_proses.php" enctype="multipart/form-data">
		Judul:
		<input type="text" name="judul" required>
		<br><br>
		Tgl Rilis:
		<input type="date" name="rilis">
		<br><br>
		Serial:
		<input type="radio" name="serial" value=1> Ya
		<input type="radio" name="serial" value=0> Tidak
		<br><br>
		Skor:
		<input type="number" name="skor">
		<br><br>
		Sinopsis:
		<textarea name="sinopsis" col=70 row=6></textarea>
		<br><br>
		Genre:
		<?php 
			$res = $mysqli->query("SELECT * FROM genre");
			while($row = $res->fetch_assoc()) {
				echo "<input type='checkbox' name='genre[]' value='".$row['idgenre']."'>".$row['nama']."";
			}
		?>
		<br><br>
		Poster:
		<div id='files'>
			<div>
				<img src='img/1.jpg' class='gambar'>
				<input type='file' name='poster[]' accept='.jpg,.png'><input type='button' class='btnHapusGambar' value='Hapus'>
			</div>
		</div>
		<br>
		<input type="button" id="btnTambahGambar" value="Tambah Gambar">
		<br><br>
		Pemain:
		<select id="selPemain">
			<option value="">-- Pilih Pemain --</option>
			<?php 
				$res = $mysqli->query("SELECT * FROM pemain");
				while($row = $res->fetch_assoc()) {
					echo "<option value='".$row['idpemain']."'>".$row['nama']."";
				}
			?>
		</select>
		<select id="selPeran">
			<option value="">--Pilih Peran--</option>
			<option value="Utama">Utama</option>
			<option value="Pembantu">Pembantu</option>
			<option value="Cameo">Cameo</option>
		</select>
		<input type="button" id="btnTambahPemain" value="Tambah Pemain">
		<br>
		<table border="1">
			<thead>
				<tr> <th>Pemain</th> <th>Peran</th> <th>Aksi</th> </tr>
			</thead>
			<tbody id="tblBody">
				
			</tbody>
		</table>
		<br><br>
		<input type=submit name="submit" value="Simpan">
	</form>
	<script type="text/javascript">
		$("#btnTambahGambar").click(function() {
			var new_control = "<div><input type='file' name='poster[]' accept='.jpg,.png'><input type='button' class='btnHapusGambar' value='Hapus'></div>";
			$("#files").append(new_control);
		});

		//$(".btnHapusGambar").click(function() {
		$("body").on("click", ".btnHapusGambar", function() {
			// $(this).parent().remove();
			$('.gambar').remove();
		});

		$("body").on("click", "#btnTambahPemain", function() {
			var idPemain = $("#selPemain").val();
			var namaPemain = $("#selPemain option:selected").text();
			var peran = $("#selPeran").val();

			var new_row = "<tr>";	
				new_row += "<td>" + namaPemain + "<input type='hidden' name='idpemain[]' value='" + idPemain + "'></td>";
				new_row += "<td>" + peran + "<input type='hidden' name='peran[]' value='"+ peran + "'</td>";
				new_row += "<td><input type='button' class='btnHapusPemain' value='Hapus'></td>";
				new_row += "</tr>";
			$("#tblBody").append(new_row);
		});

		$("body").on("click", ".btnHapusPemain", function() {
			$(this).parent().parent().remove();
		});
	</script>
</body>
</html>