<div class="row right-content">
	<h4>Список новостей</h4>
	<div class="row">
		<table class="table table-bordered" id="dataTables-example">
			<thead>
				<tr>
					<td>Дата добавления</td>
					<td>Заголовок новости</td>
					<td>Действия</td>
				</tr>
			</thead>
			<tbody>
				<?foreach($pageContentData as $news){
					$date = DateTime::createFromFormat('Y-m-d H:i:s', $news['publish_up']);
					?>
				<tr id="rowContent<?=$news['id'];?>" class="gradeA">
					<td class="text-center media-middle">
						<?=$date->format('Y.m.d');?>
					</td>
					<td class="text-center media-middle">
						<div class="img-link">
                            <a href="/admin/control_panel/redact_pages/?slug=content&id=<?=$news['id'];?>"><?=$news['title'];?></a>
						</div>
					</td>
					<td class="text-center">
						<div class="rowBtn1 btn-row">
							<?=($news['state'] == 1 ? sprintf('
							<button class="btn btn-warning" onclick="hideContent(%d);">
								<span class="glyphicon glyphicon-eye-close"></span> Скрыть
							</button>', $news['id']) : sprintf('
							<button class="btn btn-success" onclick="showContent(%d);">
								<span class="glyphicon glyphicon-eye-open"></span> Показать
							</button>', $news['id']));?>
						</div>
						<div class="rowBtn2 btn-row">
							<button class="btn btn-danger" onclick="removeContent(<?=$news['id'];?>);">
								<span class="glyphicon glyphicon-remove"></span> Удалить новость
							</button>
						</div>
					</td>
				</tr>
				<?}?>
			</tbody>
		</table>
	</div>
	<div class="form-row row col-md-12">
		<button class="btn btn-success" onclick="$('#newContentModal').modal('toggle');">Добавить новость <span class="glyphicon glyphicon-plus"></span></button>
	</div>
</div>
<div class="modal fade" id="newContentModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Добавление новости</h4>
			</div>
			<div class="modal-body">
				<form role="form" method="post">
					<label for="title">
						Заголовок новости
						<input type="text" name="title" id=title" class="form-control">
					</label>
					<br />
					<button type="submit" class="btn btn-default" name="newContent">Добавить</button>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>