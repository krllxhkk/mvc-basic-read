<?php

class Sneaker
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllSneakers()
    {
        $sql = 'SELECT 
                    Id,
                    Merk,
                    Model,
                    Type,
                    IsActief,
                    Opmerking,
                    DatumAangemaakt,
                    DatumGewijzigd
                FROM Sneakers
                ORDER BY Merk ASC';

        $this->db->query($sql);

        return $this->db->resultSet();
    }

    public function delete($id)
    {
        $sql = 'DELETE 
                FROM Sneakers 
                WHERE Id = :id';

        $this->db->query($sql);
        $this->db->bind(':id', $id, PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function create($data)
    {
        $sql = "INSERT INTO Sneakers
                (
                    Merk,
                    Model,
                    Type,
                    IsActief,
                    Opmerking,
                    DatumAangemaakt,
                    DatumGewijzigd
                )
                VALUES
                (
                    :merk,
                    :model,
                    :type,
                    :isactief,
                    :opmerking,
                    SYSDATE(6),
                    SYSDATE(6)
                )";

        $this->db->query($sql);
        $this->db->bind(':merk', $data['merk'], PDO::PARAM_STR);
        $this->db->bind(':model', $data['model'], PDO::PARAM_STR);
        $this->db->bind(':type', $data['type'], PDO::PARAM_STR);
        $this->db->bind(':isactief', $data['isactief'], PDO::PARAM_INT);
        $this->db->bind(':opmerking', $data['opmerking'], PDO::PARAM_STR);

        return $this->db->execute();
    }
    public function getSneakerById($id)
{
    $sql = 'SELECT SNEAKERS.Id
                ,SNEAKERS.Merk
                ,SNEAKERS.Model
                ,SNEAKERS.Type
                ,SNEAKERS.IsActief
                ,SNEAKERS.Opmerking
                ,DATE_FORMAT(SNEAKERS.DatumAangemaakt, "%d/%m/%Y") as DatumAangemaakt
                ,DATE_FORMAT(SNEAKERS.DatumGewijzigd, "%d/%m/%Y") as DatumGewijzigd
            FROM Sneakers as SNEAKERS
            WHERE SNEAKERS.Id = :id';

    $this->db->query($sql);
    $this->db->bind(':id', $id, PDO::PARAM_INT);

    return $this->db->single();
}
public function updateSneaker($request)
{
    //var_dump($_REQUEST);
    $sql = 'UPDATE Sneakers as SNEAKERS
            SET     SNEAKERS.Merk = :merk
                    ,SNEAKERS.Model = :model
                    ,SNEAKERS.Type = :type
                    ,SNEAKERS.IsActief = :isactief
                    ,SNEAKERS.Opmerking = :opmerking
                    ,SNEAKERS.DatumGewijzigd = SYSDATE(6)
            WHERE   SNEAKERS.Id = :id;';

    $this->db->query($sql);
    $this->db->bind(':id', $request['id'], PDO::PARAM_STR);
    $this->db->bind(':merk', $request['merk'], PDO::PARAM_STR);
    $this->db->bind(':model', $request['model'], PDO::PARAM_STR);
    $this->db->bind(':type', $request['type'], PDO::PARAM_STR);
    $this->db->bind(':isactief', $request['isactief'], PDO::PARAM_INT);
    $this->db->bind(':opmerking', $request['opmerking'], PDO::PARAM_STR);

    return $this->db->execute();
}

}