<?php

Yii::import('application.models._base.BaseGroupList');

class GroupList extends BaseGroupList
{
    /**
     * @return GroupList
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function relations() {
        return array(
            'devicelist'=>array(self::HAS_MANY, 'DeviceList', 'accountID,groupID'),
        );
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'GroupList|GroupLists', $n);
    }

}