<?php

Yii::import('application.models._base.BaseEventData');

class EventData extends BaseEventData
{
    /**
     * @return EventData
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'EventData|EventDatas', $n);
    }

}