<?php
$I = new ApiTester($scenario);
$I->wantTo('Meal crud create: test fields combinations');

// create common user
$user = $I->getUserByEmail('user1@test.com');

/**
 * Create meal with correct data and token
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST("/user_meals/{$user->id}/?token={$user->token}", [
    'date'     => '2016-04-06',
    'time'     => '13:30',
    'text'     => 'Some random text... ',
    'calories' => 670,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('"date": "2016-04-06"');
$I->seeResponseContains('"time": "13:30"');
$I->seeResponseContains('"text": "Some random text... "');
$I->seeResponseContains('"calories": 670');

/**
 * Retrieving created meal
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendGET("/user_meals/{$user->id}/", [
    'token'     => $user->token,
    'date-from' => '2016-04-06',
    'date-to'   => '2016-04-06',
    'time-from' => '11:30',
    'time-to'   => '15:30',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('"date": "2016-04-06"');
$I->seeResponseContains('"time": "13:30"');
$I->seeResponseContains('"text": "Some random text... "');
$I->seeResponseContains('"calories": 670');

/**
 * Try to create meal with incorrect date
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST("/user_meals/{$user->id}/?token={$user->token}", [
    'date'     => '2016-4-6',
    'time'     => '13:30',
    'text'     => 'Some random text...',
    'calories' => 670,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('date format is invalid');

/**
 * Try to create meal with incorrect time
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST("/user_meals/{$user->id}/?token={$user->token}", [
    'date'     => '2016-04-06',
    'time'     => '9:30',
    'text'     => 'Some random text...',
    'calories' => 670,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('time format is invalid');

/**
 * Try to create meal without any text
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST("/user_meals/{$user->id}/?token={$user->token}", [
    'date'     => '2016-04-06',
    'time'     => '09:30',
    'text'     => '',
    'calories' => 670,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('text field is required');
