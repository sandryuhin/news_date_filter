<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 */

$this->setFrameMode(true);
?>
<? if (count($arResult['DATE'])): ?>
    <div class="container">
        <ul class="date-navigation">
            <? foreach ($arResult['DATE'] as $year => $monthArray): ?>
                <? $yearLink = $arParams['SEF_FOLDER'] . $year . '/'; ?>
                <li>
                    <a href="<?= $yearLink ?>">
                        <?= $year ?>
                    </a>
                    <? if (count($monthArray) > 0): ?>
                        <ul class="date-navigation">
                            <? foreach ($monthArray as $month): ?>
                                <li>
                                    <a href="<?= $yearLink . $month . '/' ?>">
                                        <?= $month ?>
                                    </a>
                                </li>
                            <? endforeach; ?>
                        </ul>
                    <? endif; ?>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
<? endif; ?>

