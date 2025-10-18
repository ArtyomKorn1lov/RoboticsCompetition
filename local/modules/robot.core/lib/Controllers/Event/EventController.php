<?php

namespace Robot\Core\Controllers\Event;

use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Request;
use Bitrix\Main\SystemException;
use Bitrix\Main\DI\ServiceLocator;

use Psr\Container\NotFoundExceptionInterface;

use Robot\Core\DTO\Event\AutocompleteSearch;
use Robot\Core\Exceptions\RobotException;
use Robot\Core\Logger\Logger;
use Robot\Core\Logger\LoggerFactory;
use Robot\Core\Services\Event\IEventManager;
use Robot\Core\Tools\Mappers\Event;
use Robot\Core\Views\Events\EventsView;
use Robot\Core\Middleware\Language;
use Robot\Core\Base\Controller;

Loc::loadMessages(__FILE__);

class EventController extends Controller
{
    /** @var Logger объект логирования */
    private Logger $logger;


    /**
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->logger = LoggerFactory::build();
    }

    /**
     * @return array[]
     */
    public function configureActions(): array
    {
        return [
            "register" => [
                "prefilters" => [
                    new Language()
                ]
            ],
            "countries" => [
                "prefilters" => [
                    new Language()
                ]
            ]
        ];
    }

    /**
     * @param array $formData
     * @return AjaxJson
     */
    public function registerAction(array $formData): AjaxJson
    {
        try {
            if (empty($formData)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_REGISTER_DATA_EMPTY"));
            }

            $eventId = EventsView::getActiveEventId();
            if (!$eventId) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_PROGRAM_INVALID_EVENT_ID"));
            }

            /** @var IEventManager $eventManager */
            $eventManager = ServiceLocator::getInstance()->get(IEventManager::class);
            $eventManager->saveRegisterForm(Event::mapRegisterFormArrayToModel($formData), $eventId);

            return AjaxJson::createSuccess(Loc::getMessage("ROBOT_CORE_REGISTER_SUCCESS_MESSAGE"));
        } catch (RobotException $exception) {
            return $this->onError($exception->getMessage());
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            $this->logger->error($exception);
            return $this->onError(Loc::getMessage("ROBOT_CORE_EVENT_ERROR"));
        }
    }

    /**
     * @param int $id
     * @param string $value
     * @return AjaxJson
     */
    public function countriesAction(int $id, string $value = ""): AjaxJson
    {
        try {
            if (empty($id)) {
                throw new RobotException(Loc::getMessage("ROBOT_CORE_SEARCH_INVALID_ID"));
            }

            $autocompleteSearch = new AutocompleteSearch(
                id: $id,
                value: $value
            );

            /** @var IEventManager $eventManager */
            $eventManager = ServiceLocator::getInstance()->get(IEventManager::class);
            $result = $eventManager->searchAutocompleteValues($autocompleteSearch)->mapToArray(fn($item) => $item);

            return AjaxJson::createSuccess($result);
        } catch (RobotException $exception) {
            return $this->onError($exception->getMessage());
        } catch (SystemException|NotFoundExceptionInterface $exception) {
            $this->logger->error($exception);
            return $this->onError(Loc::getMessage("ROBOT_CORE_EVENT_ERROR"));
        }
    }
}