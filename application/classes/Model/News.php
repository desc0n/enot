<?php

/**
 * Class Model_News
 */
class Model_News extends Kohana_Model
{
    public $newsAssetsLimit = 4;

    /**
     * @return array
     */
    public function findNewsAssets()
    {
        return DB::select('c.*')
            ->from(['content', 'c'])
            ->join(['assets', 'a'])
            ->on('c.asset_id', '=', 'a.id')
            ->where('a.parent_id', '=', 45)
            ->and_where('c.state', '=', 1)
            ->order_by('c.ordering', 'DESC')
            ->limit($this->newsAssetsLimit)
            ->execute()
            ->as_array()
        ;
    }
}