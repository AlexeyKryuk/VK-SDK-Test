<?php
header("Content-Type: application/json; encoding=utf-8");

$secret_key = 'NE2GDmfQFlSalnZtPX7w'; // Защищенный ключ приложения ВК

$input = $_POST;

// Проверка подписи
$sig = $input['sig'];
unset($input['sig']);
ksort($input);
$str = '';
foreach ($input as $k => $v){
	$str .= $k.'='.$v;
}

if ($sig != md5($str.$secret_key)){ // Если подпись НЕПРАВИЛЬНАЯ
	$response['error'] = array(
		'error_code' => 10,
		'error_msg' => 'Несовпадение вычисленной и переданной подписи запроса.',
		'critical' => true
	);
}

else { // Иначе, если подпись ПРАВИЛЬНАЯ

	switch ($input['notification_type']){
		
		// ТОВАРЫ
		
		case 'get_item':
			
			$item = $input['item']; // Получение информации о товаре
			
			if ($item == 'offAds') {	// наименование товара
				$response['response'] = array(
					'item_id' => 101,  // ID 1 товара
					'title' => 'Отключение рекламы', // Заголовок 1 товара
					'photo_url' => 'https://dharmagames.ru/games/arcade/mrnoob/base/offAds.png', // Ссылка на иконку 1 товара
					'price' => 15 // Цена 1 товара в голосах ВК
					);
				}
				
			elseif ($item == '200Diamonds') {
				$response['response'] = array(
					'item_id' => 201,  // ID 2 товара
					'title' => '200 алмазов', // Заголовок 2 товара
					'photo_url' => 'https://dharmagames.ru/games/arcade/mrnoob/base/200Diamonds.png', // Ссылка на иконку 2 товара
					'price' => 10 // Цена 2 товара в голосах ВК
					);		
				}
				
			elseif ($item == '500Diamonds') {
				$response['response'] = array(
					'item_id' => 301,  // ID 3 товара
					'title' => '500 алмазов', // Заголовок 3 товара
					'photo_url' => 'https://dharmagames.ru/games/arcade/mrnoob/base/500Diamonds.png', // Ссылка на иконку 3 товара
					'price' => 20 // Цена 3 товара в голосах ВК
					);
				}
				
			elseif ($item == '1500Diamonds') {
				$response['response'] = array(
					'item_id' => 401,  // ID 4 товара
					'title' => '1500 алмазов', // Заголовок 4 товара
					'photo_url' => 'https://dharmagames.ru/games/arcade/mrnoob/base/1500Diamonds.png', // Ссылка на иконку 4 товара
					'price' => 50 // Цена 4 товара в голосах ВК
					);
				}
			break;


		// ТЕСТОВЫЕ ТОВАРЫ

		case 'get_item_test':
			
			$item = $input['item']; // Получение информации о товаре (в тестовом режиме)
			
			if ($item == 'test_item_1') {
				$response['response'] = array(
					'item_id' => 102,  // ID 1 тестового товара
					'title' => 'Покупка предмета (тестовый режим)', // Заголовок 1 тестового товара
					'photo_url' => 'https://dharmagames.ru/games/arcade/mrnoob/base/offAds.png', // Ссылка на иконку 1 тестового товара
					'price' => 3 // Цена 1 тестового товара в голосах ВК
					);
				}
				
			elseif ($item == '200Diamonds') {
				$response['response'] = array(
					'item_id' => 202,  // ID 2 тестового товара
					'title' => '200 алмазов (тестовый режим)', // Заголовок 2 тестового товара
					'photo_url' => 'https://dharmagames.ru/games/arcade/mrnoob/base/200Diamonds.png', // Ссылка на иконку 2 тестового товара
					'price' => 10 // Цена 2 тестового товара в голосах ВК
					);
				}
				
			elseif ($item == '500Diamonds') {
				$response['response'] = array(
					'item_id' => 302,  // ID 3 тестового товара
					'title' => '500 алмазов (тестовый режим)', // Заголовок 3 тестового товара
					'photo_url' => 'https://dharmagames.ru/games/arcade/mrnoob/base/500Diamonds.png', // Ссылка на иконку 3 тестового товара
					'price' => 20 // Цена 3 тестового товара в голосах ВК
					);
				}
				
			elseif ($item == '1500Diamonds') {
				$response['response'] = array(
					'item_id' => 402,  // ID 4 тестового товара
					'title' => '1500 алмазов (тестовый режим)', // Заголовок 4 тестового товара
					'photo_url' => 'https://dharmagames.ru/games/arcade/mrnoob/base/1500Diamonds.png', // Ссылка на иконку 4 тестового товара
					'price' => 50 // Цена 4 тестового товара в голосах ВК
					);
				}
			break;


		// ПОДПИСКА

		case 'order_status_change':
			// Изменение статуса заказа
			if ($input['status'] == 'chargeable'){
				$order_id = intval($input['order_id']);

				// Код проверки товара, включая его стоимость
				$app_order_id = 1; // Получающийся у вас идентификатор заказа.

				$response['response'] = array(
					'order_id' => $order_id,
					'app_order_id' => $app_order_id,
					);
				}
			else {
				$response['error'] = array(
					'error_code' => 100,
					'error_msg' => 'Передано непонятно что вместо chargeable.',
					'critical' => true
					);
				}
			break;
			
		
		// ТЕСТОВАЯ ПОДПИСКА

		case 'order_status_change_test':
			// Изменение статуса заказа в тестовом режиме
			if ($input['status'] == 'chargeable'){
				$order_id = intval($input['order_id']);

				$app_order_id = 1; // Тут фактического заказа может не быть - тестовый режим.

				$response['response'] = array(
					'order_id' => $order_id,
					'app_order_id' => $app_order_id,
					);
				}
			else {
				$response['error'] = array(
					'error_code' => 100,
					'error_msg' => 'Передано непонятно что вместо chargeable.',
					'critical' => true
					);
				}
			break;
		}
	}

echo json_encode($response);
?>