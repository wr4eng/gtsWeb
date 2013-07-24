<?php

Yii::import('application.models._base.BaseUnassignedDevices');

class UnassignedDevices extends BaseUnassignedDevices
{
    /**
     * @return UnassignedDevices
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'UnassignedDevices|UnassignedDevices', $n);
    }

}