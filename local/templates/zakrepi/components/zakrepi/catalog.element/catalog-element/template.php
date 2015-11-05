<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$templateLibrary = array('popup');
$currencyList = '';
if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BASIS_PRICE' => $strMainID.'_basis_price',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'BASKET_ACTIONS' => $strMainID.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?>

<div class="product-page row">
<div class="col l12">
    <div class="main-info clearfix">
        <div class="col l9">
            <div class="card-header">

                <?/*name product*/?>
                <h1 class="product-title col l11"><?
                    echo (
                    isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != ''
                        ? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
                        : $arResult["NAME"]
                    ); ?></h1>
                <?/*end name product*/?>

                <?/*add in favorite*/?>
                <div class="col l1 right-align no-padding">
                    <a href="#" class="btn btn-favorite btn-icon"><svg class="icon"><use xlink:href="#heart"/></svg></a>
                </div>
                <?/*end add in favorite*/?>
                <div class="clearfix"></div>

                <?/*rating*/?>
                <? $rating = ceil($arResult['DISPLAY_PROPERTIES']['rating']['DISPLAY_VALUE']);?>
                <div class="rating rate-<?=$rating?>">
                    <svg class="star"><use xlink:href="#star"/></svg>
                    <svg class="star"><use xlink:href="#star"/></svg>
                    <svg class="star"><use xlink:href="#star"/></svg>
                    <svg class="star"><use xlink:href="#star"/></svg>
                    <svg class="star"><use xlink:href="#star"/></svg>
                </div>
                <?/*end rating*/?>

                <?/*articul*/?>
                <?if($arResult['DISPLAY_PROPERTIES']['CML2_ARTICLE']['DISPLAY_VALUE']!=''):?>
                    <div class="articul"><?=$arResult['DISPLAY_PROPERTIES']['CML2_ARTICLE']['NAME']?>: <?=$arResult['DISPLAY_PROPERTIES']['CML2_ARTICLE']['DISPLAY_VALUE']?></div>
                <?endif;?>
                <?/*end articul*/?>
            </div>

            <?/*images*/?>
            <div class="product-imgs row">

                <?/*small carousel images*/?>
                <div class="thumbs carousel-box vertical col">


                    <?
                    if ($arResult['SHOW_SLIDER'])
                    {
                        if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
                        {
                            if (5 < $arResult['MORE_PHOTO_COUNT'])
                            {
                                $strOneWidth = (100/$arResult['MORE_PHOTO_COUNT']).'%';
                                $strWidth = (20*$arResult['MORE_PHOTO_COUNT']).'%';
                            }
                            else
                            {
                                $strOneWidth = '20%';
                                $strWidth = '100%';
                            }
                            ?>
                            <div class="carousel">
                                <div class="carousel-inner">
                                    <?

                                    foreach ($arResult['MORE_PHOTO'] as $i => &$arOnePhoto)
                                    {
                                     ?>
                                        <a class="item thumb-link img-link center-align <?if($i == 0):?>active<?endif;?>" href="<? echo $arOnePhoto['SRC']; ?>">
                                            <img class="thumb-img" src="<? echo $arOnePhoto['SRC']; ?>"/>
                                        </a>
                                    <?
                                    }
                                    unset($arOnePhoto);
                                    ?>
                                </div>
                            </div>

                            <?if(count($arResult['MORE_PHOTO'])>3):?>
                            <div class="carousel-controlls">
                                <button class="prev"><svg class="icon"><use xlink:href="#arrow"/></svg></button>
                                <button class="next"><svg class="icon"><use xlink:href="#arrow"/></svg></button>
                            </div>
                            <?endif;?>
                        <?
                        }
                        else
                        {
                            foreach ($arResult['OFFERS'] as $key => $arOneOffer)
                            {
                                if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
                                    continue;
                                if (5 < $arOneOffer['MORE_PHOTO_COUNT'])
                                {
                                    $strOneWidth = (100/$arOneOffer['MORE_PHOTO_COUNT']).'%';
                                    $strWidth = (20*$arOneOffer['MORE_PHOTO_COUNT']).'%';
                                }
                                else
                                {
                                    $strOneWidth = '20%';
                                    $strWidth = '100%';
                                }
                                ?>
                                <div class="carousel">
                                    <div class="carousel-inner">
                                        <?
                                        foreach ($arOneOffer['MORE_PHOTO'] as $i => &$arOnePhoto)
                                        {
                                            ?>
                                            <a class="item thumb-link img-link center-align <?if($i == 0):?>active<?endif;?>" href="<? echo $arOnePhoto['SRC']; ?>">
                                                <img class="thumb-img" src="<? echo $arOnePhoto['SRC']; ?>"/>
                                            </a>
                                            <?
                                        }
                                        unset($arOnePhoto);
                                        ?>
                                    </div>
                                </div>
                                <?if(count($arResult['MORE_PHOTO'])>3):?>
                                    <div class="carousel-controlls">
                                        <button class="prev"><svg class="icon"><use xlink:href="#arrow"/></svg></button>
                                        <button class="next"><svg class="icon"><use xlink:href="#arrow"/></svg></button>
                                    </div>
                                <?endif;?>
                            <?
                            }
                        }
                    }
                    ?>
                </div>
                <?/*end small carousel images*/?>

                <?/*big image*/?>
                <div class="full-img col"><img id="<? echo $arItemIDs['PICT']; ?>" src="<? echo $arFirstPhoto['SRC']; ?>" alt="<? echo $strAlt; ?>" title="<? echo $strTitle; ?>"></div>
                <?/*end big image*/?>
            </div>
            <?/*end images*/?>

        </div>
        <div class="col l3 no-padding">
            <div class="action-panel">

                <?/*price*/?>
                <div class="product-price center-align">
                    <?
                        $minPrice = (isset($arResult['RATIO_PRICE']) ? $arResult['RATIO_PRICE'] : $arResult['MIN_PRICE']);
                        $boolDiscountShow = (0 < $minPrice['DISCOUNT_DIFF']);
                    ?>
                    <!-- если скидки нет, .old-price не выводить -->
                    <?if($boolDiscountShow):?>
                        <div class="old-price"><?=priceShow($minPrice['VALUE']);?></div>
                    <?endif;?>
                    <div class="price"><?=priceShow($minPrice['DISCOUNT_VALUE']);?></div>
                </div>
                <?/*end price*/?>

                <?/*options product*/?>
                <!-- если есть -->
                <div class="product-options">
                    <div class="inline-field clearfix">
                        <span class="label">Размер</span>
                        <div class="select-box hide-on-large-only">
                            <select id="prod-size" name="prod-size-sel">
                                <option value="v1" selected>44-46  170-176</option>
                                <option value="v2">48-50  170-176</option>
                                <option value="v3">52-54  170-176</option>
                                <option value="v4">56-58  170-176</option>
                                <option value="v5">60-62  170-176</option>
                            </select>
                            <div class="triangle"></div>
                        </div>
                        <div class="dropdown-box hide-on-med-and-down right">
                            <div class="dropdown-value">
                                <div class="item-text"></div>
                                <div class="triangle"></div>
                            </div>
                            <ul class="dropdown-list select-synh hide-on-med-and-down" data-select="prod-size">
                                <li class="dropdown-item" data-active="active">
                                    <input type="radio" class="dropdown-inp" name="prod-size" value="v1" id="prod-size-rad-v1" checked="checked" data-value-text="44-46  170-176"/>
                                    <label class="dropdown-title" for="prod-size-rad-v1">
                                        <div class="item-text">44-46  170-176</div>
                                    </label>
                                </li>
                                <li class="dropdown-item">
                                    <input type="radio" class="dropdown-inp" name="prod-size" value="v2" id="prod-size-rad-v2" data-value-text="48-50  170-176"/>
                                    <label class="dropdown-title" for="prod-size-rad-v2">
                                        <div class="item-text">48-50  170-176</div>
                                    </label>
                                </li>
                                <li class="dropdown-item">
                                    <input type="radio" class="dropdown-inp" name="prod-size" value="v3" id="prod-size-rad-v3" data-value-text="52-54  170-176"/>
                                    <label class="dropdown-title" for="prod-size-rad-v3">
                                        <div class="item-text">52-54  170-176</div>
                                    </label>
                                </li>
                                <li class="dropdown-item">
                                    <input type="radio" class="dropdown-inp" name="prod-size" value="v4" id="prod-size-rad-v4" data-value-text="56-58  170-176"/>
                                    <label class="dropdown-title" for="prod-size-rad-v4">
                                        <div class="item-text">56-58  170-176</div>
                                    </label>
                                </li>
                                <li class="dropdown-item">
                                    <input type="radio" class="dropdown-inp" name="prod-size" value="v5" id="prod-size-rad-v5" data-value-text="60-62  170-176"/>
                                    <label class="dropdown-title" for="prod-size-rad-v5">
                                        <div class="item-text">60-62  170-176</div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?/*end options product*/?>

                <?/*add basket*/?>
                <div class="action-buttons">
                    <a class="btn primary center fullwidth" href="#">В корзину</a>
                    <a class="btn standart-color center fullwidth" href="#">Купить в 1 клик</a>
                </div>
                <?/*end add basket*/?>

                <?/*delevery*/?>
                <div class="delivery-text">
                    <table>
                        <tr><td>Самовывоз:</td><td>Сегодня, Бесплатно</td></tr>
                        <tr><td>Доставим:</td><td>5 сентября, 8 699<i class="rouble">i</i></td></tr>
                    </table>
                </div>
                <?/*end delevery*/?>

                <?/*add compare*/?>
                <div class="compare">
                    <input type="checkbox" id="compare_today_{{product.id}}" />
                    <label class="checkbox-lbl" for="compare_today_{{product.id}}">Cравнить</label>
                </div>
                <?/*end add compare*/?>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>


