<?php

Yii::import('application.models._base.BaseRoleAcl');

class RoleAcl extends BaseRoleAcl
{
    /**
     * @return RoleAcl
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'RoleAcl|RoleAcls', $n);
    }

}