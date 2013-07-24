<?php

Yii::import('application.models._base.BaseEntity');

class Entity extends BaseEntity
{
    /**
     * @return Entity
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Entity|Entities', $n);
    }

}