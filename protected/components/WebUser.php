<?php
 
// this file must be stored in:
// protected/components/WebUser.php
 
class WebUser extends CWebUser {
 
  // Store model to not repeat query.
  private $_model;
 
  public function getUserModel(){
    return $this->loadUser();
  }
 
  // Load user model.
  protected function loadUser($id=null)
    {
        if($this->_model===null)
        {
            if(Yii::app()->user->id!==null) {
              list($userID, $accountID) = split("@",Yii::app()->user->id);
              $this->_model=User::model()->findByAttributes(array("userID"=>$userID, "accountID"=>$accountID));
            }
        }
        return $this->_model;
    }
}
?>