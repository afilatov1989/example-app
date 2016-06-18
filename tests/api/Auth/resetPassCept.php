<?php
$I = new ApiTester($scenario);
$I->wantTo('check user login via /api/v1/signin');
$user1 = $I->getUserByEmail('user1@test.com');

/**
 * Correct email. Should return OK
 */
$I->sendPUT('/password_reset', [
    'email' => 'user1@test.com',
]);
//$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'data' => [
        'message' => 'New credentials were sent to your email',
    ]
]);

/**
 * No email. Should be bad request (400)
 */
$I->sendPUT('/password_reset', [
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->seeResponseContains('Email is not provided');

/**
 * Not existing email. Should be not found (404)
 */
$I->sendPUT('/password_reset', [
    'email' => 'dqwedwcqwedqwedaaa@test.com',
]);
$I->seeResponseCodeIs(404);
$I->seeResponseIsJson();
$I->seeResponseContains('User with this email is not found');
