<script src="/public/js/ckeditor/ckeditor.js"></script>
<div class="row">
	<p>
	<form>
		<div class="text-muted col-sm-12">Страница:</div>
		<div class="col-sm-6">
			<select class="form-control" name="id">
				<option value="0">не выбрано</option>
				<?foreach (Model::factory('Admin')->getPage() as $page) {?>
				<option value="<?=$page['id'];?>" <?=(Arr::get($get, 'id', 0) == $page['id'] ? 'selected' : '');?>><?=$page['title'];?></option>
				<?}?>
			</select>
		</div>
		<button class="btn btn-default" type="submit">Выбрать</button>
	</form>
	</p>
	<form class="form-horizontal row" style="display:inline-block;margin-left:40px;" method="post" action="/admin/control_panel/redact_page">
		<p>
			<div class="row">
				<h3>Редактируем страницу</h3>
			</div>
		</p>
		<p>
			<div class="form-group span12">
				<label for="redact_content_text">Текст страницы</label>
				<textarea id="redact_content_text" name="text" class="ckeditor"><?=Arr::get($pageData, 'content', '');?></textarea>
			</div>
		</p>
		<p>
			<div class="row">
				<button type="submit" class="btn btn-primary" name="redactpage" value="<?=Arr::get($get, 'id', 0);?>">Сохранить</button>
			</div>
		</p>
	</form>
	<div>
		<h4>Фото</h4>
		<div>
			<?foreach($pageImgsData as $img){?>
				<div class="img-link" data-toggle="tooltip" data-placement="left" data-html="true" title="<img class='tooltip-img' src='/public/img/original/<?=$img['src'];?>'>">
					<img src="/public/img/thumb/<?=$img['src'];?>" >
					<span class="pull-right glyphicon glyphicon-remove" title="удалить" onclick="$('#remove_img > #removeimg').val(<?=$img['id'];?>);$('#remove_img').submit();"></span>
				</div>
			<?}?>
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
				<form role="form" action="/admin/control_panel/redact_page?id=<?=Arr::get($get, 'id', 0);?>" method="post" enctype='multipart/form-data'>
					<div class="form-group">
						<label for="exampleInputFile">Выбор файла</label>
						<input type="file" name="imgname[]" id="exampleInputFile" multiple>
					</div>
					<input type="hidden" name="loadpageimg" value="<?=Arr::get($get, 'id', 0);?>">
					<button type="submit" class="btn btn-default">Загрузить</button>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<form id="remove_img" action="/admin/control_panel/redact_page?id=<?=Arr::get($get, 'id', 0);?>" method="post">
	<input type="hidden" id="removeimg" name="removeimg" value="0">
</form>