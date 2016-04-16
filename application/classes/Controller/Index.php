<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller
{
	/**
	 * @return View
	 */
	private function getBaseTemplate()
	{
		/** @var Model_Content $contentModel */
		$contentModel = Model::factory('Content');

		return View::factory('template')
			->set('mainmenuData', $contentModel->getMainMenu())
			->set('slug', $this->request->param('slug'))
			->set('get', $_GET)
			->set('post', $_POST)
		;
	}

	public function action_index()
	{
		$template = $this->getBaseTemplate();

		$template->content = View::factory('index');

		$this->response->body($template);
	}

	public function action_page()
	{
		/** @var Model_Content $contentModel */
		$contentModel = Model::factory('Content');

		/** @var Model_News $newsModel */
		$newsModel = Model::factory('News');

		$path = sprintf('/page/%s', $this->request->param('slug'));
		$content = View::factory(Arr::get($contentModel->findMenuByPath($path), 'template', 'index'))
			->set('content', $contentModel->findContentByPath($path))
			->set('newsAssets', $newsModel->findNewsAssets())
		;

		$template = $this->getBaseTemplate();

		$template
			->set('content', $content)
		;

		$this->response->body($template);
	}

}