<?/*more info and tabs*/?>
<div class="more-info full-width tabs">
<div class="tab-header"><div class="container">
        <ul class="tab-header-list">
            <li class="tab-header-item active">
                <a class="tab-link" href="#desc">Обзор товара</a>
            </li>
            <li class="tab-header-item">
                <a class="tab-link" href="#tech">Технические характеристики</a>
            </li>
            <li class="tab-header-item">
                <a class="tab-link" href="#accs">Аксессуары</a>
            </li>
            <li class="tab-header-item">
                <a class="tab-link" href="#reviews">Отзывы о товаре</a>
            </li>
            <li class="tab-header-item">
                <a class="tab-link" href="#shops">Наличие в магазинах</a>
            </li>
        </ul></div>
</div>
<div class="tab-content">
<div class="tab-content-item" id="desc">
    <div class="container">
        <div class="subtitle">Описание</div>
        <div class="desc-text col l9 no-padding nofloat">
            <?/*detail text*/?>
            <?
            if ('' != $arResult['DETAIL_TEXT'])
            {
                ?>
                    <?
                    if ('html' == $arResult['DETAIL_TEXT_TYPE'])
                    {
                        echo $arResult['DETAIL_TEXT'];
                    }
                    else
                    {
                        ?><p><? echo $arResult['DETAIL_TEXT']; ?></p><?
                    }
                    ?>
            <?
            }
            ?>
            <?/*end detail text*/?>

            <?/*options 5 element*/?>
            <div class="table col l5 nofloat no-padding">
                <?foreach($arResult['DISPLAY_PROPERTIES']['OPTIONS_5_ELEMENT'] as $item):?>
                    <div class="table-row no-padding col l12">
                        <div class="table-col col l7"><?=$item['DESCRIPTION']?></div>
                        <div class="table-col col l5"><?=$item['VALUE']?></div>
                    </div>
                <?endforeach;?>
                <a class="tab-link" href="#tech">Посмотреть все характеристики</a>
            </div>
            <?/*end options 5 element*/?>

            <?/*seo text*/?>
            <p><?=$arResult['PROPERTY_DESCRIPTION_VALUE']['ELEMENT_META_DESCRIPTION']?></p>
            <?/*end seo text*/?>

            <a href="#">Посмотреть все Гайковерты Hitachi </a>
        </div>
    </div>
