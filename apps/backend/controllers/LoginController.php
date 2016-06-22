<?php
namespace Multiple\Backend\Controllers;
use Multiple\Backend\Models\User;

class LoginController extends ControllerBase
{
    private $_error1 = "*Tên tài khoản và mật khẩu không được để trống!";
    private $_error2 = "*Tên tài khoản hoặc mật khẩu không đúng!";

    public function onConstruct()
    {
        parent::authentical();
    }

    public function indexAction()
    {
        if($this->request->isPost()){
            $username = $this->request->getPost('username', 'string');
            $password = $this->request->getPost('password', 'string');
            $this->view->username = $username;
            $this->view->password = $password;
            if($username === '' || $password === ''){
                $this->flashSession->success($this->_error1);
            } else {
                $user = User::findFirstByUsername($username);
                if(!$user){
                    $this->flashSession->success($this->_error2);
                } else {
                    if(!$this->security->checkHash($password, $user->pass)){
                        $this->flashSession->success($this->_error2);
                    } else {
                        $login = new \Phalcon\Session\Bag('user-login');
                        $login->fullname = $user->fname.' '.$user->lname;
                        $login->username = $user->username;
                        $login->role = $user->role;
                        $this->response->redirect('admin/dashboard');
                    }
                }
            }
        }
    }
}