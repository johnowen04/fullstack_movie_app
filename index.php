<?php
$mysqli = new mysqli("localhost", "root", "", "fullstack_db");

if ($mysqli->connect_errno) {
	die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

require_once("class/movie.php");
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Week 1 - Database Connection and Select</title>
	<style type="text/css">
		table,
		th,
		tr,
		td {
			border: 1px solid black;
		}

		.poster {
			max-width: 85px;
		}

		.teks-merah {
			color: red;
		}

		#vertical-nav {
			width: 150px;
			float: left;
			/*border: 0.1px solid black;*/
		}

		#content {
			width: 100%;
			/*border: 0.1px dashed blue;*/
		}

		#content * {
			width: auto;
			margin-right: 200px;
			margin-left: auto;
		}
	</style>
	<h1>My Movie</h1>
</head>

<body>
	<div id='vertical-nav'>
		<a href='#'>Daftar Movie</a> <br>
		<a href='#'>Daftar Pemain</a> <br>
		<a href='#'>Daftar Genre</a> <br>
	</div>
	<div id='content'>
		<form>
			Masukkan keyword judul:
			<input type="text" name="cari">
			<input type="submit" value="Search">
		</form>
		<a href="insert_movie.php">Tambah Movie Baru</a>
		<?php
		$keyword = "";
		if (isset($_GET['cari'])) {
			$keyword = $_GET['cari'];
			echo "<p><i>Hasil pencarian untuk keyword '" . $keyword . "'</i></p>";
		}

		$limit = 4;
		if (isset($_GET['offset'])) {
			$offset = $_GET['offset'];
		} else {
			$offset = 0;
		}

		$movie = new movie();
		$res = $movie->getMovie($keyword, $offset, $limit);

		$arr_genre = array();
		$sql2 = "SELECT * FROM genre";
		$res2 = $mysqli->query($sql2);
		while ($row = $res2->fetch_assoc()) {
			$temp = array($row['idgenre'] => $row['nama']);
			$arr_genre += $temp;
		}

		$arr_pemain = array();
		$sql3 = "SELECT * FROM pemain";
		$res3 = $mysqli->query($sql3);
		while ($row = $res3->fetch_assoc()) {
			$temp = array($row['idpemain'] => $row['nama']);
			$arr_pemain += $temp;
		}


		// $res = $mysqli->query("SELECT * FROM movie");
		echo "<table>
					<tr>
						<th>Judul</th>
						<th>Tgl. Rilis</th>
						<th>Skor</th>
						<th>Sinopsis</th>
						<th>Serial?</th>
						<th>Genre</th>
						<th>Pemain</th>
						<th>Aksi</th>
					</tr>";
		while ($row = $res->fetch_assoc()) {
			if ($row['skor'] < 5) {
				echo "<tr class='teks-merah'>";
			} else {
				echo "<tr>";
			}
			// echo "<td>
			// <img class='poster' src='img/".$row['idmovie'].".".$row['extention']."'>"."</td>";
			echo "<td>" . $row['judul'] . "</td>";

			echo "<td>" . $row['rilis'] . "</td>";

			echo "<td>" . $row['skor'] . "</td>";

			echo "<td>" . $row['sinopsis'] . "</td>";

			$serial = "Ya";
			if ($row['serial'] == 0) {
				$serial = "Tidak";
			}
			echo "<td>" . $serial . "</td>";

			echo "<td>";
			$sql2 = "SELECT * FROM movie_has_genre WHERE idmovie=?";
			$stmt = $mysqli->prepare($sql2);
			$stmt->bind_param('i', $row['idmovie']);

			$stmt->execute();
			$res2 = $stmt->get_result();
			while ($row2 = $res2->fetch_assoc()) {
				// TO-DO: Ambil genre dari tabel M-N
				echo $arr_genre[$row2['idgenre']];
				echo "<br>";
			}
			echo "</td>";

			echo "<td>";
			$sql3 = "SELECT * FROM movie_has_pemain WHERE idmovie=?";
			$stmt = $mysqli->prepare($sql3);
			$stmt->bind_param('i', $row['idmovie']);

			$stmt->execute();
			$res3 = $stmt->get_result();
			while ($row3 = $res3->fetch_assoc()) {
				// TO-DO: Ambil pemain dari tabel M-N
				echo $arr_pemain[$row3['idpemain']];
				echo "<br>";
			}
			echo "</td>";

			echo "<td><a href=\"edit_movie.php?idmovie=" . $row['idmovie'] . "\">Ubah Data</a>";
			echo "</tr>";
		}
		echo "<table>";
		
		$total_data = $movie->getJumlahData($keyword);

		include 'nomor_halaman.php';
		echo generateNomorHalaman($total_data, $offset, $limit, $keyword);
		?>
	</div>
</body>

</html>
<?php
$mysqli->close();
?>