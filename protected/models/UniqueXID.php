<?php

Yii::import('application.models._base.BaseUniqueXID');

class UniqueXID extends BaseUniqueXID
{
    /**
     * @return UniqueXID
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'UniqueXID|UniqueXIDs', $n);
    }

}