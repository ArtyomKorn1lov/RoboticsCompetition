<?php

namespace Robot\Core\Repositories\Program;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectException;
use CIBlockSection;
use CIBlockElement;

use Robot\Core\Entity\Program\ProgramCollection;
use Robot\Core\Entity\Program\ProgramListReqParam;
use Robot\Core\Entity\Program\ProgramSectionsReqParams;
use Robot\Core\Entity\Program\TimeLineReqParams;
use Robot\Core\Entity\Program\DateCollection;
use Robot\Core\Tools\Mappers\Program;

class ProgramRepository implements IProgramRepository
{

    /**
     * @param ProgramSectionsReqParams $entity
     * @return array
     */
    public function getActiveSectionIds(ProgramSectionsReqParams $entity): array
    {
        $rsObject = CIBlockSection::GetList(
            arOrder: $entity->getSortValues(),
            arFilter: $entity->getFilterValues(),
            arSelect: $entity->getSelectedFields()
        );

        $ids = [];
        $name = "";
        $count = 0;
        while ($arSection = $rsObject->fetch()) {
            $ids[] = (int)$arSection["ID"];
            $count === 0 && $name = $arSection["NAME"];
            $count++;
        }

        return [$ids, $name];
    }

    /**
     * @param TimeLineReqParams $entity
     * @return DateCollection
     * @throws ArgumentException
     * @throws ObjectException
     */
    public function getTimeLine(TimeLineReqParams $entity): DateCollection
    {
        $rsObject = CIBlockElement::GetList(
            arOrder: $entity->getSortValues(),
            arFilter: $entity->getFilterValues(),
            arSelectFields: $entity->getSelectedFields()
        );

        $result = [];
        while ($arItem = $rsObject->fetch()) {
            $result[] = $arItem[$entity->getSamplePropCode()];
        }

        return Program::mapDateArrayToEntityList($result);
    }

    /**
     * @param ProgramListReqParam $entity
     * @return ProgramCollection
     * @throws ArgumentException
     */
    public function getProgram(ProgramListReqParam $entity): ProgramCollection
    {
        $rsObject = CIBlockElement::GetList(
            arOrder: $entity->getSortValues(),
            arFilter: $entity->getFilterValues(),
            arSelectFields: $entity->getSelectedFields()
        );

        $result = [];
        while ($arItem = $rsObject->fetch()) {
            $result[] = $arItem;
        }
        
        return Program::mapProgramArrayToEntityList($result);
    }
}