</div>
<div class="tab-content-item" id="tech">
    <div class="container">
        <?/*all options element?>
        <div class="subtitle">Характеристики гайковерта Hitachi WR14VB-NA 420 Вт</div>
        <div class="table col l7 nofloat no-padding">
            <div class="table-row no-padding col l12">
                <div class="table-col col l8">Максимальный крутящий момент</div>
                <div class="table-col col l3">250 Нм</div>
            </div>
            <div class="table-row no-padding col l12">
                <div class="table-col col l8">Мощность</div>
                <div class="table-col col l3">420 Вт</div>
            </div>
            <div class="table-row no-padding col l12">
                <div class="table-col col l8">Максимальные обороты</div>
                <div class="table-col col l3">2300 об/мин</div>
            </div>
            <div class="table-row no-padding col l12">
                <div class="table-col col l8">Диаметр патрона</div>
                <div class="table-col col l3">12.7 мм</div>
            </div>
            <div class="table-row no-padding col l12">
                <div class="table-col col l8">Тип патрона</div>
                <div class="table-col col l3">внешний четырехгранник</div>
            </div>
            <div class="table-row no-padding col l12">
                <div class="table-col col l8">Размер крепежа</div>
                <div class="table-col col l3">М10-М18</div>
            </div>
            <div class="table-row no-padding col l12">
                <div class="table-col col l8">Наличие удара</div>
                <div class="table-col col l3">+</div>
            </div>
            <div class="table-row no-padding col l12">
                <div class="table-col col l8">Реверс</div>
                <div class="table-col col l3">+</div>
            </div>
            <div class="table-row no-padding col l12">
                <div class="table-col col l8">Электронная регулировка оборотов</div>
                <div class="table-col col l3">+</div>
            </div>
            <div class="table-row no-padding col l12">
                <div class="table-col col l8">Вес брутто</div>
                <div class="table-col col l3">3,2 кг</div>
            </div>
            <div class="table-row no-padding col l12">
                <div class="table-col col l8">Вес нетто</div>
                <div class="table-col col l3">2,2 кг</div>
            </div>
            <div class="table-row no-padding col l12">
                <div class="table-col col l8">Гарантия</div>
                <div class="table-col col l3">12 мес.</div>
            </div>
        </div>
        <?/*end all options element*/?>
    </div>
