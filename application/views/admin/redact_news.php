<?
/** @var $contentModel Model_Content */
$contentModel = Model::factory('Content');
?>
<script src="//cdn.ckeditor.com/4.5.7/full/ckeditor.js"></script>
<div class="row right-content">
	<div class="row">
		<h3>Редактируем новость</h3>
	</div>
	<form class="form-horizontal col-md-12 <?=(Arr::get($get, 'id') === null ? 'hide' : '');?>" method="post">
		<div class="row form-group">
			<button type="submit" class="btn btn-primary" name="redactnews" value="<?=Arr::get($get, 'id', 0);?>">Сохранить</button>
		</div>
		<div class="row form-group">
			<label for="redact_content_title">Заголовок новости</label>
			<input type="text" id="redact_content_title" name="title" value="<?=Arr::get($newsData, 'title', '');?>" class="form-control">
		</div>
		<div class="row form-group">
			<label for="redact_content_text">Текст страницы</label>
			<textarea id="redact_content_text" name="content" class="ckeditor"><?=Arr::get($newsData, 'content', '');?></textarea>
		</div>
		<input type="hidden" name="slug" value="<?=Arr::get($get, 'slug');?>">
	</form>
</div>
