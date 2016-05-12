<?php

/**
 * Class Content
 */
class Model_Content extends Kohana_Model
{
    /**
     * @var mixed $published
     * @var mixed $level
     *
     * @return array
     */
    public function getMainMenu($published = null, $level = null)
    {
        /** @var Kohana_Database_Query_Builder_Select $query */

        $query = DB::select()
            ->from('menu')
        ;

        $query = null !== $published ? $query->and_where('published', '=', $published) : $query;
        $query = null !== $level ? $query->and_where('level', '=', $level) : $query;

        $mainElements = $query->execute()->as_array();

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
     * @param int $id
     * 
     * @return array
     */
    public function findMenuById($id)
    {
        return DB::select()
            ->from('menu')
            ->where('id', '=', $id)
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
     * @param null|int $id
     * @return array
     */
    public function findContentById($id = null)
    {
        return DB::select()
            ->from('content')
            ->where('id', '=', $id)
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

    /**
     * @param int $contentId
     * @param string $title
     * @param string $introtext
     * @param string $fulltext
     * @return bool
     */
    public function setContent($contentId, $title, $introtext, $fulltext)
    {
        DB::update('content')
            ->set(['title' => $title, 'introtext' => $introtext, 'fulltext' => $fulltext])
            ->where('id', '=', $contentId)
            ->execute()
        ;

        return true;
    }

    /**
     * @param int $contentId
     * @param string $fulltext
     * 
     * @return bool
     */
    public function setPage($contentId, $fulltext)
    {
        DB::update('content')
            ->set(['fulltext' => $fulltext])
            ->where('id', '=', $contentId)
            ->execute()
        ;

        return true;
    }

    public function findContentImgs($contentId)
    {
        return DB::select()
            ->from('content__imgs')
            ->where('content_id', '=', $contentId)
            ->execute()
            ->as_array()
        ;
    }

    /**
     * @param array $filesGlobal
     * @param int $contentId
     *
     * @return bool
     *
     * @throws Kohana_Exception
     */
    public function loadContentImg($filesGlobal, $contentId)
    {
        $filesData = [];

        foreach ($filesGlobal['imgname']['name'] as $key => $data) {
            $filesData[$key]['name'] = $filesGlobal['imgname']['name'][$key];
            $filesData[$key]['type'] = $filesGlobal['imgname']['type'][$key];
            $filesData[$key]['tmp_name'] = $filesGlobal['imgname']['tmp_name'][$key];
            $filesData[$key]['error'] = $filesGlobal['imgname']['error'][$key];
            $filesData[$key]['size'] = $filesGlobal['imgname']['size'][$key];
        }

        foreach ($filesData as $files) {
            $imageName = preg_replace("/[^0-9a-z.]+/i", "0", Arr::get($files,'name',''));

            $res = DB::insert('content__imgs', ['content_id', 'src'])
                ->values([$contentId, $imageName])
                ->execute()
            ;

            $file_name = sprintf('public/i/%d_%s', Arr::get($res, 0), $imageName);

            if (copy($files['tmp_name'], $file_name))	{}
        }

        return true;
    }


    /**
     * @param int $id
     *
     * @return true
     */
    public function removeContentImg($id)
    {
        DB::delete('content__imgs')
            ->where('id', '=', $id)
            ->execute()
        ;

        return true;
    }

    /**
     * @param int $imgId
     *
     * @return bool
     */
    public function setMainContentImg($imgId)
    {
        $imgData = DB::select()
            ->from('content__imgs')
            ->where('id', '=', $imgId)
            ->limit(1)
            ->execute()
            ->current()
        ;
        
        if ($imgData) {
            $contentData = $this->findContentById(Arr::get($imgData, 'content_id'));

            if ($contentData) {
                $contentImgData = json_decode($contentData['images']);
                
                $newImgData = [];

                if (!empty($contentImgData)) {
                    foreach ($contentImgData as $key => $val) {
                        $val = $key == 'image_fulltext' ? sprintf('/public/i/%d_%s', $imgData['id'], $imgData['src']) : $val;
                        $newImgData[$key] = $val;
                    }
                } else {
                    $newImgData['image_fulltext'] = sprintf('/public/i/%d_%s', $imgData['id'], $imgData['src']);
                    $newImgData['image_intro'] = '';
                }

                DB::update('content')
                    ->set(['images' => json_encode($newImgData)])
                    ->where('id', '=', $contentData['id'])
                    ->execute()
                ;
            }
        }
        
        return true;
    }
    
    /**
     * @param int $imgId
     *
     * @return bool
     */
    public function setIntroContentImg($imgId)
    {
        $imgData = DB::select()
            ->from('content__imgs')
            ->where('id', '=', $imgId)
            ->limit(1)
            ->execute()
            ->current()
        ;
        
        if ($imgData) {
            $contentData = $this->findContentById(Arr::get($imgData, 'content_id'));

            if ($contentData) {
                $contentImgData = json_decode($contentData['images']);
                
                $newImgData = [];

                if (!empty($contentImgData)) {
                    foreach ($contentImgData as $key => $val) {
                        $val = $key == 'image_intro' ? sprintf('/public/i/%d_%s', $imgData['id'], $imgData['src']) : $val;
                        $newImgData[$key] = $val;
                    }
                } else {
                    $newImgData['image_fulltext'] = '';
                    $newImgData['image_intro'] = sprintf('/public/i/%d_%s', $imgData['id'], $imgData['src']);
                }

                DB::update('content')
                    ->set(['images' => json_encode($newImgData)])
                    ->where('id', '=', $contentData['id'])
                    ->execute()
                ;
            }
        }
        
        return true;
    }

    /**
     * @param int $menuId
     * @param int|null $published
     * @param int|null $parentId
     *
     * @return bool
     */
    public function setMenu($menuId, $published = null, $parentId = null)
    {
        $colums = ['menutype'];
        $values = ['mainmenu'];

        if (null !== $published) {
            $colums[] = 'published';
            $values[] = $published;
        }
        
        if (null !== $parentId) {
            $colums[] = 'parent_id';
            $values[] = $parentId;
        }
        
        $volumes = [];
        
        for ($i = 0; $i < count($colums); $i++) {
            $volumes[$colums[$i]] = $values[$i];
        }
        
        DB::update('menu')
            ->set($volumes)
            ->where('id', '=', $menuId)
            ->execute()
        ;
        
        return true;
    }

    /**
     * @param int $id
     *
     * @return true
     */
    public function removeMenu($id)
    {
        DB::delete('menu')
            ->where('id', '=', $id)
            ->execute()
        ;

        return true;
    }

    /**
     * @param string $title
     * @param int $parentId
     * @param int $level
     *
     * @return true
     */
    public function addMenu($title, $parentId, $level)
    {
        /** @var $adminModel Model_Admin */
        $adminModel = Model::factory('Admin');

        $res = DB::insert('menu', ['menutype', 'title', 'path', 'parent_id', 'template', 'level'])
            ->values(['mainmenu', $title, sprintf('/page/%s', $adminModel->slugify($title)), $parentId, 'page', $level])
            ->execute()
        ;

        return Arr::get($res, 0);
    }

}