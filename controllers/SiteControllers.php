<?php

use vendor\Controllers as Controllers;
use vendor\Site as Site;


class SiteControllers extends Controllers
{

    /**
     * Выводит список user
     * @return string
     */
    public function actionIndex()
    {
        $listUser = $this->getUserList();
        return $this->render('user', ['user' => $listUser]);
    }

    /**
     * Добавления новой роли
     */
    public function actionAddRole()
    {
        $role = new \models\Role();
        if (isset($_POST['role_name'])) {
            $role->Loading($_POST);
            if ($role->valid()) {
                $role->save();
                $role->role_name = null;
            }
        }

        return $this->render('add-role', ['model' => $role, 'error' => $role->errorList, 'success' => $role->successList]);
    }

    /**
     * Страница добавления нового пользователя
     * @return string
     */
    public function actionAddUser(){
        $role = new \models\Role();
        $roleList = $role->getListModel();
        $user = new \models\User();
        if (isset($_POST['user_name'])) {
            $user->Loading($_POST);
            if ($user->valid()) {
                $user->save();
                $user->user_name = null;
                $user->role_id = null;
            }
        }

        return $this->render('add-user', ['model' => $role, 'error' => $user->errorList, 'success' => $user->successList,'role'=>$roleList]);
    }

    /**
     * Получения ListUser
     */
    private function getUserList()
    {
        $stmt = \vendor\Site::$db->query('SELECT u.id,u.user_name,u.role_id,r.role_name FROM `user` u LEFT JOIN `user_role` r ON u.role_id =  r.id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}