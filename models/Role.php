<?php

namespace models;

use vendor\Models;
use vendor\Site as Site;

class Role extends Models
{

    /**
     * @var id role
     */
    public $id;

    /**
     * @var Имя role
     */
    public $role_name;

    /**
     * Получения Именени таблицы в БД
     * @return string
     */
    private static function getTable()
    {
        return 'user_role';
    }

    /**
     * Проверка валидности модели
     * @return bool
     */
    public function valid()
    {
        $isValid = false;
        if (strlen($this->role_name) === 0) {
            $this->errorList [] = "Заполните Имя роли";
        } else {

            if ($this->role_name !== null) {
                if (count($this->getListModel(['role_name' => $this->role_name])) === 0) {
                    $isValid = true;
                } else {
                    $this->errorList [] = "Роль с таким именем уже существует";
                }

            }
        }
        return $isValid;
    }

    /**
     * Сохранения данных в БД
     * @return bool|\PDOStatement
     */
    public function save()
    {
        $table = self::getTable();

        $stmt = Site::$db->prepare("INSERT INTO {$table}(role_name) value(:q)");
        $stmt->execute(['q' => $this->role_name]);
        $this->successList [] = "Роль успешно добавлена!";
        return $stmt;
    }

    /**
     * Получения списка пользователей
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