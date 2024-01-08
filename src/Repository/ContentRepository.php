<?php

namespace Banners\Repository;

class ContentRepository extends Repository
{
    public function getAllContents()
    {
        $prepare = $this->conn->prepare("SELECT *
            FROM mediacontent");
        return $prepare->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    public function getLastReferID()
    {
        $prepare = $this->conn->prepare("SELECT referid
                FROM mediacontent ORDER BY referid DESC LIMIT 1");
        $prepare->execute();
        return $prepare->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    public function registerContent(
        $filename,
        $type,
        $path,
        $referid,
        $referlink,
        $author
    ) {
        $sql = "INSERT INTO mediacontent
                (`filename`, `type`, `path`,`referid`, `referlink`,`author`)
                VALUES (:filename, :type, :path, :referid, :referlink, :author)";
        $prepare = $this->conn->prepare($sql);
        $prepare->execute([
            'filename'  => $filename,
            'type'      => $type,
            'path'      => $path,
            'referid'   => $referid,
            'referlink' => $referlink,
            'author'    => $author,
        ]);
    }

    public function getByType(string $type, $limit, $offset)
    {
        $sql = "SELECT * FROM mediacontent
                WHERE `type` = :type
                ORDER BY `referid` DESC
                LIMIT $limit
                OFFSET $offset";
        $prepare = $this->conn->prepare($sql);
        $prepare->execute([
            "type"  => $type,
        ]);

        $json = $prepare->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        return $json;

    }
}
