<?php

class Decidir_DecidirPlanesDePago_Adminhtml_BancoController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu("decidirplanesv1/banco")->_addBreadcrumb(Mage::helper("adminhtml")->__("ABM Entidades Financieras"), Mage::helper("adminhtml")->__("ABM Entidades Financieras"));
        return $this;
    }

    public function indexAction() {
        $this->_title($this->__("Decidirplanesv1"));
        $this->_title($this->__("ABM Entidades Fincncieras"));

        $this->_initAction();
        $this->renderLayout();
    }

    public function editAction() {
        $this->_title($this->__("Decidirplanesv1"));
        $this->_title($this->__("Banco"));
        $this->_title($this->__("Edit Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("decidirplanesv1/banco")->load($id);
        if ($model->getId()) {
            Mage::register("banco_data", $model);
            $this->loadLayout();
            $this->_setActiveMenu("decidirplanesv1/banco");
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("ABM Entidades Financieras"), Mage::helper("adminhtml")->__("ABM Entidades Financieras"));
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Entidades Financieras Description"), Mage::helper("adminhtml")->__("Entidades Financieras Description"));
            $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock("decidirplanesv1/adminhtml_banco_edit"))->_addLeft($this->getLayout()->createBlock("decidirplanesv1/adminhtml_banco_edit_tabs"));
            $this->renderLayout();
        } else {
            Mage::getSingleton("adminhtml/session")->addError(Mage::helper("decidirplanesv1")->__("Item does not exist."));
            $this->_redirect("*/*/");
        }
    }

    public function newAction() {

        $this->_title($this->__("Decidirplanesv1"));
        $this->_title($this->__("Entidades Financieras"));
        $this->_title($this->__("New Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("decidirplanesv1/banco")->load($id);

        $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register("banco_data", $model);

        $this->loadLayout();
        $this->_setActiveMenu("decidirplanesv1/banco");

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("ABM Entidades Financieras"), Mage::helper("adminhtml")->__("ABM Entidades Financieras"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Entidades Financieras Description"), Mage::helper("adminhtml")->__("Entidades Financieras Description"));


        $this->_addContent($this->getLayout()->createBlock("decidirplanesv1/adminhtml_banco_edit"))->_addLeft($this->getLayout()->createBlock("decidirplanesv1/adminhtml_banco_edit_tabs"));

        $this->renderLayout();
    }

    public function saveAction() {

        $post_data = $this->getRequest()->getPost();


        if ($post_data) {

            try {



                $model = Mage::getModel("decidirplanesv1/banco")
                        ->addData($post_data)
                        ->setId($this->getRequest()->getParam("id"))
                        ->save();

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Entidad Financiera was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setBancoData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::log($e->getMessage());
                Mage::getSingleton("adminhtml/session")->addError("Error al guardar, revise los datos e intente nuevamente");
                Mage::getSingleton("adminhtml/session")->setBancoData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }
        }
        $this->_redirect("*/*/");
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $model = Mage::getModel("decidirplanesv1/banco");
                $model->setId($this->getRequest()->getParam("id"))->delete();
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
                $this->_redirect("*/*/");
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
            }
        }
        $this->_redirect("*/*/");
    }

    public function massRemoveAction() {
        try {
            $ids = $this->getRequest()->getPost('banco_ids', array());
            foreach ($ids as $id) {
                $model = Mage::getModel("decidirplanesv1/banco");
                $model->setId($id)->delete();
            }
            Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Entidad(es) Financiera(s) was successfully removed"));
        } catch (Exception $e) {
            Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction() {
        $fileName = 'entidadesfinancieras.csv';
        $grid = $this->getLayout()->createBlock('decidirplanesv1/adminhtml_banco_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction() {
        $fileName = 'entidadesfinancieras.xls';
        $grid = $this->getLayout()->createBlock('decidirplanesv1/adminhtml_banco_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

}
