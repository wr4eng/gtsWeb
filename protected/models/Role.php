<?php

Yii::import('application.models._base.BaseRole');

class Role extends BaseRole
{
    /**
     * @return Role
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Role|Roles', $n);
    }

}