<?php
$I = new ApiTester($scenario);
$I->wantTo('check user login via /api/v1/signin');

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
