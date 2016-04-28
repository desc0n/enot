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
		$page = $this->request->param('id');
		$template = !Auth::instance()->logged_in() ? View::factory('admin_template') : View::factory('admin/template');

		$admin_content = View::factory('ajax')
			->set('content', '')
		;

		$template
			->set('page', $page)
		;

		if (Auth::instance()->logged_in('admin')){
			if (empty($page)){
				//$admin_content = Auth::instance()->logged_in('admin') ? $admin_content : '';
			} else if ($page == 'registration') {
				$admin_content = View::factory('registration')
					->set('username', Arr::get($_POST,'username',''))
					->set('email', Arr::get($_POST,'email',''))
					->set('error', '');
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
				} elseif (Arr::get($_GET, 'slug') == 'scope') {
					if (isset($_POST['redactpage'])) {
						$adminModel->setScopePage($_POST);

						HTTP::redirect($this->request->referrer());
					}

					$removeimg = isset($_POST['removeimg']) ? $_POST['removeimg'] : 0;
					$filename=Arr::get($_FILES, 'imgname', []);

					if (!empty(Arr::get($_POST, 'loadpageimg', 0)) != '' && !empty($filename)) {
						$adminModel->loadPageImg($_FILES, $_POST['loadpageimg']);

						HTTP::redirect($this->request->referrer());
					}

					if ($removeimg != 0) {
						$adminModel->removeScopePageImg($_POST);

						HTTP::redirect($this->request->referrer());
					}

					$pageData = Arr::get($_GET, 'id') !== null ? $contentModel->getScopePage(['slug' => Arr::get($_GET, 'id')]) : [];

					$admin_content = View::factory('admin/redact_page')
						->set('pageData', count($pageData) ? reset($pageData) : [])
						->set('pageImgsData', Arr::get($_GET, 'id') ? $contentModel->getScopePageImgs(['slug' => Arr::get($_GET, 'id'), 'enabled' => 'all']) : [])
						->set('scopePages', $contentModel->getScopePage())
						->set('pageList', $contentModel->getScopePage(['editable' => true]))
						->set('get', $_GET)
					;
				} elseif (Arr::get($_GET, 'slug') == 'portfolio') {
					if (isset($_POST['redactpage'])) {
						$adminModel->setPortfolioPage($_POST);

						HTTP::redirect($this->request->referrer());
					}

					if (isset($_POST['newProject'])) {
						$id = $adminModel->addPortfolioProject($this->request->post('id'), $this->request->post('title'));

						HTTP::redirect($this->request->referrer());
					}

					$removeimg = isset($_POST['removeimg']) ? $_POST['removeimg'] : 0;
					$filename=Arr::get($_FILES, 'imgname', []);

					if (!empty(Arr::get($_POST, 'loadpageimg', 0)) != '' && !empty($filename)) {
						$adminModel->loadPortfolioPageImg($_FILES, $_POST['loadpageimg']);

						HTTP::redirect($this->request->referrer());
					}

					if ($removeimg != 0) {
						$adminModel->removePortfolioPageImg($_POST);

						HTTP::redirect($this->request->referrer());
					}

					$admin_content = View::factory('admin/redact_portfolio')
						->set('pageData', Arr::get($_GET, 'id') !== null ? Arr::get($contentModel->getPortfolioPage($_GET), 0, []) : [])
						->set('pageImgsData', Arr::get($_GET, 'id') ? $contentModel->getPortfolioPageImgs($_GET) : [])
						->set('portfolioPages', $contentModel->getPortfolioPage())
						->set('portfolioProject', $contentModel->findPortfolioProject(Arr::get($_GET, 'id')))
						->set('get', $_GET)
					;
				} elseif (Arr::get($_GET, 'slug') == 'project') {
					if (isset($_POST['redactproject'])) {
						$adminModel->setPageContent('portfolio__projects', $this->request->post('redactproject'), $this->request->post('text'));
						$adminModel->setPageTitle('portfolio__projects', $this->request->post('redactproject'), $this->request->post('title'));

						HTTP::redirect($this->request->referrer());
					}

					$filename=Arr::get($_FILES, 'imgname', []);

					if (!empty(Arr::get($_POST, 'loadprojectimg', 0)) != '' && !empty($filename)) {
						$adminModel->loadPortfolioPprojectImg($_FILES, $_POST['loadprojectimg']);
						HTTP::redirect($this->request->referrer());
					}

					$admin_content = View::factory('admin/redact_portfolio_project')
						->set('pageData', Arr::get($contentModel->findPortfolioProject(null, $this->request->get('id')), 0, []))
						->set('pageImgsData', $contentModel->findProjectImgs($this->request->get('id'), null, 'all', 'all'))
						->set('get', $_GET)
					;
				}
			} elseif ($page == 'news') {
				$admin_content = View::factory('admin/download_news')
					->set('sources', $newsModel->findNewsSources())
				;
			} elseif ($page == 'news_list') {
				if (isset($_POST['newNews'])) {
					$adminModel->addNews($this->request->post('title'));

					HTTP::redirect($this->request->referrer());
				}

				$admin_content = View::factory('admin/news_list')
					->set('pageNewsData', $newsModel->findNews(null, null, null, 'all', 'all'))
				;
			} elseif ($page == 'redact_news') {
				if (isset($_POST['redactnews'])) {
					$adminModel->setNews($_POST);

					HTTP::redirect($this->request->referrer());
				}

				$admin_content = View::factory('admin/redact_news')
					->set('newsData', Arr::get($newsModel->findNews(null, $this->request->get('id'), null, 'all', 'all'), 0))
					->set('get', $_GET)
				;
			}
		}
		if (isset($_POST['reg'])) {
			if (Arr::get($_POST,'username','')=="") {
				$error = View::factory('error');
				$error->zag = "Не указан логин!";
				$error->mess = " Укажите Ваш логин.";
				$admin_content
					->set('content', $error)
				;
			} else if (Arr::get($_POST,'email','')=="") {
				$error = View::factory('error');
				$error->zag = "Не указана почта!";
				$error->mess = " Укажите Вашу почту.";
				$admin_content
					->set('content', $error)
				;
			} else if (Arr::get($_POST,'password','')=="") {
				$error = View::factory('error');
				$error->zag = "Не указан пароль!";
				$error->mess = " Укажите Ваш пароль.";
				$admin_content
					->set('content', $error)
				;
			} else if (Arr::get($_POST,'password','')!=Arr::get($_POST,'password2','')) {
				$error = View::factory('error');
				$error->zag = "Пароли не совпадают!";
				$error->mess = " Проверьте правильность подтверждения пароля.";
				$admin_content
					->set('content', $error)
				;
			} else {
				$user = ORM::factory('User');
				$user->values(array(
					'username' => $_POST['username'],
					'email' => $_POST['email'],
					'password' => $_POST['password'],
					'password_confirm' => $_POST['password2'],
				));
				$some_error = false;
				try {
					$user->save();
					$user->add("roles",ORM::factory("Role",1));
				}
				catch (ORM_Validation_Exception $e) {
					$some_error = $e->errors('models');
				}
				if ($some_error) {
					$error = View::factory('error');
					$error->zag = "Ошибка регистрационных данных!";
					$error->mess = " Проверьте правильность ввода данных.";
					if (isset($some_error['username'])) {
						if ($some_error['username']=="models/user.username.unique") {
							$error->zag = "Такое имя уже есть в базе!";
							$error->mess = " Придумайте новое.";
						}
					}
					else if (isset($some_error['email'])) {
						if ($some_error['email']=="email address must be an email address") {
							$error->zag = "Некорректный формат почты!";
							$error->mess = " Проверьте правильность написания почты.";
						}
						if ($some_error['email']=="models/user.email.unique") {
							$error->zag = "Такая почта есть в базе!";
							$error->mess = " Укажите другую почту.";
						}
					}

					$admin_content
						->set('content', $error)
					;
				}
			}
		}
		$this->response->body($template->set('admin_content', $admin_content));
	}
}