<?php

Yii::import('application.models._base.BaseProperty');

class Property extends BaseProperty
{
    /**
     * @return Property
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Property|Properties', $n);
    }

}