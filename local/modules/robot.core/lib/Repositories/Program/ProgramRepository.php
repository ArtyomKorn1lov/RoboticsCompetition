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

class ProgramRepository implements IProgramRepository
{

    /**
     * @param ProgramSectionsReqParams $entity
     * @return array
     */
    public function getActiveSectionIds(ProgramSectionsReqParams $entity): array
    {
        $rsObject = CIBlockSection::GetList(
            $entity->getSortValues(),
            $entity->getFilterValues(),
            false,
            $entity->getSelectedFields()
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
            $entity->getSortValues(),
            $entity->getFilterValues(),
            false,
            false,
            $entity->getSelectedFields()
        );

        $result = [];
        $demo = [];
        while ($arItem = $rsObject->fetch()) {
            $result[] = $arItem[$entity->getSamplePropCode()];
        }

        return new DateCollection($result);
    }

    /**
     * @param ProgramListReqParam $entity
     * @return ProgramCollection
     * @throws ArgumentException
     */
    public function getProgram(ProgramListReqParam $entity): ProgramCollection
    {
        $rsObject = CIBlockElement::GetList(
            $entity->getSortValues(),
            $entity->getFilterValues(),
            false,
            false,
            $entity->getSelectedFields()
        );

        $result = [];
        while ($arItem = $rsObject->fetch()) {
            $result[] = $arItem;
        }
        
        return new ProgramCollection($result);
    }
}