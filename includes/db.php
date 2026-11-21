<?php
/**
 * Girna Global - DB Helper Wrapper
 */

require_once __DIR__ . '/../config/database.php';

class DB {
    public static function pdo() {
        return getDBConnection();
    }

    public static function query($sql, $params = []) {
        $pdo = self::pdo();
        if (!$pdo) return false;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetchAll($sql, $params = []) {
        $stmt = self::query($sql, $params);
        return $stmt ? $stmt->fetchAll() : [];
    }

    public static function fetch($sql, $params = []) {
        $stmt = self::query($sql, $params);
        return $stmt ? $stmt->fetch() : null;
    }

    public static function count($sql, $params = []) {
        $stmt = self::query($sql, $params);
        return $stmt ? (int)$stmt->fetchColumn() : 0;
    }

    public static function insert($sql, $params = []) {
        $pdo = self::pdo();
        if (!$pdo) return false;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $pdo->lastInsertId();
    }
}
