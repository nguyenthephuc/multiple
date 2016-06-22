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

    public function show404Action()
    {
        $this->response->setStatusCode(404, "Not Found");
        $this->view->title = 'Trang yêu cầu không được tìm thấy!';
        echo("<html>
                <head>
                    <title>Error 404 - Page Not Found</title>
                </head>
                <body>
                    <center style='margin-top: 5%; padding: 10px;'>
                        <img src='/backend/images/dead-bird-hi.png' alt='Error 404 - Page Not Found'>
                        <h1 style='color: teal'>ERROR 404</h1>
                        <p style='color: #7f8c8d'>You have tried to access a page which does not exist or has been moved.</p>
                    </center>
                </body>
            </html>");
    }
}