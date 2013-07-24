<?php

Yii::import('application.models._base.BaseDevice');

class Device extends BaseDevice
{
    /**
     * @return Device
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Device|Devices', $n);
    }

    public function getIdent() {
        return $this->deviceID."@".$this->accountID;
    }


    public function loadByIdent($ident) {
        list($deviceID, $accountID) = split("@",$ident);
        return $this->findByAttributes(array("deviceID"=>$deviceID, "accountID"=>$accountID));
    }

    public function getLastGPSEvent() {
        $criteria = new CDBCriteria();
        $criteria->compare("deviceID", $this->deviceID);
        $criteria->compare("accountID", $this->accountID);
        $criteria->compare("statusCode","61472");
        $criteria->limit = 1;
        $criteria->order = "`timestamp` DESC";
        return EventData::model()->find($criteria);
    }
}