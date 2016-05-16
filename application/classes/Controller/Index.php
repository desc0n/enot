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
			->set('mainmenuData', $contentModel->getMainMenu(1, 1))
			->set('slug', $this->request->param('slug'))
			->set('get', $_GET)
			->set('post', $_POST)
		;
	}

	public function action_index()
	{
		/** @var Model_News $newsModel */
		$newsModel = Model::factory('News');

		$newsModel->newsAssetsLimit = 8;

		$template = $this->getBaseTemplate()
			->set('breadcrumbs', '<a href="/" class="pathway">Главная</a>')
		;

		$template->content = View::factory('index')
			->set('newsAssets', $newsModel->findNewsAssets())
		;

		$this->response->body($template);
	}

	public function action_page()
	{
        /** @var $adminModel Model_Admin */
        $adminModel = Model::factory('Admin');

		/** @var Model_Content $contentModel */
		$contentModel = Model::factory('Content');

		/** @var Model_News $newsModel */
		$newsModel = Model::factory('News');

		/** @var Model_Articles $articleModel */
		$articleModel = Model::factory('Articles');

        if (!empty($this->request->post('check_code'))) {
            $adminModel->sendMail(
                'descon@bk.ru',
                'Запрос со страницы контактов',
                sprintf('Тема письма: %s<br>\n Текст письма: %s', $this->request->post('subject'), $this->request->post('message')),
                $this->request->post('email')
            );

            if (
                $adminModel->sendMail(
                    $adminModel->systemMail,
                    'Запрос со страницы контактов',
                    sprintf('Тема письма: %s<br>\n Текст письма: %s', $this->request->post('subject'), $this->request->post('message')),
                    $this->request->post('email')
                )
            ) {
                HTTP::redirect(sprintf('%s/?result=success', $this->request->referrer()));
            }
        }

		$path = sprintf('/page/%s', $this->request->param('slug'));

		if ($path === '/page/news_list') {
			$newsModel->newsAssetsLimit = 8;
		}
		
		$contentData = $contentModel->findContentByPath($path);

		$content = View::factory(Arr::get($contentModel->findMenuByPath($path), 'template', 'index'))
			->set('content', $contentData)
			->set('newsAssets', $newsModel->findNewsAssets())
			->set('articleAssets', $articleModel->findArticlesAssets())
			->set('check_code', Captcha::instance()->render())
			->set('get', $this->request->query())
		;

		$template = $this->getBaseTemplate()
			->set('breadcrumbs', sprintf('<a href="/" class="pathway">Главная</a> &gt; <span class="here"> %s</span>', $contentData['title']))
		;

		$template
			->set('content', $content)
		;

		$this->response->body($template);
	}

	public function action_article()
	{
		/** @var Model_Content $contentModel */
		$contentModel = Model::factory('Content');

		/** @var Model_News $newsModel */
		$newsModel = Model::factory('News');

		$path = sprintf('/article/%s', $this->request->param('slug'));

		$contentData = $contentModel->findContentByPath($path);

		$content = View::factory(Arr::get($contentModel->findMenuByPath($path), 'template', 'article'))
			->set('content', $contentData)
			->set('newsAssets', $newsModel->findNewsAssets())
		;

		$template = $this->getBaseTemplate()
			->set('breadcrumbs', sprintf('<a href="/" class="pathway">Главная</a> &gt; <span class="here"> %s</span>', $contentData['title']))
		;

		$template
			->set('content', $content)
		;

		$this->response->body($template);
	}

	public function action_news()
	{
		/** @var Model_Content $contentModel */
		$contentModel = Model::factory('Content');

		/** @var Model_News $newsModel */
		$newsModel = Model::factory('News');

		$path = sprintf('/news/%s', $this->request->param('slug'));

		$news = $newsModel->findNewsAssetsByPath($path);

		$content = View::factory(Arr::get($contentModel->findMenuByPath($path), 'template', 'news'))
			->set('news', $news)
		;

		$template = $this->getBaseTemplate()
			->set('breadcrumbs', sprintf('<a href="/" class="pathway">Главная</a> &gt; <a href="/pages/news" class="pathway">Новости</a> &gt; <span class="here"> %s</span>', $news['title']))
		;

		$template
			->set('content', $content)
		;

		$this->response->body($template);
	}

}