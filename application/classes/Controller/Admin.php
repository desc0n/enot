<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller {


	private function check_role($role_type = 1)
	{
		if($role_type == 1)
			if(!Auth::instance()->logged_in('admin'))
				HTTP::redirect('/');
		else if ($role_type == 2)
			if(!Auth::instance()->logged_in('manager'))
				HTTP::redirect('/');
	}

	public function action_index()
	{

	}

	public function action_control_panel()
	{
		/** @var Kohana_View $admin_content */

		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');

		/** @var $adminModel Model_Admin */
		$adminModel = Model::factory('Admin');

		/** @var Model_News $newsModel */
		$newsModel = Model::factory('News');

		if (Auth::instance()->logged_in() && isset($_POST['logout'])) {
			Auth::instance()->logout();
			HTTP::redirect('/');
		}

		if (!Auth::instance()->logged_in() && isset($_POST['login'])) {
			Auth::instance()->login($_POST['username'], $_POST['password'],true);
			HTTP::redirect('/admin/control_panel/');
		}

		$page = $this->request->param('slug');
		$template = !Auth::instance()->logged_in() ? View::factory('admin_template') : View::factory('admin/template');

		$admin_content = View::factory('ajax')
			->set('content', '')
		;

		$template
			->set('page', $page)
		;

		if (Auth::instance()->logged_in('admin')){
			if (empty($page)){
				
			} else if ($page == 'redact_pages') {
				if (Arr::get($_GET, 'slug') == 'page') {
					if (isset($_POST['redactpage'])) {
						if (Arr::get($_GET, 'id') == 'main') {
							$adminModel->setScopePageDescription($_POST);
						} else {
							$adminModel->setPage($_POST);
						}

						HTTP::redirect($this->request->referrer());
					}

					$removeimg = isset($_POST['removeimg']) ? $_POST['removeimg'] : 0;
					$filename=Arr::get($_FILES, 'imgname', []);

					if (!empty(Arr::get($_POST, 'loadpageimg', 0)) != '' && !empty($filename)) {
						$adminModel->loadPageImg($_FILES, $_POST['loadpageimg']);

						HTTP::redirect($this->request->referrer());
					}

					if ($removeimg != 0) {
						$adminModel->removePageImg($_POST);

						HTTP::redirect($this->request->referrer());
					}

					$admin_content = View::factory('admin/redact_page')
						->set('pageData', Arr::get($_GET, 'id') !== null ? Arr::get($contentModel->getPage($_GET), 0, []) : [])
						->set('pageImgsData', Arr::get($_GET, 'id') ? $contentModel->getPageImgs(['slug' => Arr::get($_GET, 'id'), 'enabled' => 'all']) : [])
						->set('scopePages', $contentModel->getScopePage())
						->set('pageList', $contentModel->getPage(['editable' => true]))
						->set('get', $_GET)
					;
				} elseif (Arr::get($_GET, 'slug') == 'content') {
					if (isset($_POST['redactcontent'])) {
						$contentModel->setContent(
							$this->request->post('redactcontent'),
							$this->request->post('title'),
							$this->request->post('introtext'),
							$this->request->post('fulltext')
						);

						HTTP::redirect($this->request->referrer());
					}

					$filename=Arr::get($_FILES, 'imgname', []);

					if (!empty($this->request->post('loadcontentimg')) && !empty($filename)) {
						$contentModel->loadContentImg($_FILES, $this->request->post('loadcontentimg'));

						HTTP::redirect($this->request->referrer());
					}

					$admin_content = View::factory('admin/redact_content')
						->set('contentData', $contentModel->findContentById($this->request->query('id')))
						->set('contentImgsData', $contentModel->findContentImgs($this->request->query('id')))
						->set('get', $_GET)
					;
				}
			} elseif ($page == 'news_list') {
				if (isset($_POST['newContent'])) {
					$newsModel->addNews($this->request->post('title'));

					HTTP::redirect($this->request->referrer());
				}

				$newsModel->newsAssetsLimit = 100;

				$admin_content = View::factory('admin/content_list')
					->set('pageContentData', $newsModel->findNewsAssets(null))
				;
			}
		}
		
		$this->response->body($template->set('admin_content', $admin_content));
	}
}