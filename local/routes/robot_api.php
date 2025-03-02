<?php

use Bitrix\Main\Routing\RoutingConfigurator;

/**
 * Роутинг для контроллеров модуля robot.core
 */

return function (RoutingConfigurator $routes) {

	$routes->prefix('api')->group(function (RoutingConfigurator $routes) {
		$routes->post('program/get-items/', [Robot\Core\Controllers\Program\ProgramController::class, 'getItemsAction']);
	});
};
