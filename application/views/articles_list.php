<div id="region3wrap" class="xtc-bodygutter">
    <div id="region3pad" class="xtc-wrapperpad">
        <div id="region3" class="xtc-wrapper r3spacer">
            <div class="center span12">
                <div id="component" class="r3spacer_top">
                    <div class="blog-featured leftlarge">
                        <div class="items-leading xtc-leading">
                            <? foreach ($articleAssets as $i => $article) {?>
                            <?=(($i % 2) == 0 ? '<div class="row">' : '');?>
                                <div class="article-ceil">
                                    <div class="cat-item">
                                        <div class="category_text article-intro">
                                            <h4 class="title">
                                                <a href="<?=$article['path'];?>"><?=$article['title'];?></a>
                                            </h4>
                                            <?=$article['introtext'];?>
                                        </div>
                                        <div class="readmore">
                                            <a href="<?=$article['path'];?>">
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