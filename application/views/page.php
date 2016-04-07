<h2><?=$title;?></h2>
<?=$content;?>
<div class="col-sm-12 row" id="links">
    <?foreach($pageImgsData as $img){?>
    <a href="/public/img/original/<?=$img['src'];?>" data-gallery="">
        <img src="/public/img/thumb/<?=$img['src'];?>" style="width: 155px; height: 155px;">
    </a>
    <?}?>
</div>