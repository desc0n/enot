<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller
{

	public function action_change_password()
	{
		/** @var $adminModel Model_Admin */
		$adminModel = Model::factory('Admin');

		$this->response->body(View::factory('ajax')->set('content', json_encode($adminModel->changePassword())));
	}
	
	public function action_show_content()
	{
		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');

		$this->response->body(View::factory('ajax')->set('content', json_encode($contentModel->showContent($this->request->post('id')))));
	}

	public function action_hide_content()
	{
		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');

		$this->response->body(View::factory('ajax')->set('content', json_encode($contentModel->hideContent($this->request->post('id')))));
	}
	
	public function action_remove_content()
	{
		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');

		$this->response->body(View::factory('ajax')->set('content', json_encode($contentModel->removeContent($this->request->post('id')))));
	}
	
	public function action_remove_content_img()
	{
		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');

		$this->response->body(View::factory('ajax')->set('content', json_encode($contentModel->removeContentImg($this->request->post('id')))));
	}
	
	public function action_set_main_content_img()
	{
		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');

		$this->response->body(View::factory('ajax')->set('content', json_encode($contentModel->setMainContentImg($this->request->post('id')))));
	}
	
	public function action_set_intro_content_img()
	{
		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');

		$this->response->body(View::factory('ajax')->set('content', json_encode($contentModel->setIntroContentImg($this->request->post('id')))));
	}
}
