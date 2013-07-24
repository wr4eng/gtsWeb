<?php

Yii::import('application.models._base.BaseDeviceList');

class DeviceList extends BaseDeviceList
{
    /**
     * @return DeviceList
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function relations() {
        return array(
            'devices'=>array(self::HAS_MANY, 'Device', 'accountID,deviceID'),
        );
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'DeviceList|DeviceLists', $n);
    }

}