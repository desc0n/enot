<?php

/**
 * Class Model_Articles
 */
class Model_Articles extends Kohana_Model
{
    /**
     * @var null|mixed $state
     * @return array
     */
    public function findArticlesAssets($state = 1)
    {
        $query = DB::select('c.*')
            ->from(['content', 'c'])
            ->join(['assets', 'a'])
            ->on('c.asset_id', '=', 'a.id')
            ->where('a.parent_id', '=', 40)
        ;
        
        $query = null !== $state ? $query->and_where('c.state', '=', $state) : $query;
        
        return
            $query
            ->order_by('c.ordering', 'ASC')
            ->execute()
            ->as_array()
        ;
    }
    
    /**
     * @return array
     */
    public function findArticlesAssetsByPath($path)
    {
        return DB::select('c.*')
            ->from(['content', 'c'])
            ->where('c.path', '=', ':path')
            ->param(':path', $path)
            ->limit(1)
            ->execute()
            ->current()
        ;
    }

    /**
     * @param string $title
     *
     * @return int|null
     */
    public function addArticle($title = 'Заголовок')
    {
        /** @var $adminModel Model_Admin */
        $adminModel = Model::factory('Admin');
        
        $res = DB::insert('assets', ['parent_id', 'level', 'title'])
            ->values([40, 2, $title])
            ->execute()
        ;

        $assetId = Arr::get($res, 0);

        $res = DB::insert('content', ['asset_id', 'path', 'title', 'created', 'publish_up'])
            ->values([$assetId, sprintf('/article/%s', $adminModel->slugify($title)), $title, DB::expr('now()'), DB::expr('now()')])
            ->execute()
        ;

        return Arr::get($res, 0);
    }
}