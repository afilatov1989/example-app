<?php
$I = new ApiTester($scenario);
$I->wantTo('Meal crud update: check token and role restrictions');

// create common users and admin for checking permissions
$user1 = $I->getUserByEmail('user1@test.com');
$user2 = $I->getUserByEmail('user2@test.com');
$admin = $I->getUserByEmail('admin@test.com');
$meal = $I->createNewMealByUser($user1);

/**
 * Try to update a meal with another user's token. Should be prohibited
 */
$I->sendPUT("/user_meals/{$user1->id}/{$meal->id}/?token={$user2->token}", [
    'date'     => '2016-05-06',
    'time'     => '15:50',
    'text'     => 'New text of meal. Check it by this phrase.',
    'calories' => 890,
]);
$I->seeResponseCodeIs(403);
$I->seeResponseIsJson();
$I->seeResponseContains('Access denied');

/**
 * Try to update a meal of 'user1' with admin's token. Should be OK
 */
$I->sendPUT("/user_meals/{$user1->id}/{$meal->id}/?token={$admin->token}", [
    'date'     => '2016-05-06',
    'time'     => '15:50',
    'text'     => 'New text of meal. Check it by this phrase.',
    'calories' => 890,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('"date": "2016-05-06"');
$I->seeResponseContains('"time": "15:50"');
$I->seeResponseContains('"text": "New text of meal. Check it by this phrase."');
$I->seeResponseContains('"calories": 890');
$I->seeResponseContains('"id": ' . $meal->id . '');


/**
 * Try to update a meal without a token (both put and patch methods)
 */
$I->sendPUT("/user_meals/{$user1->id}/{$meal->id}", [
    'date'     => '2016-04-06',
    'time'     => '13:30',
    'text'     => 'Some random text...',
    'calories' => 670,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->seeResponseContains('The token could not be parsed from the request');

$I->sendPATCH("/user_meals/{$user1->id}/{$meal->id}", [
    'date'     => '2016-04-06',
    'time'     => '13:30',
    'text'     => 'Some random text...',
    'calories' => 670,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->seeResponseContains('The token could not be parsed from the request');


/**
 * Try to update a meal with invalid token (both put and patch methods)
 */
$I->sendPUT("/user_meals/{$user1->id}/{$meal->id}/?token=123123123", [
    'date'     => '2016-04-06',
    'time'     => '13:30',
    'text'     => 'Some random text...',
    'calories' => 670,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->seeResponseContains('The token could not be parsed from the request');

$I->sendPATCH("/user_meals/{$user1->id}/{$meal->id}/?token=123123123555", [
    'date'     => '2016-04-06',
    'time'     => '13:{$user1->id}0',
    'text'     => 'Some random text...',
    'calories' => 670,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->seeResponseContains('The token could not be parsed from the request');