</div>
<div class="tab-content-item" id="accs">
    <div class="container">
        <div class="row">
            <div class="col l3">
                <ul class="menu sidebar-menu">
                    <li class="menu-item active"><a href="#" class="menu-link">Все</a></li>
                    <li class="menu-item"><a href="#" class="menu-link">Сверла и биты</a></li>
                    <li class="menu-item"><a href="#" class="menu-link">Головки торцевые</a></li>
                    <li class="menu-item"><a href="#" class="menu-link">Системы хранения</a></li>
                    <li class="menu-item"><a href="#" class="menu-link">Средства защиты</a></li>
                </ul>
            </div>
            <div class="col l9 catalog no-padding" ng-controller="CatalogProductsCtrl">
                <div class="product-list clearfix">
                    <div class="item col l3" ng-repeat="product in products | orderBy:sort:true">
                        <div class="product-card">
                            <div class="product-info">
                                <a class="item-img" href="product__single.php" style="background-image:url({{product.image}});"></a>
                                <div class="item-name"><a href="product__single.php">{{product.name}}</a></div>
                                <div ng-class="'rating rate-'+product.rating">
                                    <svg class="star"><use xlink:href="#star"/></svg>
                                    <svg class="star"><use xlink:href="#star"/></svg>
                                    <svg class="star"><use xlink:href="#star"/></svg>
                                    <svg class="star"><use xlink:href="#star"/></svg>
                                    <svg class="star"><use xlink:href="#star"/></svg>
                                </div>
                                <div class="product-price">
                                    <div class="old-price" ng-if="product.oldprice">{{product.oldprice}} <i class="rouble">i</i></div>
                                    <!-- в цене тысячи отделить неразрывным пробелом &nbsp; -->
                                    <div class="price">{{product.price}} <i class="rouble">i</i></div>
                                </div>
                                <a href="#" class="shopping-card btn btn-icon primary">
                                    <svg class="icon"><use xlink:href="#cart"/></svg>
                                </a>
                            </div>
                            <div class="compare">
                                <input type="checkbox" id="compare_today_{{product.id}}" />
                                <label class="checkbox-lbl" for="compare_today_{{product.id}}">Cравнить</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-content-item" id="reviews">
    <div class="container" id="reviews-res">
        <div class="subtitle">Отзывы о гайковерте Hitachi WR14VB-NA 420 Вт</div>
        <div class="row">
            <div class="sort-box col l6">
                <span class="sort-text">Сортировать по:</span>
                <input type="radio" class="hide sort-ctrl" name="sort" id="sort-date" value="date"/>
                <label class="sort-item" for="sort-date">дате</label>
                <input type="radio" class="hide sort-ctrl" name="sort" id="sort-rating" value="rating"/>
                <label class="sort-item" for="sort-rating">рейтингу</label>
            </div>
            <button class="btn primary col l2 right btn-toggle-block" data-block="#reviews-form,#reviews-res">Оставить отзыв</button>
        </div>
        <div class="reviews-list">
            <div class="review-item row">
                <div class="review-info col l3">
                    <div class="name medium-text">Александр</div>
                    <div class="date light-color">15.08.2015</div>
                    <div class="rating rate-2">
                        <svg class="star"><use xlink:href="#star"/></svg>
                        <svg class="star"><use xlink:href="#star"/></svg>
                        <svg class="star"><use xlink:href="#star"/></svg>
                        <svg class="star"><use xlink:href="#star"/></svg>
                        <svg class="star"><use xlink:href="#star"/></svg>
                    </div>
                </div>
                <div class="review-content col l9">
                    <div class="subtitle">Достоинства:</div>
                    <p>Пользуюсь год. Разбираю им машины. Крутит хорошо, без нареканий. Не понятно зачем нужен штифт, который вставляется в головку инструмента. Думаю, чтобы головка не слетала, хотя странное решение.</p>
                    <div class="subtitle">Недостатки:</div>
                    <p>Тяжелый и громоздкий. Подлезть куда то проблематично.</p>
                    <div class="subtitle">Комментарий:</div>
                    <p>Рекомендую. Не дорогой и надежный.</p>
                </div>
            </div>
            <div class="review-item row">
                <div class="review-info col l3">
                    <div class="name medium-text">Владислав</div>
                    <div class="date light-color">10.05.2015</div>
                    <div class="rating rate-3">
                        <svg class="star"><use xlink:href="#star"/></svg>
                        <svg class="star"><use xlink:href="#star"/></svg>
                        <svg class="star"><use xlink:href="#star"/></svg>
                        <svg class="star"><use xlink:href="#star"/></svg>
                        <svg class="star"><use xlink:href="#star"/></svg>
                    </div>
                </div>
                <div class="review-content col l9">
                    <div class="subtitle">Достоинства:</div>
                    <p>Пользуюсь год. Разбираю им машины. Крутит хорошо, без нареканий. Не понятно зачем нужен штифт, который вставляется в головку инструмента. Думаю, чтобы головка не слетала, хотя странное решение.</p>
                    <div class="subtitle">Недостатки:</div>
                    <p>Тяжелый и громоздкий. Подлезть куда то проблематично.</p>
                    <div class="subtitle">Комментарий:</div>
                    <p>Рекомендую. Не дорогой и надежный.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container hide" id="reviews-form">
        <div class="subtitle">Ваш отзыв о гайковерте Hitachi WR14VB-NA 420 Вт</div>
        <div class="row">
            <div class="col l6">
                <div class="table-field top-tf">
                    <div class="label">Имя</div>
                    <div class="field">
                        <input type="text" required />
                        <span class="error-text error-required">Укажите свое имя</span>
                    </div>
                </div>
                <div class="table-field top-tf">
                    <div class="label">Электронная почта</div>
                    <div class="field">
                        <input type="email" required />
                        <!-- 	.error-text - для всех ошибок,
                                .error-required, .error-pattern - можно задать разный текст для разных ошибок
                            -->
                        <span class="error-text error-required error-pattern">Укажите электронную почту в формате mymail@mail.ru</span>
                    </div>
                </div>
                <div class="table-field top-tf">
                    <div class="label">Рейтинг</div>
                    <div class="field rating-field">
                        <input class="hide rating-value" type="text"/>
                        <div class="rating rate-1">
                            <svg class="star"><use xlink:href="#star"/></svg>
                            <svg class="star"><use xlink:href="#star"/></svg>
                            <svg class="star"><use xlink:href="#star"/></svg>
                            <svg class="star"><use xlink:href="#star"/></svg>
                            <svg class="star"><use xlink:href="#star"/></svg>
                        </div>
                    </div>
                </div>
                <div class="table-field top-tf">
                    <div class="label">Достоинства</div>
                    <div class="field"><textarea></textarea></div>
                </div>
                <div class="table-field top-tf">
                    <div class="label">Недостатки</div>
                    <div class="field"><textarea></textarea></div>
                </div>
                <div class="table-field top-tf">
                    <div class="label">Комментарий</div>
                    <div class="field"><textarea></textarea></div>
                </div>
                <div class="table-field action-box">
                    <div class="second-field cols-2">
                        <button class="btn standart-color btn-toggle-block" data-block="#reviews-form,#reviews-res">Отменить</button>
                        <button class="btn primary">Оставить отзыв</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-content-item" id="shops">
    <div class="container">
        <div class="subtitle">Наличие товара в розничных магазинах «Крепыж»</div>
        <div class="row">
            <div class="col l3 shops-list">
                <div class="shop-item">
                    <div class="shop-title medium-text">Магазин на Черепанова</div>
                    <div class="shop-address">
                        <svg class="icon"><use xlink:href="#location"/></svg>
                        <span class="item-text">ул. Черепанова, 29</span>
                    </div>
                    <div class="shop-workhours">
                        <svg class="icon"><use xlink:href="#clock"/></svg>
									<span class="item-text">
										пн.–пт. 08:00–19:00<br/>
										Без обеда и выходных</span>
                    </div>
                </div>
                <div class="shop-item">
                    <div class="shop-title medium-text">Магазин на 50 лет Октября</div>
                    <div class="shop-address">
                        <svg class="icon"><use xlink:href="#location"/></svg>
                        <span class="item-text">ул. 50 лет Октября, 8/1</span>
                    </div>
                    <div class="shop-workhours">
                        <svg class="icon"><use xlink:href="#clock"/></svg>
									<span class="item-text">
										пн.–пт. 08:00–19:00<br/>
										Без обеда и выходных</span>
                    </div>
                </div>
                <div class="shop-item">
                    <div class="shop-title medium-text">Магазин на Ветеранов Труда</div>
                    <div class="shop-address">
                        <svg class="icon"><use xlink:href="#location"/></svg>
                        <span class="item-text">ул. Ветеранов Труда, 47</span>
                    </div>
                    <div class="shop-workhours">
                        <svg class="icon"><use xlink:href="#clock"/></svg>
									<span class="item-text">
										пн.–пт. 08:00–19:00<br/>
										Без обеда и выходных</span>
                    </div>
                </div>
                <div class="shop-item">
                    <div class="shop-title medium-text">Магазин на Пермякова</div>
                    <div class="shop-address">
                        <svg class="icon"><use xlink:href="#location"/></svg>
                        <span class="item-text">ул. Пермякова, 1а</span>
                    </div>
                    <div class="shop-workhours">
                        <svg class="icon"><use xlink:href="#clock"/></svg>
									<span class="item-text">
										пн.–пт. 08:00–19:00<br/>
										Без обеда и выходных</span>
                    </div>
                </div>
                <div class="shop-item">
                    <div class="shop-title medium-text">Магазин на Молодежной</div>
                    <div class="shop-address">
                        <svg class="icon"><use xlink:href="#location"/></svg>
                        <span class="item-text">ул. Молодежная, 72</span>
                    </div>
                    <div class="shop-workhours">
                        <svg class="icon"><use xlink:href="#clock"/></svg>
									<span class="item-text">
										пн.–пт. 08:00–19:00<br/>
										Без обеда и выходных</span>
                    </div>
                </div>
                <div class="shop-item">
                    <div class="shop-title medium-text">Магазин на Московском Тракте</div>
                    <div class="shop-address">
                        <svg class="icon"><use xlink:href="#location"/></svg>
                        <span class="item-text">ул. Московский тракт, 120/1</span>
                    </div>
                    <div class="shop-workhours">
                        <svg class="icon"><use xlink:href="#clock"/></svg>
									<span class="item-text">
										пн.–пт. 08:00–19:00<br/>
										Без обеда и выходных</span>
                    </div>
                </div>
            </div>
            <div class="col l9 shops-map">
                <div id="shops-map" class="map"></div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?/*end more info and tabs*/?>
