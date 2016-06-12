<?php
$I = new ApiTester($scenario);
$I->wantTo('check user login via /api/v1/signin');
$user1 = $I->getUserByEmail('user1@test.com');

/**
 * Correct email. Should return OK
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT('/password_reset', [
    'email' => 'user1@test.com',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsJson([
    'data' => [
        'message' => 'New credentials were sent to your email',
    ]
]);

/**
 * No email. Should be bad request (400)
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT('/password_reset', [
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('Email is not provided');

/**
 * Not existing email. Should be not found (404)
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT('/password_reset', [
    'email' => 'dqwedwcqwedqwedaaa@test.com',
]);
$I->seeResponseCodeIs(404);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('User with this email is not found');

