<?php

namespace vendor;


class Models
{
    /**
     * @var array  Ошибки
     */
    public $errorList = [];

    /**
     * @var array  Сообщения
     */
    public $successList = [];

    /**
     * @param array $a Загрузка модели на оснований array
     */
    public function Loading($a = [])
    {
        foreach ($this as $key => $val) {
            if (array_key_exists($key, $a))
                $this->$key = $a[$key];
        }
    }


}