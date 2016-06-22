<?php
namespace Multiple\Frontend\Controllers;
use Multiple\Frontend\Models\User;

class IndexController extends ControllerBase
{

	public function indexAction()
	{
        $data = User::find();
        $this->view->data = $data;
	}

    public function testAction()
    {
        echo \Phalcon\Version::get();
    }
}