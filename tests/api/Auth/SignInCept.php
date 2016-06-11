<?php
$I = new ApiTester($scenario);
$I->wantTo('check user login via /api/v1/signin');
$user1 = $I->getUserByEmail('user1@test.com');

/**
 * Correct authentication
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('/signin', [
    'email'    => 'user1@test.com',
    'password' => 'qwerty123',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsToken();
$I->seeResponseContainsJson([
    'data' => [
        'id'               => $user1->id,
        'name'             => $user1->name,
        'calories_per_day' => $user1->calories_per_day,
        'email'            => $user1->email,

    ]
]);

/**
 * Try to sign in with incorrect credentials
 */

$I->sendPOST('/signin', [
    'email'    => 'random@codeception.com',
    'password' => 'qwerty',
]);
$I->seeResponseCodeIs(401);
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseIsJson();
$I->seeResponseContains('Invalid credentials');
