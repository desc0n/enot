<div id="region3wrap" class="xtc-bodygutter">
    <div id="region3pad" class="xtc-wrapperpad">
        <div id="region3" class="row-fluid xtc-wrapper r3spacer">
            <div class="center span12">
                <div id="component" class="r3spacer_top">
                    <div class="item-pageleftlarge">
                        <div class="xtc-full-img img-fulltext-right imgframe">
                            <img src="<?=!empty($imgData = json_decode($news['images'])) ? $imgData->image_fulltext : null;?>" alt="">
                        </div>
                        <div class="article_header">
                            <div class="article_date">
                                <div class="article_date_pad">
                                    <h5 class="day">23</h5><h5 class="month">Июль</h5>
                                </div>
                            </div>
                            <div class="article_info">
                                <h2 class="title">
                                    <a href="<?=$news['path'];?>">
                                        <?=$news['title'];?>
                                    </a>
                                </h2>
        	                    <span class="published">
                                Опубликовано: 23.07.2013 07:22&nbsp;
                                </span>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                        <div class="article_text">
                            <?=$news['fulltext'];?>
                        </div>
                        <ul class="pager pagenav">
                            <li class="previous">
                                <!--<a href="#" rel="prev">&lt; Назад</a>-->
                            </li>
                            <li class="next">
                                <!--<a href="#" rel="next">Вперёд &gt;</a>-->
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>