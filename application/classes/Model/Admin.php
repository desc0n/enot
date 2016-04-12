<?php

/**
 * Class Model_Admin
 */
class Model_Admin extends Kohana_Model
{

	private $user_id;

	public function __construct()
	{
		if (Auth::instance()->logged_in()) {
			$this->user_id = Auth::instance()->get_user()->id;
		} else {
			$this->user_id = 0;
		}
		DB::query(Database::UPDATE, "SET time_zone = '+10:00'")->execute();
	}

	public function getCategory($params = [])
	{
		$idSql = isset($params['category_id']) ? 'and `id` = :id' : '';
		return DB::query(Database::SELECT, "select * from `category` where 1 $idSql")
			->param(':id', Arr::get($params, 'category_id', 0))
			->execute()
			->as_array();
	}

	public function loadPageImg($filesGlobal, $page_id)
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
			$sql = "insert into `page_imgs` (`page_id`) values (:id)";
			$query = DB::query(Database::INSERT,$sql);
			$query->param(':id', $page_id);
			$query->execute();
			$sql = "select last_insert_id() as `new_id` from `page_imgs`";
			$query = DB::query(Database::SELECT,$sql);
			$res = $query->execute()->as_array();
			$new_id = $res[0]['new_id'];
			$imageName = preg_replace("/[^0-9a-z.]+/i", "0", Arr::get($files,'name',''));
			$file_name = 'public/img/original/'.$new_id.'_'.$imageName;
			if (copy($files['tmp_name'], $file_name))	{
				$image=Image::factory($file_name);
				$image->resize(800, NULL);
				$image->save($file_name,100);
				$thumb_file_name = 'public/img/thumb/'.$new_id.'_'.$imageName;
				if (copy($files['tmp_name'], $thumb_file_name))	{
					$thumb_image=Image::factory($thumb_file_name);
					$thumb_image->resize(150, NULL);
					$thumb_image->save($thumb_file_name,100);
					$sql = "update `page_imgs` set `src` = :src,`status_id` = 1 where `id` = :id";
					$query=DB::query(Database::UPDATE,$sql);
					$query->param(':id', $new_id);
					$query->param(':src', $new_id.'_'.$imageName);
					$query->execute();
				}
			}
		}
	}
	public function getPage($params = [])
	{
		$idSql = !empty(Arr::get($params, 'id', 0)) ? 'where `id` = :id' : '';
		return DB::query(Database::SELECT, "select * from `pages` $idSql")
			->param(':id', Arr::get($params, 'id', 0))
			->execute()
			->as_array();
	}

	public function getPageImgs($params = [])
	{
		$idSql = !empty(Arr::get($params, 'id', 0)) ? 'and `page_id` = :id' : '';
		return DB::query(Database::SELECT, "select * from `page_imgs` where `status_id` = 1 $idSql")
			->param(':id', Arr::get($params, 'id', 0))
			->execute()
			->as_array();
	}

	public function setPage($params = [])
	{
		$id = Arr::get($params, 'redactpage', 0);
		DB::query(Database::UPDATE, "update `pages` set `content` = :text where `id` = :id")
			->param(':id', $id)
			->param(':text', Arr::get($params, 'text', ''))
			->execute();
	}

	public function removePageImg($params = [])
	{
		$sql = "update `page_imgs` set `status_id` = 0 where `id` = :id";
		DB::query(Database::UPDATE,$sql)
			->param(':id', Arr::get($params,'removeimg',0))
			->execute();
	}

}
?>