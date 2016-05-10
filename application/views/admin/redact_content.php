<script src="//cdn.ckeditor.com/4.5.7/full/ckeditor.js"></script>
<div class="row right-content">
	<div class="row">
		<h3>Редактируем страницу</h3>
	</div>
	<form class="form-horizontal col-md-12 <?=(Arr::get($get, 'id') === null ? 'hide' : '');?>" method="post">
		<div class="row form-group">
			<button type="submit" class="btn btn-primary" name="redactcontent" value="<?=Arr::get($get, 'id', 0);?>">Сохранить</button>
		</div>
		<div class="row form-group">
			<label for="redact_content_title">Заголовок новости</label>
			<input type="text" id="redact_content_title" name="title" value="<?=Arr::get($contentData, 'title', '');?>" class="form-control">
		</div>
		<div class="row form-group">
			<label for="redact_content_introtext">Краткое описание</label>
			<textarea id="redact_content_introtext" name="introtext" class="form-control ckeditor"><?=Arr::get($contentData, 'introtext', '');?></textarea>
		</div>
		<div class="row form-group">
			<label for="redact_content_fulltext">Текст страницы</label>
			<textarea id="redact_content_fulltext" name="fulltext" class="ckeditor"><?=Arr::get($contentData, 'fulltext', '');?></textarea>
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
				<?
				$imgData = json_decode($contentData['images']);
				$fullTextImg = !empty($imgData) ? $imgData->image_fulltext : null;
				$introTextImg = !empty($imgData) ? $imgData->image_intro : null;

				foreach($contentImgsData as $img){
					$imgSrc = sprintf('/public/i/%d_%s', $img['id'], $img['src']);
					?>
					<tr id="rowContentImg<?=$img['id'];?>" class="gradeA">
						<td class="text-center">
							<div class="img-link">
								<img src="<?=$imgSrc;?>" >
							</div>
						</td>
						<td class="text-center media-middle">
							<?=sprintf('http://%s%s', $_SERVER['HTTP_HOST'], $imgSrc);?>
						</td>
						<td class="text-center media-middle">
							<div class="btn-row">
								<button class="btn btn-danger" onclick="removeContentImg(<?=$img['id'];?>);">
									<span class="glyphicon glyphicon-remove"></span> Удалить изображение
								</button>
							</div>
							<? if ($fullTextImg != $imgSrc) {?>
							<div class="btn-row">
								<button class="btn btn-primary" onclick="setMainContentImg(<?=$img['id'];?>);">
									<span class="glyphicon glyphicon-star"></span> Сделать главным при просмотре
								</button>
							</div>
							<?}?>
							<? if ($introTextImg != $imgSrc) {?>
							<div class="btn-row">
								<button class="btn btn-success" onclick="setIntroContentImg(<?=$img['id'];?>);">
									<span class="glyphicon glyphicon-star-empty"></span> Сделать главным в списке
								</button>
							</div>
							<?}?>
						</td>
					</tr>
				<?}?>
				</tbody>
			</table>
		</div>
		<div class="form-row row col-md-12">
			<button class="btn btn-success" onclick="$('#loadimg_modal').modal('toggle');">Добавить изображение <span class="glyphicon glyphicon-plus"></span></button>
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
					<input type="hidden" name="loadcontentimg" value="<?=Arr::get($get, 'id', 0);?>">
					<button type="submit" class="btn btn-default">Загрузить</button>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
