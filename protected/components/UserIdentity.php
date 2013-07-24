<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_userID;
    private $_accountID;

    public function authenticate()
    {
        $record=User::model()->findByAttributes(array('contactEmail'=>$this->username, 'accountID'=>Yii::app()->params['accountID']));
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($record->password!==$this->password)
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_userID=$record->userID;
            $this->_accountID=$record->accountID;
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
 
    public function getId()
    {
        return $this->_userID."@".$this->_accountID;
    }

}