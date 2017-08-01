<?php

class Decidir_DecidirPlanesDePago_Adminhtml_TarjetaController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu("decidirplanesv1/tarjeta")->_addBreadcrumb(Mage::helper("adminhtml")->__("ABM Medios de Pago"), Mage::helper("adminhtml")->__("ABM Medios de Pago"));
        // $this->getLayout()->createBlock('decidirplanesv1/adminhtml_tarjeta');
        return $this;
    }

    public function indexAction() {
        $this->_title($this->__("Decidirplanesv1"));
        $this->_title($this->__("ABM Medios de Pago"));
        Mage::log(__METHOD__);

        $this->_initAction();
        $this->renderLayout();
    }

    public function editAction() {
        $this->_title($this->__("Decidirplanesv1"));
        $this->_title($this->__("Medio de Pago"));
        $this->_title($this->__("Edit Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("decidirplanesv1/tarjeta")->load($id);
        if ($model->getId()) {
            if ($model['tipo'] == 0) {
                $model['tipo'] = 1;
            } else {
                $model['tipo'] = 0;
            }
            Mage::register("tarjeta_data", $model);
            $this->loadLayout();
            $this->_setActiveMenu("decidirplanesv1/tarjeta");
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("ABM Medios de Pago"), Mage::helper("adminhtml")->__("ABM Medios de Pago"));
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Medio de Pago Description"), Mage::helper("adminhtml")->__("Medio de Pago Description"));
            $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock("decidirplanesv1/adminhtml_tarjeta_editedit"))->_addLeft($this->getLayout()->createBlock("decidirplanesv1/adminhtml_tarjeta_edit_tabsedit"));
            $this->renderLayout();
        } else {
            Mage::getSingleton("adminhtml/session")->addError(Mage::helper("decidirplanesv1")->__("Item does not exist."));
            $this->_redirect("*/*/");
        }
    }

    public function newAction() {

        $this->_title($this->__("Decidirplanesv1"));
        $this->_title($this->__("Medios de Pago"));
        $this->_title($this->__("New Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("decidirplanesv1/tarjeta")->load($id);

        $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register("tarjeta_data", $model);

        $this->loadLayout();
        $this->_setActiveMenu("decidirplanesv1/tarjeta");

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("ABM Medios de Pago"), Mage::helper("adminhtml")->__("ABM Medios de Pago"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Medios de Pago Description"), Mage::helper("adminhtml")->__("Medios de Pago Description"));


        // $this->_addContent($this->getLayout()->createBlock("decidirplanesv1/adminhtml_tarjeta_edit"))->_addLeft($this->getLayout()->createBlock("decidirplanesv1/adminhtml_tarjeta_edit_tabs"));
        $this->_addContent($this->getLayout()->createBlock("decidirplanesv1/adminhtml_tarjeta_edit"))->_addLeft($this->getLayout()->createBlock("decidirplanesv1/adminhtml_tarjeta_edit_tabs"));

        $this->renderLayout();
    }

    public function saveAction() {

        $post_data = $this->getRequest()->getPost();

        if ($post_data['tipo'] == 0) {
            $post_data['tipo'] = 1;
        } else {
            $post_data['tipo'] = 0;
        }

        if ($post_data) {

            try {



                $model = Mage::getModel("decidirplanesv1/tarjeta")
                        ->addData($post_data)
                        ->setId($this->getRequest()->getParam("id"))
                        ->save();

                if ($post_data['tipo'] == 0) {
                    $post_data_plan['cupon_tarjeta'] = 0;
                    $post_data_plan['tarjeta_id'] = $post_data['clave'];
                    $post_data_plan['cuotas'] = 1;
                    $post_data_plan['activo'] = $post_data['activo'];
                    $post_data_plan['store_id'] = $post_data['store_id'];
                    $model = Mage::getModel("decidirplanesv1/plan")
                            ->addData($post_data_plan)
                            ->setId($this->getRequest()->getParam("id"))
                            ->save();
                }

                if ($post_data['tipo'] == 1) {
                    Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Tarjeta was successfully saved"));
                } else {
                    Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Cupón was successfully saved"));
                }
                Mage::getSingleton("adminhtml/session")->setTarjetaData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::log($e->getMessage());
                Mage::getSingleton("adminhtml/session")->addError("Error al guardar, revise los datos e intente nuevamente");
                Mage::getSingleton("adminhtml/session")->setTarjetaData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }
        }
        $this->_redirect("*/*/");
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $model = Mage::getModel("decidirplanesv1/tarjeta");
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
            $ids = $this->getRequest()->getPost('tarjeta_ids', array());
            foreach ($ids as $id) {
                $model = Mage::getModel("decidirplanesv1/tarjeta");
                $model->setId($id)->delete();
            }
            Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
        } catch (Exception $e) {
            Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction() {
        $fileName = 'tarjeta.csv';
        $grid = $this->getLayout()->createBlock('decidirplanesv1/adminhtml_tarjeta_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction() {
        $fileName = 'tarjeta.xml';
        $grid = $this->getLayout()->createBlock('decidirplanesv1/adminhtml_tarjeta_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

}
