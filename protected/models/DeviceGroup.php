<?php

Yii::import('application.models._base.BaseDeviceGroup');

class DeviceGroup extends BaseDeviceGroup
{
    /**
     * @return DeviceGroup
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'DeviceGroup|DeviceGroups', $n);
    }

}