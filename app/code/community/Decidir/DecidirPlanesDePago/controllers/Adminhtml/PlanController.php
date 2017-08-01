<?php

class Decidir_DecidirPlanesDePago_Adminhtml_PlanController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("decidirplanesv1/plan")->_addBreadcrumb(Mage::helper("adminhtml")->__("Plan  Manager"),Mage::helper("adminhtml")->__("Plan Manager"));
				return $this;
		}
		//////
		protected function _initActionCupon()
		{
			$this->loadLayout()->_setActiveMenu("decidirplanesv1/plan")->_addBreadcrumb(Mage::helper("adminhtml")->__("Plan  Manager"),Mage::helper("adminhtml")->__("Plan Manager"));
				return $this;
		}

		public function indexcuponAction()
		{
				$this->_title($this->__("Decidirplanesv1"));
			    $this->_title($this->__("Manager Cupones"));

				$this->_initAction();
				$this->renderLayout();
		}
		/////
		public function indexAction()
		{
			    $this->_title($this->__("Decidirplanesv1"));
			    $this->_title($this->__("Manager Plan"));

				$this->_initAction();
				$this->renderLayout();
		}

                //edita y graba por primera vez en blocks diferentes
		public function editAction()
		{
			    $this->_title($this->__("Decidirplanesv1"));
				$this->_title($this->__("Plan"));
			    $this->_title($this->__("Edit Item"));

				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("decidirplanesv1/plan")->load($id);
				if ($model->getId()) {
					Mage::register("plan_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("decidirplanesv1/plan");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Plan Manager"), Mage::helper("adminhtml")->__("Plan Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Plan Description"), Mage::helper("adminhtml")->__("Plan Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("decidirplanesv1/adminhtml_plan_editedit"))->_addLeft($this->getLayout()->createBlock("decidirplanesv1/adminhtml_plan_edit_tabsedit"));
					$this->renderLayout();
				}
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("decidirplanesv1")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Decidirplanesv1"));
		$this->_title($this->__("Plan"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("decidirplanesv1/plan")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("plan_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("decidirplanesv1/plan");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Plan Manager"), Mage::helper("adminhtml")->__("Plan Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Plan Description"), Mage::helper("adminhtml")->__("Plan Description"));


		$this->_addContent($this->getLayout()->createBlock("decidirplanesv1/adminhtml_plan_edit"))->_addLeft($this->getLayout()->createBlock("decidirplanesv1/adminhtml_plan_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();
				if ($post_data) {

					try {

						$post_data['cuotas'] = $this->parseMultiselect($post_data['cuotas']);
						$post_data['dias_semana'] = $this->parseMultiselect($post_data['dias_semana']);
						if(!array_key_exists("descuento", $post_data) || $post_data["descuento"] == null) $post_data["descuento"] = 0;
						if(!array_key_exists("reintegro", $post_data) || $post_data["reintegro"] == null) $post_data["reintegro"] = 0;
						// echo "<pre>";
						// var_dump($post_data);
						$post_data = $this->_filterDates($post_data, array("desde", "hasta"));
						// var_dump($post_data);
						// var_dump(Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT));
						// $desde = DateTime::createFromFormat("d/m/y", $post_data['desde']);
						// var_dump($desde);
						// var_dump(DateTime::getLastErrors());
						// echo "</pre>";
						// die;

						$model = Mage::getModel("decidirplanesv1/plan")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Plan was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setPlanData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					}
					catch (Exception $e) {
						Mage::log($e->getMessage());
						Mage::getSingleton("adminhtml/session")->addError("Error al guardar, revise los datos e intente nuevamente");
						Mage::getSingleton("adminhtml/session")->setPlanData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}

		public function parseMultiselect($selected_values)
		{
			$value_to_save = 0;
			foreach ($selected_values as $value) {
				$value_to_save += $value;
			}
			return $value_to_save;
		}

		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("decidirplanesv1/plan");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					}
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}


		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('plan_ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("decidirplanesv1/plan");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}

		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'plan.csv';
			$grid       = $this->getLayout()->createBlock('decidirplanesv1/adminhtml_plan_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		}
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'plan.xml';
			$grid       = $this->getLayout()->createBlock('decidirplanesv1/adminhtml_plan_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
