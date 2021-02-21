<?php

namespace App\Models;

use PDO;
use PDOException;

class Roaster
{
    public $db;
    public $pdo;
    public $previousSeason;
    public $currentSeason;

    public function __construct($db)
    {
        $this->db = $db;
        try {

            $this->pdo = new PDO(
                'mysql:host=tdd_db;dbname=tdd;', 'localhost','root'
            );
            
        } catch (PDOException $e) {
            echo 'connection failed' .  $e->getMessage();
        }
    }

    //other code snipped out

    public function getUsersByName(string $name)
    {
        $sql = "select * from `users` where `fullname` like :fullname";

        $pdo = $this->pdo->prepare($sql);

        $pdo->bindValue(':fullname', "{$name}%");

        $pdo->execute();
        while ($row = $pdo->fetchAll(PDO::FETCH_ASSOC)) {
            print_r($row);
        }
    }


    public function getById(int $id): array
    {

    }

    public function makeInactive(int $id)
    {

    }

    public function updatePlayerTeam(string $tradePartner, int $playerId, string $comment)
    {

    }
}