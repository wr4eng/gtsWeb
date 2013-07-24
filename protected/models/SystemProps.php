<?php

Yii::import('application.models._base.BaseSystemProps');

class SystemProps extends BaseSystemProps
{
    /**
     * @return SystemProps
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'SystemProps|SystemProps', $n);
    }

}