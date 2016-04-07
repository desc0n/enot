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
		if (Auth::instance()->logged_in() && isset($_POST['logout'])) {
			Auth::instance()->logout();
			HTTP::redirect('/');
		}
		if (!Auth::instance()->logged_in() && isset($_POST['login'])) {
			Auth::instance()->login($_POST['username'], $_POST['password'],true);
			HTTP::redirect('/admin/control_panel/');
		}
		$page = $this->request->param('id');
		$template = View::factory("admin_template");
		$admin_content = "";
		if (Auth::instance()->logged_in('admin')){
			if (empty($page)){
				//$admin_content = Auth::instance()->logged_in('admin') ? $admin_content : '';
			} else if ($page == 'registration') {
				$admin_content = View::factory('registration')
					->set('username', Arr::get($_POST,'username',''))
					->set('email', Arr::get($_POST,'email',''))
					->set('error', '');
			} else if ($page == 'redact_page') {
				if (isset($_POST['redactpage'])) {
					Model::factory('Admin')->setPage($_POST);
					HTTP::redirect('/admin/control_panel/redact_page?id=' . Arr::get($_POST, 'redactpage', 0));
				}
				$removeimg = isset($_POST['removeimg']) ? $_POST['removeimg'] : 0;
				$filename=Arr::get($_FILES, 'imgname', []);
				if (!empty(Arr::get($_GET, 'id', 0)) != '' && !empty($filename)) {
					Model::factory('Admin')->loadPageImg($_FILES, $_GET['id']);
					HTTP::redirect('/admin/control_panel/redact_page?id='.Arr::get($_GET, 'id', 0));
				}
				if ($removeimg != 0) {
					Model::factory('Admin')->removePageImg($_POST);
					HTTP::redirect('/admin/control_panel/redact_page?id='.Arr::get($_GET, 'id', 0));
				}
				$admin_content = View::factory('admin_redact_page')
					->set('pageData', Arr::get(Model::factory('Admin')->getPage($_GET), 0, []))
					->set('pageImgsData', Model::factory('Admin')->getPageImgs($_GET))
					->set('get', $_GET);
			}
		}
		if (isset($_POST['reg'])) {
			if (Arr::get($_POST,'username','')=="") {
				$error = View::factory('error');
				$error->zag = "Не указан логин!";
				$error->mess = " Укажите Ваш логин.";
				$admin_content->error = $error;
			} else if (Arr::get($_POST,'email','')=="") {
				$error = View::factory('error');
				$error->zag = "Не указана почта!";
				$error->mess = " Укажите Вашу почту.";
				$admin_content->error = $error;
			} else if (Arr::get($_POST,'password','')=="") {
				$error = View::factory('error');
				$error->zag = "Не указан пароль!";
				$error->mess = " Укажите Ваш пароль.";
				$admin_content->error = $error;
			} else if (Arr::get($_POST,'password','')!=Arr::get($_POST,'password2','')) {
				$error = View::factory('error');
				$error->zag = "Пароли не совпадают!";
				$error->mess = " Проверьте правильность подтверждения пароля.";
				$admin_content->error = $error;
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
					$admin_content->error = $error;
				}
			}
		}
		$this->response->body($template->set('admin_content', $admin_content));
	}
}