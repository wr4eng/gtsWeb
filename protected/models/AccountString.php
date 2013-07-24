<?php

Yii::import('application.models._base.BaseAccountString');

class AccountString extends BaseAccountString
{
    /**
     * @return AccountString
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'AccountString|AccountStrings', $n);
    }

}