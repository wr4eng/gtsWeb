<?php

Yii::import('application.models._base.BaseAntx');

class Antx extends BaseAntx
{
    /**
     * @return Antx
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Antx|Antxes', $n);
    }

}