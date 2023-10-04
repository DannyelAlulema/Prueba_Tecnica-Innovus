<?php

namespace App\Traits;

use PDO;
use PDOException;

use Core\DBConnection;

trait TokenBlackList
{
    private function isTokenBlacklisted($token)
    {
        $dbConnection = DBConnection::getInstance();
        $connection = $dbConnection->getConnection();

        try {
            $sql = "SELECT COUNT(*) FROM blacklist_tokens WHERE token = :token";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();

            $count = $stmt->fetchColumn();

            return $count > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    private function addToBlacklistDatabase($token)
    {
        $dbConnection = DBConnection::getInstance();
        $connection = $dbConnection->getConnection();

        try {
            $sql = "INSERT INTO blacklist_tokens (token) VALUES (:token)";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

}
