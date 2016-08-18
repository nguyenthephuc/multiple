<?php
namespace Multiple\Backend\Controllers;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Multiple\Backend\Models\User;
use Multiple\Backend\Plugins\Validator;

class UserController extends ControllerBase
{
    public function onConstruct()
    {
        parent::authentical(true);
        $this->view->setTemplateAfter('backend');
    }

    public function indexAction($page)
    {
        $currentPage = ($page > 0) ? $page : 1;
        $data = User::find(array('order'=>'id DESC'));
        $paginator = new PaginatorModel(
            array(
                "data"  => $data,
                "limit" => 20,
                "page"  => $currentPage
                )
            );
        $data = $paginator->getPaginate();
        $this->view->data = $data;
        $this->view->title = 'Quản lý tài khoản';
        if($this->request->isAjax()) $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }

    public function formAction($id)
    {
        $title = empty($id) ? 'Thêm tài khoản mới' : 'Cập nhật thông tin tài khoản';
        $action = empty($id) ? '/admin/user-insert' : '/admin/user-update';
        $data = ($id !== '') ? User::findFirstById($id) : '';
        $this->view->data = $data;
        $this->view->title = $title;
        $this->view->action = $action;
        if($this->request->isAjax()) $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }

    public function insertAction()
    {
        if(!$this->request->isPost()){
            $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'show404',
            ));
        } else {
            $params = [];
            $params['fname']    = trim($this->request->getPost('fname', 'string', ''));
            $params['lname']    = trim($this->request->getPost('lname', 'string', ''));
            $params['username'] = trim($this->request->getPost('username', 'string', ''));
            $params['pass']     = trim($this->request->getPost('pass', 'string', ''));
            $err = Validator::validate(array(
                    array('Họ và tên lót', $params['fname'],    'require'),
                    array('Tên',           $params['lname'],    'require'),
                    array('Tên tài khoản', $params['username'], 'require'),
                    array('Mật khẩu',      $params['pass'],     'require'),
                ));
            if(User::findFirstByUsername($params['username']))
                $err['username'] = 'Tài khoản đã tồn tại\n';
            Validator::errorback($err);
            $params['pass'] = $this->security->hash($params['pass']);
            User::insert($params);
            return $this->response->redirect('/admin/user-list/');
        }
    }

    public function updateAction()
    {
        if(!$this->request->isPost()){
            $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'show404',
            ));
        } else {
            $params = [];
            $params['fname']    = trim($this->request->getPost('fname', 'string', ''));
            $params['lname']    = trim($this->request->getPost('lname', 'string', ''));
            $params['username'] = trim($this->request->getPost('username', 'string', ''));
            $params['pass']     = trim($this->request->getPost('pass', 'string', ''));
            $params['id']       = trim($this->request->getPost('id', 'int', ''));
            $err = Validator::validate(array(
                    array('Họ và tên lót', $params['fname'],    'require'),
                    array('Tên',           $params['lname'],    'require'),
                    array('Tên tài khoản', $params['username'], 'require'),
                ));
            if( User::findFirst( array('conditions'=>'id <> ?1 and username = ?2', 'bind'=>array(1=>$params['id'], 2=>$params['username'])) ) )
                $err['username'] = 'Tài khoản đã tồn tại\n';
            Validator::errorback($err);
            if($params['pass'] !== '')
                $params['pass'] = $this->security->hash($params['pass']);
            else
                unset($params['pass']);
            User::updated($params['id'], $params);
            return $this->response->redirect('/admin/user-list/');
        }
    }

    public function deleteAction()
    {
        if(!$this->request->isPost()){
            $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'show404',
            ));
        } else {
            $id = $this->request->getPost('id', 'int', '');
            $user = User::findFirstById($id);
            if($user)
                $user->delete();
            return $this->response->redirect('/admin/user-list/');
        }
    }
}