<?php
namespace Multiple\Backend\Controllers;
use Phalcon\Mvc\Controller;
use Multiple\Backend\Models\User;

class ControllerBase extends Controller
{
    public function authentical($master = false)
    {
        $uriLogin = '/admin/login/'.date('Ymd');
        // neu khong ton tai user login
        // va trang hien tai khong phai la trang login thi chuyen den trang login
        // de tranh truong hop redirect loop
        if(!$this->session->has('user-login') && $this->router->getRewriteUri() !== $uriLogin){
            return $this->response->redirect($uriLogin);
        } else if($this->session->has('user-login')) {
            // truong hop nguoc lai neu da ton tai session
            // user-login thi lay thong tin trong session
            $user_login = $this->session->get('user-login');
            $username   = isset($user_login['username']) ? $user_login['username'] : '';
            $role       = isset($user_login['role'])     ? $user_login['role'] : '';
            // kiem tra thong tin do co chinh xac khong
            $checklogin = User::findFirst( array('conditions'=>'username = ?1 and role = ?2', 'bind' => array(1=>$username, 2=>$role)) );
            // neu ton tai user dang nhap nhung user do khong hop le
            // va trang hien tai khong phai la trang login thi redirect den trang login
            // de tranh truong hop redirect loop
            if(!$checklogin && $this->router->getRewriteUri() !== $uriLogin){
                return $this->response->redirect($uriLogin);
            } else {
                // neu trang yeu cau phai co quyen master moi duoc vao
                // nen $master se bang true va kiem tra role hien tai neu khong phai = 1
                // thi chuyen ve trang dashboard
                if($master){
                    if((int)$role !== 1){
                        return $this->response->redirect('/admin/dashboard/');
                    }
                }
                // truong hop cuoi cung neu da ton tai user login
                // va user login co thuc, thi neu trang hien tai la trang login
                // thi chuyen den trang dashboard
                if($this->router->getRewriteUri() === $uriLogin){
                    return $this->response->redirect('/admin/dashboard/');
                }
                $this->view->user_login = $user_login;
            }
        }
    }
}