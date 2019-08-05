<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var CBitrixComponent $this
 * @var array $arParams
 * @var array $arResult
 * @var string $componentPath
 * @var string $componentName
 * @var string $componentTemplate
 * @global CDatabase $DB
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global CIntranetToolbar $INTRANET_TOOLBAR
 */

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\SystemException;
use Bitrix\Iblock\Component\Tools;


if ($this->startResultCache(false)) {

    try {

        try {
            Loader::includeModule('iblock');

            $elements = ElementTable::getList([
                'filter' => [
                    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                    'ACTIVE' => 'Y',
                ],
                'select' => ['ACTIVE_FROM'],
                'group' => ['ACTIVE_FROM']
            ]);

            $arResult = [];
            while ($element = $elements->fetch()) {
                $month = $element['ACTIVE_FROM']->format('m');
                $year = $element['ACTIVE_FROM']->format('Y');

                $arResult['DATE'][$year][$month] = $month;
            }

        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }

    } catch (LoaderException $e) {
        ShowError($e->getMessage());
    }

    $this->setResultCacheKeys(['DATE']);
    $this->includeComponentTemplate();
}

if ((int)$arParams['YEAR'] > 0) {

    if ((int)$arParams['MONTH'] > 0) {
        $date['from'] = '01.' . $arParams['MONTH'] . '.' . $arParams['YEAR'];
        $date['to'] = cal_days_in_month(CAL_GREGORIAN, (int)$arParams['MONTH'], $arParams['YEAR']) . '.' . $arParams['MONTH'] . '.' . $arParams['YEAR'];
    } else {
        $date['from'] = '01.01.' . $arParams['YEAR'];
        $date['to'] = '31.12.' . $arParams['YEAR'];
    }

    $dateFilter = [];
    if (strlen($date['from']) > 0 && strlen($date['to']) > 0) {
        $dateFilter = [
            'LOGIC' => 'AND',
            [
                '>=DATE_ACTIVE_FROM' => $date['from'],
                '<=DATE_ACTIVE_FROM' => $date['to']
            ]
        ];
    }

    return $dateFilter;

} else {
    Tools::process404('', $arParams['SET_STATUS_404'] === 'Y', $arParams['SET_STATUS_404'] === 'Y', $arParams['SHOW_404'] === 'Y', $arParams['FILE_404']);
}