</div>


<?/*with this product bought*/?>
<?if(!empty($arResult['WITH_PRODUCTS'])):?>
    <div class="tab-hide-box" data-hide-id="#accs">
        <div class="subtitle">Вместе с этим товаром покупают</div>
        <div class="product-carousel carousel-box" ng-controller="CatalogProductsCtrl">
            <div class="carousel row" data-jcarouselautoscroll="true" data-target="+=4" data-wrap="circular" data-interval="5000">
                <div class="carousel-inner product-list clearfix">
                    <div class="item col l3" ng-repeat="product in products | orderBy:sort:true">
                        <div class="product-card">
                            <div class="product-info">
                                <a class="item-img" href="#" style="background-image:url({{product.image}});"></a>
                                <div class="item-name"><a href="#">{{product.name}}</a></div>
                                <div ng-class="'rating rate-'+product.rating">
                                    <svg class="star"><use xlink:href="#star"/></svg>
                                    <svg class="star"><use xlink:href="#star"/></svg>
                                    <svg class="star"><use xlink:href="#star"/></svg>
                                    <svg class="star"><use xlink:href="#star"/></svg>
                                    <svg class="star"><use xlink:href="#star"/></svg>
                                </div>
                                <div class="product-price">
                                    <div class="old-price" ng-if="product.oldprice">{{product.oldprice}} <i class="rouble">i</i></div>
                                    <div class="price">{{product.price}} <i class="rouble">i</i></div>
                                </div>
                                <a href="#" class="shopping-card btn btn-icon primary">
                                    <svg class="icon"><use xlink:href="#cart"/>
                                </a>
                            </div>
                            <div class="compare">
                                <input type="checkbox" id="compare_today_{{product.id}}" />
                                <label class="checkbox-lbl" for="compare_today_{{product.id}}">Cравнить</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-controlls">
                <button class="prev" data-target="-=4"><svg class="icon"><use xlink:href="#arrow"/></svg></button>
                <button class="next" data-target="+=4"><svg class="icon"><use xlink:href="#arrow"/></svg></button>
            </div>
        </div>
    </div>
<?endif;?>
<?/*end with this product bought*/?>



<div class="bx_item_detail <? echo $templateData['TEMPLATE_CLASS']; ?>" id="<? echo $arItemIDs['ID']; ?>">
<?
if ('Y' == $arParams['DISPLAY_NAME'])
{
?>
<div class="bx_item_title"><h1><span><?
	echo (
		isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != ''
		? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
		: $arResult["NAME"]
	); ?>
</span></h1></div>
<?
}
reset($arResult['MORE_PHOTO']);
$arFirstPhoto = current($arResult['MORE_PHOTO']);
?>
	<div class="bx_item_container">
		<div class="bx_lt">
<div class="bx_item_slider" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
	<div class="bx_bigimages" id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>">
	<div class="bx_bigimages_imgcontainer">
	<span class="bx_bigimages_aligner"><img id="<? echo $arItemIDs['PICT']; ?>" src="<? echo $arFirstPhoto['SRC']; ?>" alt="<? echo $strAlt; ?>" title="<? echo $strTitle; ?>"></span>
