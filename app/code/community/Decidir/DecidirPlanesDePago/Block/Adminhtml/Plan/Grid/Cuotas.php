<?php

class Decidir_DecidirPlanesDePago_Block_Adminhtml_Plan_Grid_Cuotas extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

	public function render(Varien_Object $row) {
		$value =  $row->getData($this->getColumn()->getIndex());
		return $this->getValueCuotas($value);
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

    public function getValueCuotas($data) {
      $value = "";

			for ($i=1; $i <= 24; $i++) {
				$pow = pow(2,($i-1));
				if($this->isFlagSet($pow, $data)){
					if ($value != null) {
						$value .= ", ";
					}
					$value .= strval($i);
				}
			}

      return $value;
  }

	public function getMultiselectValue($data)
	{
		$value = "";

		for ($i=1; $i <= 24; $i++) {
			$pow = pow(2,($i-1));
			if($this->isFlagSet($pow, $data)){
				$value .= strval($pow).",";
			}
		}

		return $value;
	}
}
