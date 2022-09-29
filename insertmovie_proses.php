<?php 

require_once("class/movie.php");

$mysqli = new mysqli("localhost", "root", "", "fullstack_db");

if ($mysqli->connect_errno) {
	die("Failed to connect to MySQL: ".$mysqli->connect_error);
}

if (isset($_POST['submit'])) {
	$arr_movie = array();
	$arr_movie["judul"] = $_POST['judul'];
	$arr_movie["rilis"] = $_POST['rilis'];
	$arr_movie["serial"] = $_POST['serial'];
	$arr_movie["skor"] = $_POST['skor'];
	$arr_movie["sinopsis"] = $_POST['sinopsis'];
	$genres = $_POST['genre'];

	$movie = new movie();
	$idmovie = $movie->insertMovie($arr_movie);

	if ($idmovie) {
		// Input genre
		foreach($genres as $idgenre) {
			$sql2 =	"INSERT INTO movie_has_genre(idmovie, idgenre) VALUES(?,?)";
			$stmt = $mysqli->prepare($sql2);
			$stmt->bind_param('ii', $idmovie, $idgenre);

			$stmt->execute();
		}

		// Input pemain
		$casts = $_POST['idpemain'];
		$roles = $_POST['peran'];

		foreach($casts as $key => $idpemain) {
			$sql4 =	"INSERT INTO movie_has_pemain(idmovie, idpemain, peran) VALUES(?,?,?)";
			$stmt = $mysqli->prepare($sql4);
			$stmt->bind_param('iis', $idmovie, $idpemain, $roles[$key]);

			$stmt->execute();
		}

		// Input poster
		$posters = $_FILES['poster'];

		foreach($posters['name'] as $key => $poster_name) {
			if (isset($posters['name'][$key])) {
				$file_info = getimagesize($posters['tmp_name'][$key]);
				if(!empty($file_info)) {
					if($file_info['mime'] == 'image/jpeg' || $file_info['mime'] == 'image/png') {
						$ext = pathinfo($posters['name'][$key], PATHINFO_EXTENSION);
						
						// $sql3 = "UPDATE movie SET extention=? WHERE idmovie=?";
						$sql3 = "INSERT INTO gambar(extention, idmovie) VALUES(?, ?)";
						$stmt = $mysqli->prepare($sql3);
						$stmt->bind_param('si', $ext, $idmovie);

						$stmt->execute();

						$idgambar = $stmt -> insert_id;
						move_uploaded_file($posters['tmp_name'][$key], 'img/'.$idgambar.'.'.$ext);
					} else {
						echo "File is not a jpeg or a png.";
					}
				} else {
					echo "File is empty";
				}
			} else {
				echo "Something went wrong";
			}	
		}
	}

	$jumlah_yg_dieksekusi = $stmt->affected_rows;
	$stmt->close();
}

$mysqli->close();
header("location: insert_movie.php");
?>