<?php

Yii::import('application.models._base.BasePendingPacket');

class PendingPacket extends BasePendingPacket
{
    /**
     * @return PendingPacket
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'PendingPacket|PendingPackets', $n);
    }

}