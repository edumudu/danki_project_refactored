<?php

namespace DevWeb\Control;

use DevWeb\Model\Category;
use DevWeb\Model\Notice;
use DevWeb\Model\Site;

class NewsController extends Controller
{
    private $por_pag = 10;
    protected $base_uri = '/news';

    public function index()
    {
      $category = new Category;
      $notice = new Notice;
      $site = new Site;

      $categories = $category->select()->orderBy('order_id')->get();
      $news = $notice->select()->orderBy('date')->get();

      $news = array_map(function($News) use ($categories) {
        $categoryIndex = array_search($News['categoria_ref'], array_column($categories, 'id'));
        $News['category'] = $categories[$categoryIndex];

        return $News;
      }, $news);

      $info = [
        'base_url'    => $this->base_uri,
        'title'       => 'Noticias',
        'info_author' => $site->selectSingle(['id' => 1], ['name_author', 'descricao']),
        'categorias'  => $categories,
        'noticias'     => $news
      ];

      $view = $this->view('View');
      $view->add_script('news.js');
      $view->render('news', $info);
    }

    public function show ($categorySlug, $newsSlug)
    {
      $notice = new Notice;
      $category = new Category;

      $category = $category->selectSingle(['slug' => $categorySlug]);
      $notice = $notice->selectSingle(['slug' => $newsSlug, 'categoria_ref' => $category['id']]);

      if (!$category || !$notice) {
        self::redirect('/page-not-found');
      }

      $view = $this->view('View');
      $view->render('news_single', [
        'title'  => $notice['title'],
        'notice' => $notice
      ]);
    }

    public function search($categoryName)
    {
      $category = new Category;
      $notice = new Notice;
      $site = new Site;

      $categorySelected = $category->selectSingle(['slug' => $categoryName]);
      $categorySelected['name'] = $categoryName;
      $categories = $category->select()->orderBy('order_id')->get();
      $news = $notice->select()->where(['categoria_ref' => $categorySelected['id']])->get();

      $news = array_map(function($News) use ($categories) {
        $categoryIndex = array_search($News['categoria_ref'], array_column($categories, 'id'));
        $News['category'] = $categories[$categoryIndex];

        return $News;
      }, $news);

      $info = [
        'base_url'    => $this->base_uri,
        'title'       => 'Noticias',
        'info_author' => $site->selectSingle(['id' => 1], ['name_author', 'descricao']),
        'categorias'  => $categories,
        'categoria'   => $categorySelected,
        'noticias'    => $news
      ];

      $view = $this->view('View');
      $view->add_script('news.js');
      $view->render('news', $info);
    }
}

// EOF
