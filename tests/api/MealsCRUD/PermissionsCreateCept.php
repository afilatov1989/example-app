<?php
$I = new ApiTester($scenario);
$I->wantTo('Meal crud create: check token and role restrictions');

// create common users and admin for checking permissions
$user1 = $I->getUserByEmail('user1@test.com');
$user2 = $I->getUserByEmail('user2@test.com');
$admin = $I->getUserByEmail('admin@test.com');

/**
 * Try to create a meal for another user without rights. Should be 403
 */
$I->sendPOST("/user_meals/{$user1->id}/?token={$user2->token}", [
    'date'     => '2016-04-06',
    'time'     => '13:30',
    'text'     => 'Some random text...',
    'calories' => 670,
]);
$I->seeResponseCodeIs(403);
$I->seeResponseIsJson();
$I->seeResponseContains('Access denied');

/**
 * Try to create a meal for another user with admin rights. Should be OK
 */
$I->sendPOST("/user_meals/{$user1->id}/?token={$admin->token}", [
    'date'     => '2016-04-06',
    'time'     => '13:30',
    'text'     => 'Some random text...',
    'calories' => 670,
]);

$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('"date": "2016-04-06"');
$I->seeResponseContains('"time": "13:30"');
$I->seeResponseContains('"text": "Some random text..."');
$I->seeResponseContains('"calories": 670');
$I->seeResponseContains('"user_id": ' . $user1->id);

/**
 * Try to create a meal without token
 */
$I->sendPOST('/user_meals/' . $user1->id, [
    'date'     => '2016-04-06',
    'time'     => '13:30',
    'text'     => 'Some random text...',
    'calories' => 670,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->seeResponseContains('The token could not be parsed from the request');

/**
 * Try to create a meal with invalid token
 */
$I->sendPOST('/user_meals/' . $user1->id . '/?token=123123123123123', [
    'date'     => '2016-04-06',
    'time'     => '13:30',
    'text'     => 'Some random text...',
    'calories' => 670,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->seeResponseContains('The token could not be parsed from the request');