<?
if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'])
{
	if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
	{
		if (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF'])
		{
?>
	<div class="bx_stick_disc right bottom" id="<? echo $arItemIDs['DISCOUNT_PICT_ID'] ?>"><? echo -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%</div>
<?
		}
	}
	else
	{
?>
	<div class="bx_stick_disc right bottom" id="<? echo $arItemIDs['DISCOUNT_PICT_ID'] ?>" style="display: none;"></div>
<?
	}
}
if ($arResult['LABEL'])
{
?>
	<div class="bx_stick average left top" id="<? echo $arItemIDs['STICKER_ID'] ?>" title="<? echo $arResult['LABEL_VALUE']; ?>"><? echo $arResult['LABEL_VALUE']; ?></div>
<?
}
?>
	</div>
	</div>
<?
if ($arResult['SHOW_SLIDER'])
{
	if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
	{
		if (5 < $arResult['MORE_PHOTO_COUNT'])
		{
			$strClass = 'bx_slider_conteiner full';
			$strOneWidth = (100/$arResult['MORE_PHOTO_COUNT']).'%';
			$strWidth = (20*$arResult['MORE_PHOTO_COUNT']).'%';
			$strSlideStyle = '';
		}
		else
		{
			$strClass = 'bx_slider_conteiner';
			$strOneWidth = '20%';
			$strWidth = '100%';
			$strSlideStyle = 'display: none;';
		}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
	<div class="bx_slider_scroller_container">
	<div class="bx_slide">
	<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">
<?
		foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto)
		{
?>
	<li data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
<?
		}
		unset($arOnePhoto);
?>
	</ul>
	</div>
	<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
	<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
	</div>
	</div>
<?
	}
	else
	{
		foreach ($arResult['OFFERS'] as $key => $arOneOffer)
		{
			if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
				continue;
			$strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
			if (5 < $arOneOffer['MORE_PHOTO_COUNT'])
			{
				$strClass = 'bx_slider_conteiner full';
				$strOneWidth = (100/$arOneOffer['MORE_PHOTO_COUNT']).'%';
				$strWidth = (20*$arOneOffer['MORE_PHOTO_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_slider_conteiner';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_OF_ID'].$arOneOffer['ID']; ?>" style="display: <? echo $strVisible; ?>;">
	<div class="bx_slider_scroller_container">
	<div class="bx_slide">
	<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST_OF_ID'].$arOneOffer['ID']; ?>">
<?
			foreach ($arOneOffer['MORE_PHOTO'] as &$arOnePhoto)
			{
?>
	<li data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
<?
			}
			unset($arOnePhoto);
?>
	</ul>
	</div>
	<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
	<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
	</div>
	</div>
<?
		}
	}
}
?>
</div>
		</div>
		<div class="bx_rt">
<?
$useBrands = ('Y' == $arParams['BRAND_USE']);
$useVoteRating = ('Y' == $arParams['USE_VOTE_RATING']);
if ($useBrands || $useVoteRating)
{
?>
	<div class="bx_optionblock">
<?
	if ($useVoteRating)
	{
		?><?$APPLICATION->IncludeComponent(
			"bitrix:iblock.vote",
			"stars",
			array(
				"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
				"IBLOCK_ID" => $arParams['IBLOCK_ID'],
				"ELEMENT_ID" => $arResult['ID'],
				"ELEMENT_CODE" => "",
				"MAX_VOTE" => "5",
				"VOTE_NAMES" => array("1", "2", "3", "4", "5"),
				"SET_STATUS_404" => "N",
				"DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
				"CACHE_TYPE" => $arParams['CACHE_TYPE'],
				"CACHE_TIME" => $arParams['CACHE_TIME']
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?><?
	}
	if ($useBrands)
	{
		?><?$APPLICATION->IncludeComponent("bitrix:catalog.brandblock", ".default", array(
			"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
			"IBLOCK_ID" => $arParams['IBLOCK_ID'],
			"ELEMENT_ID" => $arResult['ID'],
			"ELEMENT_CODE" => "",
			"PROP_CODE" => $arParams['BRAND_PROP_CODE'],
			"CACHE_TYPE" => $arParams['CACHE_TYPE'],
			"CACHE_TIME" => $arParams['CACHE_TIME'],
			"CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
			"WIDTH" => "",
			"HEIGHT" => ""
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?><?
	}
?>
	</div>
<?
}
unset($useVoteRating, $useBrands);
?>
<div class="item_price">
<?
$minPrice = (isset($arResult['RATIO_PRICE']) ? $arResult['RATIO_PRICE'] : $arResult['MIN_PRICE']);
$boolDiscountShow = (0 < $minPrice['DISCOUNT_DIFF']);
?>
	<div class="item_old_price" id="<? echo $arItemIDs['OLD_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? $minPrice['PRINT_VALUE'] : ''); ?></div>
	<div class="item_current_price" id="<? echo $arItemIDs['PRICE']; ?>"><? echo $minPrice['PRINT_DISCOUNT_VALUE']; ?></div>
	<div class="item_economy_price" id="<? echo $arItemIDs['DISCOUNT_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? GetMessage('CT_BCE_CATALOG_ECONOMY_INFO', array('#ECONOMY#' => $minPrice['PRINT_DISCOUNT_DIFF'])) : ''); ?></div>
</div>
<?
unset($minPrice);
if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
{
?>
<div class="item_info_section">
<?
	if (!empty($arResult['DISPLAY_PROPERTIES']))
	{
?>
	<dl>
<?
		foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp)
		{
?>
		<dt><? echo $arOneProp['NAME']; ?></dt><dd><?
			echo (
				is_array($arOneProp['DISPLAY_VALUE'])
				? implode(' / ', $arOneProp['DISPLAY_VALUE'])
				: $arOneProp['DISPLAY_VALUE']
			); ?></dd><?
		}
		unset($arOneProp);
?>
	</dl>
<?
	}
	if ($arResult['SHOW_OFFERS_PROPS'])
	{
?>
	<dl id="<? echo $arItemIDs['DISPLAY_PROP_DIV'] ?>" style="display: none;"></dl>
<?
	}
?>
</div>
<?
}
if ('' != $arResult['PREVIEW_TEXT'])
{
	if (
		'S' == $arParams['DISPLAY_PREVIEW_TEXT_MODE']
		|| ('E' == $arParams['DISPLAY_PREVIEW_TEXT_MODE'] && '' == $arResult['DETAIL_TEXT'])
	)
	{
?>
<div class="item_info_section">
<?
		echo ('html' == $arResult['PREVIEW_TEXT_TYPE'] ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>');
?>
</div>
<?
	}
}
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) && !empty($arResult['OFFERS_PROP']))
{
	$arSkuProps = array();
?>
<div class="item_info_section" style="padding-right:150px;" id="<? echo $arItemIDs['PROP_DIV']; ?>">
<?
	foreach ($arResult['SKU_PROPS'] as &$arProp)
	{
		if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))
			continue;
		$arSkuProps[] = array(
			'ID' => $arProp['ID'],
			'SHOW_MODE' => $arProp['SHOW_MODE'],
			'VALUES_COUNT' => $arProp['VALUES_COUNT']
		);
		if ('TEXT' == $arProp['SHOW_MODE'])
		{
			if (5 < $arProp['VALUES_COUNT'])
			{
				$strClass = 'bx_item_detail_size full';
				$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
				$strWidth = (20*$arProp['VALUES_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_item_detail_size';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
		<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
		<div class="bx_size_scroller_container"><div class="bx_size">
			<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
<?
			foreach ($arProp['VALUES'] as $arOneValue)
			{
				$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
?>
<li data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>" data-onevalue="<? echo $arOneValue['ID']; ?>" style="width: <? echo $strOneWidth; ?>; display: none;">
<i title="<? echo $arOneValue['NAME']; ?>"></i><span class="cnt" title="<? echo $arOneValue['NAME']; ?>"><? echo $arOneValue['NAME']; ?></span></li>
<?
			}
?>
			</ul>
			</div>
			<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
			<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
		</div>
	</div>
<?
		}
		elseif ('PICT' == $arProp['SHOW_MODE'])
		{
			if (5 < $arProp['VALUES_COUNT'])
			{
				$strClass = 'bx_item_detail_scu full';
				$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
				$strWidth = (20*$arProp['VALUES_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_item_detail_scu';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
		<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
		<div class="bx_scu_scroller_container"><div class="bx_scu">
			<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
<?
			foreach ($arProp['VALUES'] as $arOneValue)
			{
				$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
?>
<li data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>" data-onevalue="<? echo $arOneValue['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>; display: none;" >
<i title="<? echo $arOneValue['NAME']; ?>"></i>
<span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');" title="<? echo $arOneValue['NAME']; ?>"></span></span></li>
<?
			}
?>
			</ul>
			</div>
			<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
			<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
		</div>
	</div>
<?
		}
	}
	unset($arProp);
?>
</div>
<?
}
?>
<div class="item_info_section">
<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	$canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
}
else
{
	$canBuy = $arResult['CAN_BUY'];
}
$buyBtnMessage = ($arParams['MESS_BTN_BUY'] != '' ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
$addToBasketBtnMessage = ($arParams['MESS_BTN_ADD_TO_BASKET'] != '' ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCE_CATALOG_ADD'));
$notAvailableMessage = ($arParams['MESS_NOT_AVAILABLE'] != '' ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);

$showSubscribeBtn = false;
$compareBtnMessage = ($arParams['MESS_BTN_COMPARE'] != '' ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCE_CATALOG_COMPARE'));

if ($arParams['USE_PRODUCT_QUANTITY'] == 'Y')
{
	if ($arParams['SHOW_BASIS_PRICE'] == 'Y')
	{
		$basisPriceInfo = array(
			'#PRICE#' => $arResult['MIN_BASIS_PRICE']['PRINT_DISCOUNT_VALUE'],
			'#MEASURE#' => (isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : '')
		);
?>
		<p id="<? echo $arItemIDs['BASIS_PRICE']; ?>" class="item_section_name_gray"><? echo GetMessage('CT_BCE_CATALOG_MESS_BASIS_PRICE', $basisPriceInfo); ?></p>
<?
	}
?>
	<span class="item_section_name_gray"><? echo GetMessage('CATALOG_QUANTITY'); ?></span>
	<div class="item_buttons vam">
		<span class="item_buttons_counter_block">
			<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>">-</a>
			<input id="<? echo $arItemIDs['QUANTITY']; ?>" type="text" class="tac transparent_input" value="<? echo (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])
					? 1
					: $arResult['CATALOG_MEASURE_RATIO']
				); ?>">
			<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_UP']; ?>">+</a>
			<span class="bx_cnt_desc" id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo (isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : ''); ?></span>
		</span>
		<span class="item_buttons_counter_block" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
<?
	if ($showBuyBtn)
	{
?>
			<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
<?
	}
	if ($showAddBtn)
	{
?>
			<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['ADD_BASKET_LINK']; ?>"><span></span><? echo $addToBasketBtnMessage; ?></a>
<?
	}
?>
		</span>
		<span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" style="display: <? echo (!$canBuy ? '' : 'none'); ?>;"><? echo $notAvailableMessage; ?></span>
<?
	if ($arParams['DISPLAY_COMPARE'] || $showSubscribeBtn)
	{
?>
		<span class="item_buttons_counter_block">
<?
		if ($arParams['DISPLAY_COMPARE'])
		{
?>
			<a href="javascript:void(0);" class="bx_big bx_bt_button_type_2 bx_cart" id="<? echo $arItemIDs['COMPARE_LINK']; ?>"><? echo $compareBtnMessage; ?></a>
<?
		}
		if ($showSubscribeBtn)
		{

		}
?>
		</span>
<?
	}
?>
	</div>
<?
	if ('Y' == $arParams['SHOW_MAX_QUANTITY'])
	{
		if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
		{
?>
	<p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>" style="display: none;"><? echo GetMessage('OSTATOK'); ?>: <span></span></p>
<?
		}
		else
		{
			if ('Y' == $arResult['CATALOG_QUANTITY_TRACE'] && 'N' == $arResult['CATALOG_CAN_BUY_ZERO'])
			{
?>
	<p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>"><? echo GetMessage('OSTATOK'); ?>: <span><? echo $arResult['CATALOG_QUANTITY']; ?></span></p>
<?
			}
		}
	}
}
else
{
?>
	<div class="item_buttons vam">
		<span class="item_buttons_counter_block" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
<?
	if ($showBuyBtn)
	{
?>
			<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
<?
	}
	if ($showAddBtn)
	{
?>
		<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['ADD_BASKET_LINK']; ?>"><span></span><? echo $addToBasketBtnMessage; ?></a>
<?
	}
?>
		</span>
		<span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" style="display: <? echo (!$canBuy ? '' : 'none'); ?>;"><? echo $notAvailableMessage; ?></span>
<?
	if ($arParams['DISPLAY_COMPARE'] || $showSubscribeBtn)
	{
		?>
		<span class="item_buttons_counter_block">
	<?
	if ($arParams['DISPLAY_COMPARE'])
	{
		?>
		<a href="javascript:void(0);" class="bx_big bx_bt_button_type_2 bx_cart" id="<? echo $arItemIDs['COMPARE_LINK']; ?>"><? echo $compareBtnMessage; ?></a>
	<?
	}
	if ($showSubscribeBtn)
	{

	}
?>
		</span>
<?
	}
?>
	</div>
<?
}
unset($showAddBtn, $showBuyBtn);
?>
</div>
			<div class="clb"></div>
		</div>

		<div class="bx_md">
<div class="item_info_section">
<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	if ($arResult['OFFER_GROUP'])
	{
		foreach ($arResult['OFFER_GROUP_VALUES'] as $offerID)
		{
?>
	<span id="<? echo $arItemIDs['OFFER_GROUP'].$offerID; ?>" style="display: none;">
<?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
	".default",
	array(
		"IBLOCK_ID" => $arResult["OFFERS_IBLOCK"],
		"ELEMENT_ID" => $offerID,
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME'],
		"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
		"CURRENCY_ID" => $arParams["CURRENCY_ID"]
	),
	$component,
	array("HIDE_ICONS" => "Y")
);?><?
?>
	</span>
<?
		}
	}
}
else
{
	if ($arResult['MODULES']['catalog'] && $arResult['OFFER_GROUP'])
	{
?><?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
	".default",
	array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ELEMENT_ID" => $arResult["ID"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME'],
		"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
		"CURRENCY_ID" => $arParams["CURRENCY_ID"]
	),
	$component,
	array("HIDE_ICONS" => "Y")
);?><?
	}
}
?>
</div>
		</div>
		<div class="bx_rb">
<div class="item_info_section">
<?
if ('' != $arResult['DETAIL_TEXT'])
{
?>
	<div class="bx_item_description">
		<div class="bx_item_section_name_gray" style="border-bottom: 1px solid #f2f2f2;"><? echo GetMessage('FULL_DESCRIPTION'); ?></div>
<?
	if ('html' == $arResult['DETAIL_TEXT_TYPE'])
	{
		echo $arResult['DETAIL_TEXT'];
	}
	else
	{
		?><p><? echo $arResult['DETAIL_TEXT']; ?></p><?
	}
?>
	</div>
<?
}
?>
</div>
		</div>
		<div class="bx_lb">
<div class="tac ovh">
</div>
<div class="tab-section-container">
<?
if ('Y' == $arParams['USE_COMMENTS'])
{
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.comments",
	"",
	array(
		"ELEMENT_ID" => $arResult['ID'],
		"ELEMENT_CODE" => "",
		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
		"SHOW_DEACTIVATED" => $arParams['SHOW_DEACTIVATED'],
		"URL_TO_COMMENT" => "",
		"WIDTH" => "",
		"COMMENTS_COUNT" => "5",
		"BLOG_USE" => $arParams['BLOG_USE'],
		"FB_USE" => $arParams['FB_USE'],
		"FB_APP_ID" => $arParams['FB_APP_ID'],
		"VK_USE" => $arParams['VK_USE'],
		"VK_API_ID" => $arParams['VK_API_ID'],
		"CACHE_TYPE" => $arParams['CACHE_TYPE'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
		'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
		"BLOG_TITLE" => "",
		"BLOG_URL" => $arParams['BLOG_URL'],
		"PATH_TO_SMILE" => "",
		"EMAIL_NOTIFY" => $arParams['BLOG_EMAIL_NOTIFY'],
		"AJAX_POST" => "Y",
		"SHOW_SPAM" => "Y",
		"SHOW_RATING" => "N",
		"FB_TITLE" => "",
		"FB_USER_ADMIN_ID" => "",
		"FB_COLORSCHEME" => "light",
		"FB_ORDER_BY" => "reverse_time",
		"VK_TITLE" => "",
		"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME']
	),
	$component,
	array("HIDE_ICONS" => "Y")
);?>
<?
}
?>
</div>
		</div>
			<div style="clear: both;"></div>
	</div>
	<div class="clb"></div>
</div><?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	foreach ($arResult['JS_OFFERS'] as &$arOneJS)
	{
		if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
		{
			$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
			$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
		}
		$strProps = '';
		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($arOneJS['DISPLAY_PROPERTIES']))
			{
				foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
				{
					$strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
						is_array($arOneProp['VALUE'])
						? implode(' / ', $arOneProp['VALUE'])
						: $arOneProp['VALUE']
					).'</dd>';
				}
			}
		}
		$arOneJS['DISPLAY_PROPERTIES'] = $strProps;
	}
	if (isset($arOneJS))
		unset($arOneJS);
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'NAME' => $arResult['~NAME']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $arSkuProps
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
	{
?>
<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
<?
		if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
		{
			foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
			{
?>
	<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
<?
				if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
					unset($arResult['PRODUCT_PROPERTIES'][$propID]);
			}
		}
		$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
		if (!$emptyProductProperties)
		{
?>
	<table>
<?
			foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
			{
?>
	<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
	<td>
<?
				if(
					'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
					&& 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
				)
				{
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
					}
				}
				else
				{
					?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option><?
					}
					?></select><?
				}
?>
	</td></tr>
<?
			}
?>
	</table>
<?
		}
?>
</div>
<?
	}
	if ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] != $arResult['MIN_PRICE']['VALUE'])
	{
		$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
		$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
	}
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'BASIS_PRICE' => $arResult['MIN_BASIS_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ($arParams['ADD_PROPERTIES_TO_BASKET'] == 'Y'),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
	unset($emptyProductProperties);
}
?>
<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
BX.message({
	ECONOMY_INFO_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO'); ?>',
	BASIS_PRICE_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_BASIS_PRICE') ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE'); ?>',
	BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK'); ?>',
	COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK') ?>',
	COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
	COMPARE_TITLE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE') ?>',
	BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
</script>