<?php
$I = new ApiTester($scenario);
$I->wantTo('Meal crud update: test fields combinations');

// create common user
$user = $I->getUserByEmail('user1@test.com');
$meal = $I->createNewMealByUser($user);


/**
 * Update a meal. Should be successful
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT("/user_meals/{$user->id}/{$meal->id}/?token={$user->token}", [
    'date'     => '2016-05-06',
    'time'     => '15:50',
    'text'     => 'New text of meal. Check it by this phrase.',
    'calories' => 890,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('"date": "2016-05-06"');
$I->seeResponseContains('"time": "15:50"');
$I->seeResponseContains('"text": "New text of meal. Check it by this phrase."');
$I->seeResponseContains('"calories": 890');
$I->seeResponseContains('"id": ' . $meal->id . '');


/**
 * Try to update a meal which does not exist. Should be 404
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT("/user_meals/{$user->id}/555/?token={$user->token}", [
    'date'     => '2016-05-06',
    'time'     => '15:50',
    'text'     => 'New text of meal. Check it by this phrase.',
    'calories' => 890,
]);
$I->seeResponseCodeIs(404);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('Meal not found');

/**
 * Try to update a meal with incorrect date. Should be 400
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT("/user_meals/{$user->id}/{$meal->id}/?token={$user->token}", [
    'date'     => '2016-05-6',
    'time'     => '15:50',
    'text'     => 'New text of meal. Check it by this phrase.',
    'calories' => 890,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('The date format is invalid');


/**
 * Try to update a meal with incorrect time. Should be 400
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT("/user_meals/{$user->id}/{$meal->id}/?token={$user->token}", [
    'date'     => '2016-05-60',
    'time'     => '5:50',
    'text'     => 'New text of meal. Check it by this phrase.',
    'calories' => 890,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('The time format is invalid');

/**
 * Try to update a meal with not integer calories. Should be 400
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT("/user_meals/{$user->id}/{$meal->id}/?token={$user->token}", [
    'date'     => '2016-05-06',
    'time'     => '15:50',
    'text'     => 'New text of meal. Check it by this phrase.',
    'calories' => 'asdasdasd',
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('The calories must be an integer.');

