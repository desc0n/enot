<?
/** @var $contentModel Model_Content */
$contentModel = Model::factory('Content');
?>
<script src="//cdn.ckeditor.com/4.5.7/full/ckeditor.js"></script>
<div class="row right-content">
	<div class="row">
		<form class="form-horizontal col-md-4">
			<label for="id">Раздел:</label>
			<select class="form-control" name="id" id="id" onchange="$(this).parent('form').submit();">
				<option value="0">не выбрано</option>
				<?foreach ($portfolioPages as $portfolioPage) {?>
				<option value="<?=$portfolioPage['id'];?>" <?=(Arr::get($get, 'id') == $portfolioPage['id'] ? 'selected' : '');?>><?=mb_strtoupper($portfolioPage['title']);?></option>
				<?}?>
			</select>
			<input type="hidden" name="slug" value="<?=Arr::get($get, 'slug');?>">
		</form>
	</div>
	<form class="form-horizontal col-md-12 <?=(Arr::get($get, 'id') === null ? 'hide' : '');?>" method="post">
		<div class="row">
			<h3>Редактируем раздел</h3>
		</div>
		<div class="row form-group">
			<label for="redact_content_text">Текст раздела</label>
			<textarea id="redact_content_text" name="text" class="ckeditor"><?=Arr::get($pageData, 'content', '');?></textarea>
		</div>
		<div class="row form-group">
			<button type="submit" class="btn btn-primary" name="redactpage" value="<?=Arr::get($get, 'id', 0);?>">Сохранить</button>
		</div>
		<input type="hidden" name="slug" value="<?=Arr::get($get, 'slug');?>">
	</form>
	<div class="row form-row col-md-8 <?=(Arr::get($get, 'id') === null ? 'hide' : '');?>">
		<h4>Проекты</h4>
		<div class="row">
			<table class="table table-bordered" id="dataTables-example">
				<thead>
				<tr>
					<td>Название проекта</td>
					<td>Действия</td>
				</tr>
				</thead>
				<tbody>
				<?foreach($portfolioProject as $project){?>
					<tr class="gradeA">
						<td class="text-center media-middle">
							<a href="/project/<?=$project['slug'];?>" target="_blank"> <?=$project['title'];?></a>
						</td>
						<td class="text-center">
							<div class="rowBtn1 btn-row">
								<a class="btn btn-warning" href="/admin/control_panel/redact_pages/?id=<?=$project['id'];?>&slug=project">
									<span class="glyphicon glyphicon-eye-close"></span> Редактировать проект
								</a>
							</div>
							<div class="rowBtn2 btn-row">
								<button class="btn btn-danger" onclick="removeProject(<?=$project['id'];?>);">
									<span class="glyphicon glyphicon-remove"></span> Удалить проект
								</button>
							</div>
						</td>
					</tr>
				<?}?>
				</tbody>
			</table>
		</div>
		<div class="form-row row col-md-12">
			<button class="btn btn-success" onclick="$('#newProjectModal').modal('toggle');">Добавить проект <span class="glyphicon glyphicon-plus"></span></button>
		</div>
	</div>
</div>
<div class="modal fade" id="newProjectModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Добавление проекта</h4>
			</div>
			<div class="modal-body">
				<form role="form" method="post">
					<label for="title">
						Название проекта
						<input type="text" name="title" id=title" class="form-control">
					</label>
					<input type="hidden" name="id" value="<?=Arr::get($get, 'id');?>">
					<input type="hidden" name="slug" value="<?=Arr::get($get, 'slug');?>">
					<br />
					<button type="submit" class="btn btn-default" name="newProject">Добавить</button>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>