<?php

Yii::import('application.models._base.BaseEventTemplate');

class EventTemplate extends BaseEventTemplate
{
    /**
     * @return EventTemplate
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'EventTemplate|EventTemplates', $n);
    }

}