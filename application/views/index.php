<div id="region1wrap" class="xtc-bodygutter">
    <div id="region1pad" class="xtc-wrapperpad">
        <div id="region1" class="row-fluid xtc-wrapper r1spacer">
            <div class="module title-off  ">
                <div class="modulecontent">
                    <div id="jxtc1">
                        <ul id="jxtc1slider" class="unoslider">
                            <li>
                                <div class="unoslider_caption">
                                    <span class="unoslider_title">e-note</span>
                                    <span class="unoslider_description">Качественно. Разумно. Точно в срок.</span>
                                </div>
                                <img src="/public/i/120_342f403e3bd03ceee4a3934ef679495b_1280x402.png"/>
                            </li>
                            <li>
                                <div class="unoslider_caption">
                                    <span class="unoslider_title">e-note</span>
                                    <span class="unoslider_description">Мы знаем, что нужно Вашему бизнесу</span>
                                </div>
                                <img src="/public/i/121_893b3872f0a9bb8a525c06c1acd00cf0_1280x402.png"/>
                            </li>
                            <li>
                                <div class="unoslider_caption">
                                    <span class="unoslider_title">e-note</span>
                                    <span class="unoslider_description">Предовые технологии для вас</span>
                                </div>
                                <img src="/public/i/122_7c8e9045cb6624767abb6b84c4447e0e_1280x402.png"/>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="r1separator"></div>
    </div>
</div>
<div id="region2wrap" class="xtc-bodygutter">
    <div id="region2pad" class="xtc-wrapperpad">
        <div id="region2" class="row-fluid xtc-wrapper r2spacer">
            <div id="user1_6" class="span12">
                <div class="row-fluid">
                    <div id="user1" class="xtcBootstrapGrid span12 singlecolumn cols-1 column-1">
                        <div class="singlearea">
                            <div class="module title-off   pushleft">
                                <div class="modulecontent">
                                    <ul class="menu imgmenu xtcdefaultmenu">
                                        <li class="item-34 subcol0">
                                            <a href="/solution-it-top" >
                                                <img src="/public/i/computer.png" alt="IT-инфраструктура" />
                                                <span class="image-title">
                                                  IT-инфраструктура
                                                  <span class='xmenu'>IT-комплексы и сети</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="item-35 subcol1">
                                            <a href="/telecommunication-top" >
                                                <img src="/public/i/network.png" alt="Телекоммуникации" />
                                                <span class="image-title">
                                                    Телекоммуникации
                                                    <span class='xmenu'>Телефония, средства связи</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="item-30 subcol0">
                                            <a href="/security-top" >
                                                <img src="/public/i/lock.png" alt="Безопасность" />
                                                <span class="image-title">
                                                    Безопасность
                                                    <span class='xmenu'>Информационная защита</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="item-36 subcol1">
                                            <a href="/data-top" >
                                                <img src="/public/i/data.png" alt="Данные" />
                                                <span class="image-title">
                                                    Данные
                                                    <span class='xmenu'>Хранение и обработка данных</span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="region7wrap" class="xtc-bodygutter">
    <div id="region7pad" class="xtc-wrapperpad">
        <div id="region7" class="row-fluid xtc-wrapper r7spacer">
            <div class="center span12">
                <div id="user19_24" class="clearfix">
                    <div class="row-fluid">
                        <div id="user31" class="xtcBootstrapGrid span12 singlecolumn cols-1 column-1">
                            <div class="singlearea">
                                <div class="module title-off  ">
                                    <div class="modulecontent">
                                        <div id="jxtc4">
                                            <div class="newswrap">
                                                <div id="wallviewjxtc4" class="wallview columns-4 rows-2" style="overflow:hidden">
                                                    <div id="wallsliderjxtc4" class="wallslider">
                                                        <div class="wallsliderrow">
                                                            <div class="wallslidercell">
                                                                <div class="wallpage singlepage page-1" >
                                                                    <? foreach ($newsAssets as $i => $news) {
                                                                        $imgData = json_decode($news['images']);

                                                                        $imgSrc = !empty($imgData) ? $imgData->image_intro : null;
                                                                        ?>
                                                                    <div class="wallfloat ceil">
                                                                        <div class="newsitemwrap" >
                                                                            <a href="<?=$news['path'];?>">
                                                                                <figure class="tint">
                                                                                    <img src="<?=$imgSrc;?>" class="intimage"  />
                                                                                </figure>
                                                                            </a>
                                                                            <div class="newstext">
                                                                                <h4><a class="titlelink" href="<?=$news['path'];?>"><?=$news['title'];?></a></h4>
                                                                                <p class="article-info"><?=date('d-m-Y', strtotime($news['publish_up']));?></p>
                                                                                <p class="article-intro"><?=mb_substr(trim(strip_tags($news['introtext'])), 0, 80);?>...</p>
                                                                                <br />
                                                                                <p><a href="<?=$news['path'];?>" class="first"><button class="red-pill"><span>Далее…</span></button></a></p>
                                                                            </div>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

