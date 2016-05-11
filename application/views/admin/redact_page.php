<?
/** @var $contentModel Model_Content */
$contentModel = Model::factory('Content');
?>
<script src="//cdn.ckeditor.com/4.5.7/full/ckeditor.js"></script>
<div class="row right-content">
	<div class="row">
		<form class="form-horizontal col-md-4">
			<label for="id">Страница:</label>
			<select class="form-control" name="id" id="id" onchange="$(this).parent('form').submit();">
				<option value="0">не выбрано</option>
				<?foreach ($mainmenuData as $menu) {
					if ($menu['template'] == 'page') {
						$page = $contentModel->findContentByPath($menu['path']);?>
				<option value="<?=Arr::get($page, 'id');?>" <?=(Arr::get($get, 'id') == Arr::get($page, 'id') ? 'selected' : '');?>><?=mb_strtoupper(Arr::get($page, 'title'));?></option>
						<? foreach ($menu['submenu'] as $submenuData) {
						$page = $contentModel->findContentByPath($submenuData['path']);?>
				<option value="<?=Arr::get($page, 'id');?>" <?=(Arr::get($get, 'id') == Arr::get($page, 'id') ? 'selected' : '');?>><?=mb_strtoupper(Arr::get($page, 'title'));?></option>
						<?}
					}
				}?>
			</select>
		</form>
	</div>
	<form class="form-horizontal col-md-12 <?=(Arr::get($get, 'id') === null ? 'hide' : '');?>" method="post">
		<div class="row">
			<h3>Редактируем страницу</h3>
		</div>
		<div class="row form-group">
			<label for="redact_content_text">Текст страницы</label>
			<textarea id="redact_content_text" name="text" class="ckeditor"><?=Arr::get($contentData, 'fulltext', '');?></textarea>
		</div>
		<div class="row form-group">
			<button type="submit" class="btn btn-primary" name="redactpage" value="<?=Arr::get($get, 'id', 0);?>">Сохранить</button>
		</div>
	</form>
	<div class="row form-row col-md-12 <?=(Arr::get($get, 'id') === null ? 'hide' : '');?>">
		<h4>Фото</h4>
		<div class="row">
			<table class="table table-bordered" id="dataTables-example">
				<thead>
					<tr>
						<td>Изображение</td>
						<td>Ссылка на изображение</td>
						<td>Действия</td>
					</tr>
				</thead>
				<tbody>
					<?foreach($contentImgsData as $img){
						$imgSrc = sprintf('/public/i/%d_%s', $img['id'], $img['src']);?>
					<tr id="rowImg<?=$img['id'];?>" class="gradeA">
						<td class="text-center">
							<div class="img-link">
								<img src="<?=$imgSrc;?>" >
							</div>
						</td>
						<td class="text-center media-middle">
							<?=sprintf('http://%s%s', $_SERVER['HTTP_HOST'], $imgSrc);?>
						</td>
						<td class="text-center media-middle">
							<div class="rowBtn2 btn-row">
								<button class="btn btn-danger" onclick="removeImg(<?=$img['id'];?>);">
									<span class="glyphicon glyphicon-remove"></span> Удалить изображение
								</button>
							</div>
						</td>
					</tr>
					<?}?>
				</tbody>
			</table>
		</div>
		<div class="form-row row col-md-12">
			<button class="btn btn-success" onclick="$('#loadimg_modal').modal('toggle');">Добавить фото <span class="glyphicon glyphicon-plus"></span></button>
		</div>
	</div>
</div>
<div class="modal fade" id="loadimg_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Загрузка изображения</h4>
			</div>
			<div class="modal-body">
				<form role="form" method="post" enctype='multipart/form-data'>
					<div class="form-group">
						<label for="exampleInputFile">Выбор файла</label>
						<input type="file" name="imgname[]" id="exampleInputFile" multiple>
					</div>
					<input type="hidden" name="loadpageimg" value="<?=Arr::get($contentData, 'id', 0);?>">
					<button type="submit" class="btn btn-default">Загрузить</button>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>