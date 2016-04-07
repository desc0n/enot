<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller {

	public function action_index()
	{
		$template=View::factory("template")
			->set('get', $_GET)
			->set('post', $_POST);
		$template->content = View::factory("index");
		$this->response->body($template);
	}

	public function action_page()
	{
		$id = $this->request->param('id');
		$_GET['id'] = $id;
		$template=View::factory("template")
			->set('get', $_GET);
		$pageData = Model::factory('Admin')->getPage($_GET);
		$template->content = View::factory("page")
			->set('title', Arr::get(Arr::get($pageData, 0, []), 'title', ''))
			->set('content', Arr::get(Arr::get($pageData, 0, []), 'content', ''))
			->set('pageImgsData', Model::factory('Admin')->getPageImgs($_GET));
		$this->response->body($template);
	}

}