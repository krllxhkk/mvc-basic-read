<?php

class Smartphone
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllSmartphones()
{
    $sql = 'SELECT SMPS.Id,
                SMPS.Merk,
                SMPS.Model,
                SMPS.Prijs,
                SMPS.Geheugen,
                SMPS.Besturingssysteem,
                CONCAT(SMPS.Schermgrootte, " inch") as Schermgrootte,
                DATE_FORMAT(SMPS.Releasedatum, "%d/%m/%Y") as Releasedatum,
                CONCAT(SMPS.Megapixels, " MP") as Megapixels
            FROM Smartphones as SMPS
            ORDER BY SMPS.Schermgrootte DESC';

    $this->db->query($sql);
    return $this->db->resultSet();
}

    public function delete($id)
    {
        $sql = 'DELETE 
        FROM Smartphones
        WHERE Id = :id';

        $this->db->query($sql);
        $this->db->bind(':id', $id, PDO::PARAM_INT);

        return $this->db->execute();
    }

    public function create($data)
{
    $sql = "INSERT INTO Smartphones ( Merk
                                    ,Model
                                    ,Prijs
                                    ,Geheugen
                                    ,Besturingssysteem
                                    ,Schermgrootte
                                    ,Releasedatum
                                    ,MegaPixels
                                    )
            VALUES (:merk,
                    :model,
                    :prijs,
                    :geheugen,
                    :besturingssysteem,
                    :schermgrootte,
                    :releasedatum,
                    :megapixels)";

    $this->db->query($sql);
    $this->db->bind(':merk', $data['merk'], PDO::PARAM_STR);
    $this->db->bind(':model', $data['model'], PDO::PARAM_STR);
    $this->db->bind(':prijs', $data['prijs'], PDO::PARAM_INT);
    $this->db->bind(':geheugen', $data['geheugen'], PDO::PARAM_INT);
    $this->db->bind(':besturingssysteem', $data['besturingssysteem'], PDO::PARAM_STR);
    $this->db->bind(':schermgrootte', $data['schermgrootte'], PDO::PARAM_INT);
    $this->db->bind(':releasedatum', $data['releasedatum'], PDO::PARAM_STR);
    $this->db->bind(':megapixels', $data['megapixels'], PDO::PARAM_INT);

    return $this->db->execute();
}
public function getSmartphoneById($id)
{
    $sql = 'SELECT SMPS.Id
                ,SMPS.Merk
                ,SMPS.Model
                ,SMPS.Prijs
                ,SMPS.Geheugen
                ,SMPS.Besturingssysteem
                ,CONCAT(SMPS.Schermgrootte, " inch") as Schermgrootte
                ,DATE_FORMAT(SMPS.Releasedatum, "%d/%m/%Y") as Releasedatum
                ,CONCAT(SMPS.Megapixels, " MP") as MegaPixels
            FROM Smartphones as SMPS
            WHERE SMPS.Id = :id';

    $this->db->query($sql);
    $this->db->bind(':id', $id, PDO::PARAM_INT);

    return $this->db->single();
}
public function updateSmartphone($request)
{
    //var_dump($_REQUEST);
    $sql = 'UPDATE Smartphones as SMPS
            SET     SMPS.Merk = :merk
                    ,SMPS.Model = :model
                    ,SMPS.Prijs = :prijs
                    ,SMPS.Geheugen = :geheugen
                    ,SMPS.Besturingssysteem = :besturingssysteem
                    ,SMPS.Schermgrootte = :schermgrootte
                    ,SMPS.Releasedatum = :releasedatum
                    ,SMPS.MegaPixels = :megapixels
            WHERE   SMPS.Id = :id;';

    $this->db->query($sql);
    $this->db->bind(':id', $request['id'], PDO::PARAM_STR);
    $this->db->bind(':merk', $request['merk'], PDO::PARAM_STR);
    $this->db->bind(':model', $request['model'], PDO::PARAM_STR);
    $this->db->bind(':prijs', $request['prijs'], PDO::PARAM_INT);
    $this->db->bind(':geheugen', $request['geheugen'], PDO::PARAM_INT);
    $this->db->bind(':besturingssysteem', $request['besturingssysteem'], PDO::PARAM_STR);
    $this->db->bind(':schermgrootte', $request['schermgrootte'], PDO::PARAM_INT);
    $this->db->bind(':releasedatum', $request['releasedatum'], PDO::PARAM_STR);
    $this->db->bind(':megapixels', $request['megapixels'], PDO::PARAM_INT);

    return $this->db->execute();
}
}