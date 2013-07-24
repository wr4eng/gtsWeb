<?php

Yii::import('application.models._base.BasePendingCommands');

class PendingCommands extends BasePendingCommands
{
    /**
     * @return PendingCommands
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'PendingCommands|PendingCommands', $n);
    }

}