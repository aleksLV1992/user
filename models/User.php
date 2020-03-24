<?php

namespace models;

use vendor\Models;
use vendor\Site as Site;

class User extends \vendor\Models
{

    /**
     * @var id
     */
    public $id;

    /**
     * @var Имя польтзователя
     */
    public $user_name;

    /**
     * @var Id роли
     */
    public $role_id;


    /**
     * Получения Именени таблицы в БД
     * @return string
     */
    private static function getTable()
    {
        return 'user';
    }

    /**
     * Проверка валидности модели
     * @return bool
     */
    public function valid()
    {
        $isValid = false;
        if (strlen($this->user_name) === 0) {
            $this->errorList [] = "Заполните Имя пользователя";
        } else if (strlen($this->role_id) === 0) {
            $this->errorList [] = "Выберите роль";
        } else {

            if ($this->user_name !== null) {
                if (count($this->getListModel(['user_name' => $this->user_name])) === 0) {
                    $isValid = true;
                } else {
                    $this->errorList [] = "Пользователь с таким именем уже существует";
                }

            }
        }
        return $isValid;
    }

    /**
     * Сохранения пользователец
     * @return bool|\PDOStatement
     */
    public function save()
    {
        $table = self::getTable();

        $stmt = Site::$db->prepare("INSERT INTO {$table}(user_name,role_id) value(:q,:r)");
        $stmt->execute(['q' => $this->user_name, 'r' => $this->role_id]);
        $this->successList [] = "Пользователь успешно добавлена!";
        return $stmt;
    }


    /**
     * Список User
     * @param null $where
     * @return array
     */
    public function getListModel($where = null)
    {
        $whereList = [];
        $whereList [] = "1=1";
        if (!empty($where)) {
            foreach ($where as $key => $value)
                $whereList [] = "`{$key}` = '{$value}'";
        }

        $table = self::getTable();
        $list = Site::$db->query("SELECT * FROM {$table} WHERE " . implode(' AND ', $whereList));
        return $list->fetchAll(\PDO::FETCH_ASSOC);
    }


}