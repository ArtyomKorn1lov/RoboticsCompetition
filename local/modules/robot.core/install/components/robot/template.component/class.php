<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class TemplateComponent extends CBitrixComponent
{
    /** @var string Код свойства с подключаемыми модулями */
    public const MODULE_NAMES_PROP_CODE = "MODULES_CODES";

    /**
     * @param $arParams
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        $arParams = parent::onPrepareComponentParams($arParams);
        if (empty($arParams[self::MODULE_NAMES_PROP_CODE])) {
            $arParams[self::MODULE_NAMES_PROP_CODE] = [];
        }
        return $arParams;
    }

    /**
     * @return void
     */
    public function executeComponent(): void
    {
        try {
            if (!$this->includeModules()) {
                throw new LoaderException(Loc::getMessage("COMPONENT_MODULE_ERROR"));
            }
            if ($this->startResultCache()) {
                $this->includeComponentTemplate();
            }
        } catch (LoaderException $exception) {
            AddMessage2Log($exception->getMessage(), "main");
            ShowError($exception->getMessage());
        }
    }

    /**
     * @return bool
     * @throws LoaderException
     */
    protected function includeModules(): bool
    {
        $flag = true;
        foreach ($this->arParams[self::MODULE_NAMES_PROP_CODE] as $moduleCode) {
            if (!empty($moduleCode)) {
                $flag = Bitrix\Main\Loader::includeModule($moduleCode);
            }
            if (!$flag) {
                break;
            }
        }
        return $flag;
    }
}