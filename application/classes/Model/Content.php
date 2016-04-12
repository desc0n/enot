<?php

/**
 * Class Content
 */
class Model_Content extends Kohana_Model
{
    public function getMainMenu()
    {
        $mainElements = DB::select()
            ->from('menu')
            ->where('menutype', '=', 'mainmenu')
            ->and_where('published', '=', 1)
            ->and_where('parent_id', '=', '1')
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
}