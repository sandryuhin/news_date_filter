<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arCurrentValues
 */

if (!CModule::IncludeModule('iblock')) {
    return;
}

$arTypesEx = CIBlockParameters::GetIBlockTypes(['-' => ' ']);

$arIBlocks = [];
$db_iblock = CIBlock::GetList(
    ['SORT' => 'ASC'],
    [
        'SITE_ID' => $_REQUEST['site'],
        'TYPE' => ($arCurrentValues['IBLOCK_TYPE'] != '-' ? $arCurrentValues['IBLOCK_TYPE'] : '')
    ]
);

while ($arRes = $db_iblock->Fetch()) {
    $arIBlocks[$arRes['ID']] = '[' . $arRes['ID'] . '] ' . $arRes['NAME'];
}

$arComponentParameters = array(
    'GROUPS' => array(),
    'PARAMETERS' => array(
        'AJAX_MODE' => array(),
        'IBLOCK_TYPE' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('T_IBLOCK_DESC_LIST_TYPE'),
            'TYPE' => 'LIST',
            'VALUES' => $arTypesEx,
            'DEFAULT' => 'news',
            'REFRESH' => 'Y',
        ),
        'IBLOCK_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('T_IBLOCK_DESC_LIST_ID'),
            'TYPE' => 'LIST',
            'VALUES' => $arIBlocks,
            'DEFAULT' => "={$_REQUEST['ID']}",
            'ADDITIONAL_VALUES' => 'Y',
            'REFRESH' => 'Y',
        ),
        "CHECK_DATES" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_IBLOCK_DESC_CHECK_DATES"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
        'FILTER_NAME' => array(
            'PARENT' => 'DATA_SOURCE',
            'NAME' => GetMessage('T_IBLOCK_FILTER'),
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ),
        'CACHE_TIME' => array('DEFAULT' => 36000000),
        'CACHE_FILTER' => array(
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => GetMessage('IBLOCK_CACHE_FILTER'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N',
        ),
        'CACHE_GROUPS' => array(
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => GetMessage('CP_BNL_CACHE_GROUPS'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ),
    ),
);
