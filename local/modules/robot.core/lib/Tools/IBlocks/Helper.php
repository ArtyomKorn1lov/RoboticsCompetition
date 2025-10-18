<?php

namespace Robot\Core\Tools\IBlocks;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\LoaderException;
use Robot\Core\Exceptions\RobotException;
use Robot\Core\Logger\LoggerFactory;
use Robot\Core\Tools\Modules\Manager;
use Robot\Core\Constants;

Loc::loadMessages(__FILE__);

/**
 * Вспомогательный класс для взаимодействия с ИБ
 */
class Helper
{
    /** @var string[] Модули участвующие в работе класса */
    protected const MODULES_CODES = [
        "iblock"
    ];
    protected const CacheTypeRequest = [
        'ttl' => 3600,
        'cache_joins' => true
    ];

    /**
     * @param string $code
     * @return int|bool
     */
    public static function getIBlock(string $code): int|bool
    {
        try {
            Manager::requireModules(static::MODULES_CODES);
            if (empty($code)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_EMPTY_CODE"));
            }
            $result = IblockTable::getRow(static::prepareRequestParams($code));
            if (empty($result)) {
                return false;
            }
            return $result["ID"];
        } catch (RobotException $exception) {
            return false;
        } catch (SystemException|LoaderException $exception) {
            LoggerFactory::build()->error($exception);
            return false;
        }
    }

    /**
     * @param string $code
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    protected static function prepareRequestParams(string $code): array
    {
        return [
            "select" => ["ID"],
            "filter" => ["CODE" => static::getLangSiteCode($code)],
            "cache" => static::CacheTypeRequest
        ];
    }

    /**
     * @param string $code
     * @return string
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    protected static function getLangSiteCode(string $code): string
    {
        if (Loc::getCurrentLang() === Constants::LANG_ENGLISH_CODE) {
            $newCode = $code . "_" . Constants::LANG_ENGLISH_CODE;
            return self::checkIsExistIBlock($newCode) ? $newCode : $code;
        }
        return $code;
    }

    /**
     * @param $code
     * @return bool
     * @throws SystemException
     * @throws ArgumentException
     * @throws ObjectPropertyException
     */
    protected static function checkIsExistIBlock($code): bool
    {
        $result = IblockTable::getRow([
            "select" => ["ID"],
            "filter" => ["CODE" => $code],
            "cache" => static::CacheTypeRequest
        ]);
        return !empty($result);
    }
}