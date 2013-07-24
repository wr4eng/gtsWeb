<?php

Yii::import('application.models._base.BaseDriver');

class Driver extends BaseDriver
{
    /**
     * @return Driver
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Driver|Drivers', $n);
    }

}