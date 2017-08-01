<?php

class Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid_Dof extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

	const FLAG_SA = 1;
	const FLAG_VI = 2;
	const FLAG_JU = 4;
	const FLAG_MI = 8;
	const FLAG_MA = 16;
	const FLAG_LU = 32;
	const FLAG_DO = 64;

	public function render(Varien_Object $row) {
		$value =  $row->getData($this->getColumn()->getIndex());
		return $this->getValueDaysOfWeek($value);
	}

    public function isFlagSet($flag, $data) {
    	return (($data & $flag) == $flag);
    }

	public function setFlag($flag, $data) {
    	$data |= $flag;
    	return $data;
	}

	public function unsetFlag($flag, $data) {
		$data &= ~$flag;
		return $data;
	}

    public function getValueDaysOfWeek($data) {
      $value = "";
      if($this->isFlagSet(self::FLAG_DO, $data)) $value = $value . "DO ";
      if($this->isFlagSet(self::FLAG_LU, $data)) $value = $value . "LU ";
      if($this->isFlagSet(self::FLAG_MA, $data)) $value = $value . "MA ";
      if($this->isFlagSet(self::FLAG_MI, $data)) $value = $value . "MI ";
      if($this->isFlagSet(self::FLAG_JU, $data)) $value = $value . "JU ";
      if($this->isFlagSet(self::FLAG_VI, $data)) $value = $value . "VI ";
      if($this->isFlagSet(self::FLAG_SA, $data)) $value = $value . "SA ";

      return $value;
  }

	public function getMultiselectValue($data) {
      $value = "";
      if($this->isFlagSet(self::FLAG_DO, $data)) $value = $value . self::FLAG_DO . ",";
      if($this->isFlagSet(self::FLAG_LU, $data)) $value = $value . self::FLAG_LU . ",";
      if($this->isFlagSet(self::FLAG_MA, $data)) $value = $value . self::FLAG_MA . ",";
      if($this->isFlagSet(self::FLAG_MI, $data)) $value = $value . self::FLAG_MI . ",";
      if($this->isFlagSet(self::FLAG_JU, $data)) $value = $value . self::FLAG_JU . ",";
      if($this->isFlagSet(self::FLAG_VI, $data)) $value = $value . self::FLAG_VI . ",";
      if($this->isFlagSet(self::FLAG_SA, $data)) $value = $value . self::FLAG_SA . ",";

      return $value;
  }
}
