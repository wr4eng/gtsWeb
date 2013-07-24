<?php

Yii::import('application.models._base.BaseStatusCode');

class StatusCode extends BaseStatusCode
{
    /**
     * @return StatusCode
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'StatusCode|StatusCodes', $n);
    }

}