<?php

namespace Robot\Core\Repositories\Event;

use Bitrix\Main\ObjectException;
use CIBlockElement;

use Robot\Core\Constants;
use Robot\Core\Entity\Event\RegisterForm;
use Robot\Core\Tools\IBlocks\Helper;

class EventRepository implements IEventRepository
{
    /**
     * @param RegisterForm $registerFormEntity
     * @return void
     * @throws ObjectException
     */
    public function saveForm(RegisterForm $registerFormEntity): void
    {
        $entity = new CIBlockElement();
        if (!$entity->Add($registerFormEntity->getFormData())) {
            throw new ObjectException($entity->LAST_ERROR);
        }
    }

    /**
     * @return int
     */
    public function getLastElementId(): int
    {
        $rsObject = CIBlockElement::GetList(["ID" => "DESC"], [
            "IBLOCK_ID" => Helper::getIblock(Constants::REGISTRATION_REQUEST_IBLOCK_CODE),
            "IBLOCK_TYPE" => Constants::FEEDBACK_IBLOCK_TYPE,
        ], false, ["nTopCount" => 1], ["ID"]);

        $result = $rsObject->fetch();
        if (empty($result)) {
            return 1;
        }

        return $result["ID"];
    }
}