<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegisterForm extends CFormModel
{
	public $username;
	public $password;
	public $repeat_password;
	public $imei;
	public $firstName;
	public $lastName;
	public $phoneNumber;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, imei, firstName, lastName, phoneNumber, repeat_password', 'required', 'message' => '{attribute} wird benötigt.'),
			array('username', 'email'),
			array('imei', 'length', 'min'=>15,'max'=>15, 'message'=>'IMEI Nummer muss aus 15 numerischen Zeichen bestehen', 'tooShort'=>'IMEI Nummer muss aus 15 numerischen Zeichen bestehen', 'tooLong'=>'IMEI Nummer muss aus 15 numerischen Zeichen bestehen'),
			array('imei', 'numerical', 'integerOnly'=>true, 'message'=>'IMEI Nummer muss aus 15 numerischen Zeichen bestehen', 'tooSmall'=>'IMEI Nummer muss aus 15 numerischen Zeichen bestehen', 'tooBig'=>'IMEI Nummer muss aus 15 numerischen Zeichen bestehen'),
			array('imei', 'imeiValid'),
			array('password', 'length', 'min'=>6, 'max'=>40, 'message' => '{attribute} ist zu kurz'),
            array('password', 'compare', 'compareAttribute'=>'repeat_password', 'message'=>'Passwörter müssen übereinstimmen'),
		);
	}

	public function imeiValid() {
		// Check if given imei is still available to register...
		$device = Device::model()->findByAttributes(array('imeiNumber'=>$this->imei));
		if (isset($device))
			$this->addError("imei", "Dieser Tracker wurde bereits registriert");
		$imei = IMEI::model()->findByPk($this->imei);
		if (!isset($imei))
			$this->addError("imei", "Diese IMEI Nummer ist uns nicht bekannt");
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>'EMail Adresse',
			'password'=>'Passwort',
			'repeat_password'=>'Passwort wiederholen',
			'imei'=>'Tracker IMEI',
			'firstName'=>'Vorname',
			'lastName'=>'Nachname',
			'phoneNumber'=>'Telefonnummer',
		);
	}

	public function getDeviceID() {
		return "mt90_".$this->imei;
	}

	public function getDisplayName() {
		return $this->lastName . " " . $this->firstName;
	}

	public function save() {
		// First check if the user does already exist, or if we have to create the user...
		$user = User::model()->findByAttributes(array("accountID"=>Yii::app()->params["accountID"],"contactEmail"=>$this->username));
		if (isset($user)) {
			// We do have a user - so attach new device to the users devicelist
			if (!isset($user->grouplist[0])) {
				Yii::log('user does exist, but does not have a grouplist attached !', 'error');
				return false;
			}
			$deviceGroup = $user->grouplist[0];

		} else {
			// No user yet - so create a new user
			$user = new User();
			$user->accountID = Yii::app()->params['accountID'];
			$user->contactEmail = $this->username;
			$user->userID = $this->imei;
			$user->userType = 0;
			$user->roleID = "";
			$user->password = $this->password;
			$user->gender = 0;
			$user->notifyEmail = $this->username;
			$user->contactName = $this->displayName;
			$user->contactPhone = $this->phoneNumber;
			$user->contactEmail = $this->username;
			$user->timeZone = "GMT";
			$user->firstLoginPageID = "map.device";
			$user->isActive = 1;
			$user->displayName = $this->displayName;
			$user->description = $this->displayName;
			$user->creationTime = date("U");
			$user->lastUpdateTime = date("U");
			if (!$user->save()) {
				$errorMessage = "User save failed !\n";
				foreach($user->getErrors() as $attribute=>$errors) {
					foreach($errors as $error) {
						$errorMessage .= $attribute . ": " . $error . "\n";
					}
				}
				Yii::log($errorMessage, "error");
				return false;
			}
			// Do create for each user a own group
			$groupList = new GroupList();
			$groupList->userID = $user->userID;
			$groupList->groupID = $this->username;
			$groupList->accountID = Yii::app()->params["accountID"];
			if (!$groupList->save()) {
				$errorMessage = "GroupList save failed !\n";
				foreach($user->getErrors() as $attribute=>$errors) {
					foreach($errors as $error) {
						$errorMessage .= $attribute . ": " . $error . "\n";
					}
				}
				Yii::log($errorMessage, "error");
				// Do delete what we have created so far
				$user->delete();
				return false;
			}
			// Do create the device group
			$deviceGroup = new DeviceGroup();
			$deviceGroup->displayName = $this->displayName;
			$deviceGroup->description = $this->displayName;
			$deviceGroup->groupID = $this->username;
			$deviceGroup->accountID = Yii::app()->params["accountID"];
			$deviceGroup->creationTime = date("U");
			$deviceGroup->lastUpdateTime = date("U");
			if (!$deviceGroup->save()) {
				$errorMessage = "DeviceGroup save failed !!\n";
				foreach($user->getErrors() as $attribute=>$errors) {
					foreach($errors as $error) {
						$errorMessage .= $attribute . ": " . $error . "\n";
					}
				}
				Yii::log($errorMessage, "error");
				// Do delete what we have created so far
				$groupList->delete();
				$user->delete();
				return false;
			}
		}
		// We do create a new Device entrie here
		$imei = IMEI::model()->findByPk($this->imei);
		$device = new Device();
		$device->imeiNumber = $this->imei;
		$device->accountID = Yii::app()->params["accountID"];
		$device->deviceID = $this->deviceID;
		$device->groupID = $deviceGroup->groupID;
		$device->uniqueID = "mt90_".$this->imei;
		$device->simPhoneNumber = $imei->msn;
		$device->isActive = 1;
		$device->displayName = $this->displayName;
		$device->description = $this->displayName;
		$device->creationTime = date("U");
		$device->lastUpdateTime = date("U");
		if (!$device->save()) {
			$errorMessage = "Device save failed !!\n";
			foreach($user->getErrors() as $attribute=>$errors) {
				foreach($errors as $error) {
					$errorMessage .= $attribute . ": " . $error . "\n";
				}
			}
			Yii::log($errorMessage, "error");
			// Do delete what we have created so far - if we created the items freshly...
			if (isset($groupList)) {
				$deviceGroup->delete();
				$groupList->delete();
				$user->delete();
			}
			return false;
		} else {
			// Do create the device list entrie
			$deviceList = new DeviceList();
			$deviceList->groupID = $deviceGroup->groupID;
			$deviceList->accountID = Yii::app()->params["accountID"];
			$deviceList->deviceID = $this->deviceID;
			$deviceList->creationTime = date("U");
			$deviceList->lastUpdateTime = date("U");
			if (!$deviceList->save()) {
				$errorMessage = "DeviceList save failed !!\n";
				foreach($user->getErrors() as $attribute=>$errors) {
					foreach($errors as $error) {
						$errorMessage .= $attribute . ": " . $error . "\n";
					}
				}
				Yii::log($errorMessage, "error");
				// Do delete what we have created so far - if we created the items freshly...
				if (isset($groupList)) {
					// It was a new created user
					$deviceGroup->delete();
					$groupList->delete();
					$user->delete();
				}
				$device->delete();
				return false;
			}

		}
		return true;
	}

}