<?php

namespace Robot\Core\Tools\IBlocks;

use Bitrix\Main\ObjectException;
use Bitrix\Iblock\PropertyTable;
use stdClass;

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
            'DESCRIPTION' => 'Временной диапазон',
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
            $value['VALUE'] = '';
            return $value;
        }

        if ($value['VALUE']['TIME_FROM'] !== '' && $value['VALUE']['TIME_TO'] !== '') {
            try {
                if (static::createTimeStamp($value['VALUE']['TIME_FROM']) > static::createTimeStamp($value['VALUE']['TIME_TO'])) {
                    throw new ObjectException('Стартовая дата не может быть больше конечной');
                }

                $value['VALUE'] = base64_encode(serialize($value['VALUE']));
            } catch (ObjectException $exception) {
                AddMessage2Log($exception->getMessage(), 'main');
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
            } catch (ObjectException $exception) {
                AddMessage2Log($exception->getMessage(), 'robot.core');
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
            $html .= '&nbsp;&nbsp;<input type="button" style="height: auto;" value="x" title="Удалить" onclick="document.getElementById(\'' . $itemId . '\').parentNode.parentNode.remove()" />';
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