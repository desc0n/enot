<?php

/**
 * Class Model_Articles
 */
class Model_Articles extends Kohana_Model
{
    /**
     * @return array
     */
    public function findArticlesAssets()
    {
        return DB::select('c.*')
            ->from(['content', 'c'])
            ->join(['assets', 'a'])
            ->on('c.asset_id', '=', 'a.id')
            ->where('a.parent_id', '=', 40)
            ->and_where('c.state', '=', 1)
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
}