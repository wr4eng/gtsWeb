<?php

Yii::import('application.models._base.BaseGeozone');

class Geozone extends BaseGeozone
{
    /**
     * @return Geozone
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Geozone|Geozones', $n);
    }

}