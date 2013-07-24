<?php

Yii::import('application.models._base.BaseSessionStats');

class SessionStats extends BaseSessionStats
{
    /**
     * @return SessionStats
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'SessionStats|SessionStats', $n);
    }

}