<?php

/**
 * Class Content
 */
class Model_Content extends Kohana_Model
{
    /**
     * @return array
     */
    public function getMainMenu()
    {
        $mainElements = DB::select()
            ->from('menu')
            ->where('menutype', '=', 'mainmenu')
            ->and_where('published', '=', 1)
            ->and_where('level', '=', '1')
            ->execute()
            ->as_array()
        ;

        foreach ($mainElements as $key => $element) {
            $submenu = DB::select()
                ->from('menu')
                ->where('menutype', '=', 'mainmenu')
                ->and_where('published', '=', 1)
                ->and_where('parent_id', '=', $element['id'])
                ->execute()
                ->as_array()
            ;

            $mainElements[$key]['submenu'] = $submenu;
        }

        return $mainElements;
    }

    /**
     * @param null|string $path
     * @return array
     */
    public function findMenuByPath($path = null)
    {
        return DB::select()
            ->from('menu')
            ->where('path', '=', $path)
            ->limit(1)
            ->execute()
            ->current()
        ;
    }

    /**
     * @param null|string $path
     * @return array
     */
    public function findContentByPath($path = null)
    {
        return DB::select()
            ->from('content')
            ->where('path', '=', $path)
            ->limit(1)
            ->execute()
            ->current()
        ;
    }

    /**
     * @param int $id
     *
     * @return true
     */
    public function showContent($id)
    {
        DB::update('content')
            ->set(['state' => 1])
            ->where('id', '=', $id)
            ->execute()
        ;

        return true;
    }
    
    /**
     * @param int $id
     *
     * @return true
     */
    public function hideContent($id)
    {
        DB::update('content')
            ->set(['state' => 0])
            ->where('id', '=', $id)
            ->execute()
        ;

        return true;
    }

    /**
     * @param int $id
     *
     * @return true
     */
    public function removeContent($id)
    {
        DB::delete('content')
            ->where('id', '=', $id)
            ->execute()
        ;

        return true;
    }
}