<?php

Yii::import('application.models._base.BaseAccount');

class Account extends BaseAccount
{
    /**
     * @return Account
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Account|Accounts', $n);
    }

}