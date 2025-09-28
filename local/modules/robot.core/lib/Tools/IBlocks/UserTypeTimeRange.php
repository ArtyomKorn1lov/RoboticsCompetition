<?php

namespace Robot\Core\Tools\IBlocks;

use Bitrix\Main\ObjectException;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Localization\Loc;
use Robot\Core\Logger\LoggerFactory;
use stdClass;

Loc::loadMessages(__FILE__);

/**
 * Пользовательское свойство для ИБ "Временной диапазон"
 */
class UserTypeTimeRange
{
    /**
     * @return array
     */
    public static function getUserTypeDescription(): array
    {
        return [
            'USER_TYPE_ID' => 'user_time_range',
            'USER_TYPE' => 'TIME_RANGE',
            'CLASS_NAME' => __CLASS__,
            'DESCRIPTION' => Loc::getMessage('ROBOT_TIME_RANGE_DESC'),
            'PROPERTY_TYPE' => PropertyTable::TYPE_STRING,
            'ConvertToDB' => [__CLASS__, 'convertToDB'],
            'ConvertFromDB' => [__CLASS__, 'convertFromDB'],
            'GetPropertyFieldHtml' => [__CLASS__, 'getPropertyFieldHtml'],
        ];
    }

    /**
     * @param array $arProperty
     * @param array $value
     * @return array
     */
    public static function convertToDB(array $arProperty, array $value): array
    {
        if (empty($value['VALUE']['TIME_FROM']) || empty($value['VALUE']['TIME_TO'])) {
            $decoded = unserialize(htmlspecialcharsback($value['VALUE']), [stdClass::class]);

            if (empty($decoded['TIME_FROM']) || empty($decoded['TIME_TO'])) {
                $value['VALUE'] = '';
                return $value;
            }
            
            $value['VALUE'] = $decoded;
        }

        if ($value['VALUE']['TIME_FROM'] !== '' && $value['VALUE']['TIME_TO'] !== '') {
            try {
                if (static::createTimeStamp($value['VALUE']['TIME_FROM']) > static::createTimeStamp($value['VALUE']['TIME_TO'])) {
                    throw new ObjectException(Loc::getMessage('ROBOT_TIME_RANGE_TIME_ERROR'));
                }

                $value['VALUE'] = base64_encode(serialize($value['VALUE']));
            } catch (ObjectException $exception) {
                LoggerFactory::build()->error($exception);
                $value['VALUE'] = '';
            }
        } else {
            $value['VALUE'] = '';
        }

        return $value;
    }

    /**
     * @param array $arProperty
     * @param array $value
     * @param string $format
     * @return array
     */
    public static function convertFromDB(array $arProperty, array $value, string $format = ''): array
    {
        if ($value['VALUE'] !== '') {
            try {
                $value['VALUE'] = base64_decode($value['VALUE']);
            } catch (\Exception $exception) {
                LoggerFactory::build()->error($exception);
            }
        }

        return $value;
    }

    /**
     * @param $arProperty
     * @param $value
     * @param $arHtmlControl
     * @return string
     */
    public static function getPropertyFieldHtml($arProperty, $value, $arHtmlControl): string
    {
        $itemId = 'row_' . substr(md5($arHtmlControl['VALUE']), 0, 10);
        $fieldName = htmlspecialcharsbx($arHtmlControl['VALUE']);
        $arValue = unserialize(htmlspecialcharsback($value['VALUE']), [stdClass::class]);

        $html = '<div class="property_row" id="' . $itemId . '">';

        $html .= '<div class="reception_time">';
        $timeFrom = $arValue['TIME_FROM'] ?? '';
        $timeTo = $arValue['TIME_TO'] ?? '';

        $html .= '&nbsp;&nbsp;с&nbsp;&nbsp;<input type="time" name="' . $fieldName . '[TIME_FROM]" value="' . $timeFrom . '">';
        $html .= '&nbsp;&nbsp;по&nbsp;&nbsp;<input type="time" name="' . $fieldName . '[TIME_TO]" value="' . $timeTo . '">';
        if ($timeFrom != '' && $timeTo != '' && $arProperty["MULTIPLE"] === "Y") {
            $html .= '&nbsp;&nbsp;<input type="button" style="height: auto;" value="x" title="' . Loc::getMessage('ROBOT_TIME_RANGE_REMOVE') . '" onclick="document.getElementById(\'' . $itemId . '\').parentNode.parentNode.remove()" />';
        }
        $html .= '</div>';

        $html .= '</div><br/>';

        return $html;
    }

    /**
     * @param string $time
     * @return int
     */
    protected static function createTimeStamp(string $time): int
    {
        if (empty($time)) {
            return 0;
        }

        $arTime = array_map('intval', explode(':', $time));
        if (empty($arTime[0]) || empty($arTime[1])) {
            return 0;
        }

        return mktime($arTime[0], $arTime[1], 1, date('m'), date('d'), date('Y'));
    }
}