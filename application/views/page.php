<div id="region3wrap" class="xtc-bodygutter">
    <div id="region3pad" class="xtc-wrapperpad">
        <div id="region3" class="row-fluid xtc-wrapper r3spacer">
            <div id="left" class="span3"><div class="module title-on  lightbox">
                    <h3 class="moduletitle">
                        <span class="first_word">Новости</span>
                    </h3>
                    <div class="modulecontent">
                        <div id="jxtc2" style="z-index: 0;">
                            <div id="wallviewjxtc2" class="wallviewbootstrap columns-1 rows-4" style="overflow: hidden; height: 643px; background: none;">
                                <div id="wallsliderjxtc2" class="wallslider" style="visibility: visible;">
                                    <div class="wallsliderrow">
                                        <div class="wallslidercell">
                                            <div class="wallpage singlepage page-1" style="width: 189px;">
                                                <? foreach ($newsAssets as $i => $news) {?>
                                                <div class="row-fluid firstrow row-<?=($i + 1);?>">
                                                    <div class="span12 singlecol col-1">
                                                        <div class="team">
                                                            <div class="team-lft"></div>
                                                            <div class="team-rt">
                                                                <h3 class="teamtitle-rt"><?=$news['title'];?></h3>
                                                                <div class="teamintro-rt">
                                                                    <?=mb_substr(trim(strip_tags($news['introtext'])), 0, 80);?>...
                                                                </div>
                                                                <a class="smallbluebutton" href="<?=$news['path'];?>">
                                                                    <span style=""><i class=" icon-circle-arrow-right"></i></span>Далее...
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div style="clear:both;"></div>
                                                    </div>
                                                </div>
                                                <?}?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>	<div class="center span9">

                <div id="component" class="r3spacer_top"><div class="item-page">
                    <div class="article_text">
                        <?=Arr::get($content, 'introtext');?>
                    </div>
                </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <div id="designcopy">Дизайн : <a href="http://joomlaworld.ru"><img src="http://joomlaworld.ru/copyright/design.png"></a></div></div><a href="http://joomlaworld.ru">	</a></div><a href="http://joomlaworld.ru">
            </a>
        </div>
    </div>
</div>

