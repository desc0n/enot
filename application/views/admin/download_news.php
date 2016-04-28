<?
/** @var $contentModel Model_Content */
$contentModel = Model::factory('Content');
?>
<div class="row right-content">
	<table class="table table-bordered">
		<thead>
			<tr>
				<td>Адрес источника</td>
				<td>Действия</td>
			</tr>
		</thead>
		<tbody>
			<?foreach($sources as $source){?>
			<tr id="rowNews<?=$source['id'];?>">
				<td class="text-center media-middle">
					<?=$source['link'];?>
				</td>
				<td class="text-center">
					<button class="btn btn-success" id="downloadNewsBtn<?=$source['id'];?>" onclick="downloadNews(<?=$source['id'];?>);">
						<span class="glyphicon glyphicon-download"></span> Скачать
					</button>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>