<div id="region3wrap" class="xtc-bodygutter">
    <div id="region3pad" class="xtc-wrapperpad">
        <div id="region3" class="xtc-wrapper r3spacer">
            <div class="center span12">
                <div id="component" class="r3spacer_top">
                    <div class="blog-featured leftlarge">
                        <div class="items-leading xtc-leading">
                            <? foreach ($newsAssets as $i => $news) {
                                $imgData = json_decode($news['images']);

                                $imgSrc = !empty($imgData) ? $imgData->image_intro : null;
                                ?>
                            <?=(($i % 2) == 0 ? '<div class="row">' : '');?>
                                <div class="news-ceil">
                                    <div class="cat-item">
                                        <div class="category_text">
                                            <div class="imgframe">
                                                <img src="<?=$imgSrc;?>" alt="">
                                            </div>
                                            <h4 class="title">
                                                <a href="<?=$news['path'];?>"><?=$news['title'];?></a>
                                            </h4>
                                            <?=$news['introtext'];?>
                                        </div>
                                        <div class="readmore">
                                            <a href="<?=$news['path'];?>">
                                                <span style="padding-right:8px;"><i class="icon-circle-arrow-right"></i></span>
                                                Подробнее...</a>
                                        </div>
                                        <div style="clear:both;"></div>
                                    </div>
                                <?=(($i % 2) == 1 ? '</div>' : '');?>
                            </div>
                            <?}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>