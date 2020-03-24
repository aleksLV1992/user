<?php

namespace vendor;


class BDMysql
{

    /**
     * Подключения BD
     */
    public static function PDOInit($sdn)
    {
        $db = false;
        try {

            $db = new \PDO($sdn['mysql'], $sdn['username'], $sdn['password']);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $db = false;
        }

        return $db;
    }


}