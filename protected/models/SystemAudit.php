<?php

Yii::import('application.models._base.BaseSystemAudit');

class SystemAudit extends BaseSystemAudit
{
    /**
     * @return SystemAudit
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'SystemAudit|SystemAudits', $n);
    }

}