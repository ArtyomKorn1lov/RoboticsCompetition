<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

return [
    // Регистрация namespace контроллеров
    'controllers' => [
        'value' => [
            'defaultNamespace' => '\\Robot\\RestControllers',
            'restIntegration' => [
                'enabled' => true,
                'scopes' => [],
            ],
        ],
        'readonly' => true,
    ],
    // Регистрация классов для сервис-локатора
    'services' => [
        'value' => [
            // Репозитории
            Robot\Core\Repositories\Actions\IActionRepository::class => ['className' => Robot\Core\Repositories\Actions\ActionRepository::class],
            Robot\Core\Repositories\Event\IEventRepository::class => ['className' => Robot\Core\Repositories\Event\EventRepository::class],
            Robot\Core\Repositories\Program\IProgramRepository::class => ['className' => Robot\Core\Repositories\Program\ProgramRepository::class],
            Robot\Core\Repositories\SiteSettings\ISiteSettingsRepository::class => ['className' => Robot\Core\Repositories\SiteSettings\SiteSettingsRepository::class],

            // Хелперы
            Robot\Core\Tools\Files\IHelper::class => ['className' => Robot\Core\Tools\Files\Helper::class],

            // Сервисы
            Robot\Core\Services\Actions\IActionManager::class => ['className' => Robot\Core\Services\Actions\ActionManager::class],
            Robot\Core\Services\Event\IEventManager::class => ['className' => Robot\Core\Services\Event\EventManager::class],
            Robot\Core\Services\Program\IProgramManager::class => ['className' => Robot\Core\Services\Program\ProgramManager::class],
            Robot\Core\Services\SiteSettings\ISiteSettingsManager::class => ['className' => Robot\Core\Services\SiteSettings\SiteSettingsManager::class],
        ]
    ]
];