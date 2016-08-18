<?php
namespace Multiple\Backend\Controllers;

class IndexController extends ControllerBase
{
    public function onConstruct()
    {
        parent::authentical();
        $this->view->setTemplateAfter('backend');
    }

	public function indexAction()
	{
        $this->view->title = 'Chào mừng đến với trang quản trị';
        if($this->request->isAjax()) $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
	}

    public function logoutAction()
    {
        if($this->session->has('user-login')) $this->session->remove('user-login');
        return $this->response->redirect('/admin/login/'.date('Ymd'));
    }
}