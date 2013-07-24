<?php

Yii::import('application.models._base.BaseUser');

class User extends BaseUser
{
    private $_devices = null;

    /**
     * @return User
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function relations() {
        return array(
            'grouplist'=>array(self::HAS_MANY, 'GroupList', 'accountID,userID'),
        );
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'User|Users', $n);
    }

    public function getDevices() {
        if (isset($this->_devices))
            return $this->_devices;
        $devicesCommand = Yii::app()->db->createCommand("SELECT Device.accountID, Device.deviceID FROM `Device` LEFT JOIN DeviceList ON Device.deviceID=DeviceList.deviceID LEFT JOIN GroupList ON DeviceList.groupID=GroupList.groupID LEFT JOIN User ON GroupList.userID=User.userID WHERE Device.accountID=:accountID AND User.userId=:userID AND User.accountId=:accountID");
        $devicesCommand->bindValues(array("accountID"=>$this->accountID,"userID"=>$this->userID));
        $devices = $devicesCommand->queryAll();
        if (!isset($devices)) {
            Yii::log('No devices attached.','error');
            return null;
        }
        foreach($devices as $key=>$device) {
            $this->_devices[$device['deviceID']] = Device::model()->findByAttributes(array("accountID"=>$device['accountID'], "deviceID" => $device['deviceID']));
        }
        return $this->_devices;
    }

}