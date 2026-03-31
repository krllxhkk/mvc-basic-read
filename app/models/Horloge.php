<?php

class Horloge
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllHorloges()
    {
        $sql = 'SELECT 
                    Id,
                    Merk,
                    Model,
                    Prijs,
                    IsActief,
                    Omschrijving,
                    DATE_FORMAT(DatumAangemaakt, "%d/%m/%Y") as DatumAangemaakt,
                    DATE_FORMAT(DatumGewijzigd, "%d/%m/%Y") as DatumGewijzigd
                FROM Horloges
                ORDER BY Merk ASC';

        $this->db->query($sql);

        return $this->db->resultSet();
    }

    public function delete($id)
    {
        $sql = 'DELETE 
                FROM Horloges 
                WHERE Id = :id';

        $this->db->query($sql);
        $this->db->bind(':id', $id, PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function create($data)
    {
        $sql = "INSERT INTO Horloges
                (
                    Merk,
                    Model,
                    Prijs,
                    IsActief,
                    Omschrijving,
                    DatumAangemaakt,
                    DatumGewijzigd
                )
                VALUES
                (
                    :merk,
                    :model,
                    :prijs,
                    :isactief,
                    :omschrijving,
                    SYSDATE(6),
                    SYSDATE(6)
                )";

        $this->db->query($sql);
        $this->db->bind(':merk', $data['merk'], PDO::PARAM_STR);
        $this->db->bind(':model', $data['model'], PDO::PARAM_STR);
        $this->db->bind(':prijs', $data['prijs'], PDO::PARAM_INT);
        $this->db->bind(':isactief', $data['isactief'], PDO::PARAM_INT);
        $this->db->bind(':omschrijving', $data['omschrijving'], PDO::PARAM_STR);

        return $this->db->execute();
    }
    public function getHorlogeById($id)
{
    $sql = 'SELECT HRLG.Id
                ,HRLG.Merk
                ,HRLG.Model
                ,HRLG.Prijs
                ,HRLG.IsActief
                ,HRLG.Omschrijving
                ,DATE_FORMAT(HRLG.DatumAangemaakt, "%d/%m/%Y") as DatumAangemaakt
                ,DATE_FORMAT(HRLG.DatumGewijzigd, "%d/%m/%Y") as DatumGewijzigd
            FROM Horloges as HRLG
            WHERE HRLG.Id = :id';

    $this->db->query($sql);
    $this->db->bind(':id', $id, PDO::PARAM_INT);

    return $this->db->single();
}
public function updateHorloge($request)
{
    //var_dump($_REQUEST);
    $sql = 'UPDATE Horloges as HRLG
            SET     HRLG.Merk = :merk
                    ,HRLG.Model = :model
                    ,HRLG.Prijs = :prijs
                    ,HRLG.IsActief = :isactief
                    ,HRLG.Omschrijving = :omschrijving
            WHERE   HRLG.Id = :id;';

    $this->db->query($sql);
    $this->db->bind(':id', $request['id'], PDO::PARAM_STR);
    $this->db->bind(':merk', $request['merk'], PDO::PARAM_STR);
    $this->db->bind(':model', $request['model'], PDO::PARAM_STR);
    $this->db->bind(':prijs', $request['prijs'], PDO::PARAM_INT);
    $this->db->bind(':isactief', $request['isactief'], PDO::PARAM_INT);
    $this->db->bind(':omschrijving', $request['omschrijving'], PDO::PARAM_STR);
    return $this->db->execute();
}
}