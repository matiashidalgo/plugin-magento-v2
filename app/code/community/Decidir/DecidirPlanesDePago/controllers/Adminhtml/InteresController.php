<?php

class Decidir_DecidirPlanesDePago_Adminhtml_InteresController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("decidirplanesv1/interes")->_addBreadcrumb(Mage::helper("adminhtml")->__("Coeficientes  Manager"),Mage::helper("adminhtml")->__("Coeficientes Manager"));
				return $this;
		}
		//////
		protected function _initActionCupon()
		{
			$this->loadLayout()->_setActiveMenu("decidirplanesv1/interes")->_addBreadcrumb(Mage::helper("adminhtml")->__("Coeficientes  Manager"),Mage::helper("adminhtml")->__("Coeficientes Manager"));
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
			    $this->_title($this->__("Manager Interes"));

				$this->_initAction();
				$this->renderLayout();
		}

                //edita y graba por primera vez en blocks diferentes
		public function editAction()
		{
			    $this->_title($this->__("Decidirplanesv1"));
					$this->_title($this->__("Interes"));
			    $this->_title($this->__("Edit Item"));

				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("decidirplanesv1/interes")->load($id);
				if ($model->getId()) {
					Mage::register("interes_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("decidirplanesv1/interes");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Coeficientes Manager"), Mage::helper("adminhtml")->__("Coeficientes Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Coeficientes Description"), Mage::helper("adminhtml")->__("Coeficientes Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("decidirplanesv1/adminhtml_interes_editedit"))->_addLeft($this->getLayout()->createBlock("decidirplanesv1/adminhtml_interes_edit_tabsedit"));
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
		$this->_title($this->__("Interes"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("decidirplanesv1/interes")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("interes_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("decidirplanesv1/interes");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Interes Manager"), Mage::helper("adminhtml")->__("Interes Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Interes Description"), Mage::helper("adminhtml")->__("Interes Description"));


		$this->_addContent($this->getLayout()->createBlock("decidirplanesv1/adminhtml_interes_edit"))->_addLeft($this->getLayout()->createBlock("decidirplanesv1/adminhtml_interes_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {



						$model = Mage::getModel("decidirplanesv1/interes")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Interes was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setInteresData(false);

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
						Mage::getSingleton("adminhtml/session")->setInteresData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("decidirplanesv1/interes");
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
				$ids = $this->getRequest()->getPost('ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("decidirplanesv1/interes");
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
			$fileName   = 'interes.csv';
			$grid       = $this->getLayout()->createBlock('decidirplanesv1/adminhtml_interes_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		}
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'interes.xml';
			$grid       = $this->getLayout()->createBlock('decidirplanesv1/adminhtml_interes_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
