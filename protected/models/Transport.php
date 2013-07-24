<?php

Yii::import('application.models._base.BaseTransport');

class Transport extends BaseTransport
{
    /**
     * @return Transport
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Transport|Transports', $n);
    }

}