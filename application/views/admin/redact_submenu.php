<?
/** @var $contentModel Model_Content */
$contentModel = Model::factory('Content');

$selectMainMenu = [];

foreach ($contentModel->getMainMenu(null, 1) as $mainMenuData) {
	$selectMainMenu[$mainMenuData['id']] = $mainMenuData['title'];
}
?>
<div class="row right-content">
	<div class="row form-row col-md-12">
		<h4>Пункты меню</h4>
		<div class="row">
			<table class="table table-bordered" id="dataTables-example">
				<thead>
				<tr>
					<td>Родительский элемент</td>
					<td>Название</td>
					<td>Ссылка</td>
					<td>Действия</td>
				</tr>
				</thead>
				<tbody>
				<?foreach($menuData as $menu) {
					$parentElement = $contentModel->findMenuById($menu['parent_id']);?>
					<tr id="rowMenu<?=$menu['id'];?>" class="gradeA">
						<td class="text-center media-middle">
							<?=Form::select('select_main_menu', $selectMainMenu, $menu['parent_id'], ['class' => 'form-control selectMainMenu', 'data-id' => $menu['id']]);?>
						</td>
						<td class="text-center media-middle">
							<?=$menu['title'];?>
						</td>
						<td class="text-center media-middle">
							<?=$menu['path'];?>
						</td>
						<td class="text-center media-middle">
							<div class="btn-row">
								<button class="btn btn-danger" onclick="removeMenu(<?=$menu['id'];?>);">
									<span class="glyphicon glyphicon-remove"></span> Удалить
								</button>
							</div>
							<div class="rowBtn1 btn-row">
								<?=($menu['published'] == 1 ? sprintf('
								<button class="btn btn-warning" onclick="hideMenu(%d);">
									<span class="glyphicon glyphicon-eye-close"></span> Скрыть
								</button>', $menu['id']) : sprintf('
								<button class="btn btn-success" onclick="showMenu(%d);">
									<span class="glyphicon glyphicon-eye-open"></span> Показать
								</button>', $menu['id']));?>
							</div>
						</td>
					</tr>
				<?}?>
				</tbody>
			</table>
		</div>
		<div class="form-row row col-md-12">
			<button class="btn btn-success" onclick="$('#loadmenu_modal').modal('toggle');">Добавить пункт <span class="glyphicon glyphicon-plus"></span></button>
		</div>
	</div>
</div>
<div class="modal fade" id="loadmenu_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Добавление пункта меню</h4>
			</div>
			<div class="modal-body">
				<form role="form" method="post" enctype='multipart/form-data'>
					<div class="form-group">
						<label for="title">Название</label>
						<input type="text" name="title" id="title" class="form-control">
					</div>
					<button type="submit" class="btn btn-default" name="newmenu">Загрузить</button>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
