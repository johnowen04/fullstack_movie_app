<?php 
	function generateNomorHalaman($total_data, $offset, $limit, $keyword="") {
		$hasil = "";
		$hasil .= "<p style='display: inline; margin-top: 20px;'>";
		$hasil .= "<a href='?offset=0&cari='".$keyword."'>First</a>";
		
		$maks_hal = ceil($total_data/$limit);
		if ($offset - $limit >= 0) {
			$hasil .= "<a href='?offset=".($offset-$limit)."&cari=".$keyword."'>Prev</a>";
		}

		for($nomor_hal=1;$nomor_hal<=$maks_hal;$nomor_hal++) {
			$new_offset = ($nomor_hal - 1) * $limit;

			$hal_sekarang = ($offset/$limit) + 1;

			if ($nomor_hal == $hal_sekarang) {
				$hasil .= "<p style='display: inline;'>".$nomor_hal."</p>";
			} else {
				$hasil .= "<a href='?offset=".$new_offset."&cari=".$keyword."'>".$nomor_hal."</a>";
			}

			$hasil .= " ";
		}

		if ($offset + $limit <= $total_data) {
			$hasil .= "<a href='?offset=".($offset+$limit)."&cari=".$keyword."'>Next</a>";
		}

		$max_offset = ($maks_hal - 1) * $limit;
		$hasil .= "<a href='?offset=".$max_offset."&cari='".$keyword."'>Last</a>";
		$hasil .= "</p>";

		return $hasil;
	}
 ?>