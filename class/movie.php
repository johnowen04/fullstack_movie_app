<?php

require_once("orangtua.php");

class movie extends orangtua
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertMovie($arr_movie)
    {
        $arr_col = array();
        $arr_tanya = array();

        foreach ($arr_movie as $column => $value) {
            $arr_col[] = $column;
            $arr_tanya[] = "?";
        }
        $sql = "INSERT INTO movie(".implode(",", $arr_col).") VALUES(".implode(",", $arr_tanya).")";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('ssdsi', $arr_movie["judul"],
            $arr_movie["rilis"], $arr_movie["skor"],
            $arr_movie["sinopsis"], $arr_movie["serial"]);

        $stmt->execute();
        return $stmt->insert_id;
    }

    public function getMovie($keyword, $offset = null, $limit = null)
    {
        $sql = "SELECT * FROM movie WHERE judul like ?";
        if (!is_null($offset) && !is_null($limit)) {
            $sql .= " LIMIT ?, ?";
        }
        $stmt = $this->mysqli->prepare($sql);
        $modified_keyword = "%" . $keyword . "%";
        if (!is_null($offset)) {
            $stmt->bind_param('sii', $modified_keyword, $offset, $limit);
        } else {
            $stmt->bind_param('s', $modified_keyword);
        }
        $stmt->execute();
        $res = $stmt->get_result();

        return $res;
    }

    public function getJumlahData($keyword)
    {
        $res = $this->getMovie($keyword);
        return $res->num_rows;
    }
}
