<?
/** @var $contentModel Model_Content */
$contentModel = Model::factory('Content');
?>
<script src="//cdn.ckeditor.com/4.5.7/full/ckeditor.js"></script>
<div class="row right-content">
	<div class="row">
		<h3>Редактируем страницу</h3>
	</div>
	<form class="form-horizontal col-md-12 <?=(Arr::get($get, 'id') === null ? 'hide' : '');?>" method="post">
		<div class="row form-group">
			<label for="redact_content_title">Название проекта</label>
			<input type="text" id="redact_content_title" name="title" value="<?=Arr::get($pageData, 'title', '');?>" class="form-control">
		</div>
		<div class="row form-group">
			<label for="redact_content_text">Текст страницы</label>
			<textarea id="redact_content_text" name="text" class="ckeditor"><?=Arr::get($pageData, 'content', '');?></textarea>
		</div>
		<div class="row form-group">
			<button type="submit" class="btn btn-primary" name="redactproject" value="<?=Arr::get($get, 'id', 0);?>">Сохранить</button>
		</div>
		<input type="hidden" name="slug" value="<?=Arr::get($get, 'slug');?>">
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
					<?foreach($pageImgsData as $img){?>
					<tr id="rowProjectImg<?=$img['id'];?>" class="gradeA">
						<td class="text-center">
							<div class="img-link">
								<img src="/public/img/projects/thumb/<?=$img['src'];?>" >
							</div>
						</td>
						<td class="text-center media-middle">
								<?=sprintf('http://%s/public/img/projects/original/%s', $_SERVER['HTTP_HOST'], $img['src']);?>
						</td>
						<td class="text-center">
							<div class="rowBtn1 btn-row">
								<?=($img['enabled'] == 1 ? sprintf('
								<button class="btn btn-warning" onclick="hideProjectImg(%d);">
									<span class="glyphicon glyphicon-eye-close"></span> Скрыть изображение
								</button>', $img['id']) : sprintf('
								<button class="btn btn-success" onclick="showProjectImg(%d);">
									<span class="glyphicon glyphicon-eye-open"></span> Показать изображение
								</button>', $img['id']));?>
							</div>
							<div class="rowBtn3 btn-row">
								<?=($img['gallery_viewed'] == 1 ? sprintf('
								<button class="btn btn-primary" onclick="hideProjectGalleryImg(%d);">
									<span class="glyphicon glyphicon-eye-close"></span> Скрыть в галерее
								</button>', $img['id']) : sprintf('
								<button class="btn btn-info" onclick="showProjectGalleryImg(%d);">
									<span class="glyphicon glyphicon-eye-open"></span> Показать в галерее
								</button>', $img['id']));?>
							</div>
							<div class="rowBtn2 btn-row">
								<button class="btn btn-danger" onclick="removeProjectImg(<?=$img['id'];?>);">
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
					<input type="hidden" name="loadprojectimg" value="<?=Arr::get($pageData, 'id', 0);?>">
					<input type="hidden" name="id" value="<?=Arr::get($get, 'id');?>">
					<input type="hidden" name="slug" value="<?=Arr::get($get, 'slug');?>">
					<button type="submit" class="btn btn-default">Загрузить</button>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>