<?php

Yii::import('application.models._base.BaseUserAcl');

class UserAcl extends BaseUserAcl
{
    /**
     * @return UserAcl
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'UserAcl|UserAcls', $n);
    }

}