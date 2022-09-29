<?php

require_once("orangtua.php");

class movie extends orangtua
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMovie($keyword, $offset, $limit)
    {
        $sql = "SELECT * FROM movie WHERE judul like ? LIMIT ?,?";
        $stmt = $this->mysqli->prepare($sql);
        $modified_keyword = "%" . $keyword . "%";
        $stmt->bind_param('sii', $modified_keyword, $offset, $limit);
        $stmt->execute();
        $res = $stmt->get_result();

        return $res;
    }
}
