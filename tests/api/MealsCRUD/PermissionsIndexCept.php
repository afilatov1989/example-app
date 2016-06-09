<?php
$I = new ApiTester($scenario);
$I->wantTo('Meal crud index: check token and role restrictions');

// create common users and admin for checking permissions
$user1 = $I->getUserByEmail('user1@test.com');
$user2 = $I->getUserByEmail('user2@test.com');
$admin = $I->getUserByEmail('admin@test.com');
$meal = $I->createNewMealByUser($user1);

/**
 * Try to retrieve meals with another user's token. Should be 403
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendGET("/user_meals/{$user1->id}/", [
    'token'     => $user2->token,
    'date-from' => '2016-04-06',
    'date-to'   => '2016-06-07',
    'time-from' => '04:30',
    'time-to'   => '22:30',
]);
$I->seeResponseCodeIs(403);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('Access denied');


/**
 * Try to retrieve meals of 'user1' with admin's token. Should be OK
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendGET("/user_meals/{$user1->id}/", [
    'token'     => $admin->token,
    'date-from' => '2016-04-06',
    'date-to'   => '2016-06-07',
    'time-from' => '04:30',
    'time-to'   => '22:30',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('"email": "' . $user1->email . '"');


/**
 * Try to retrieve meals without token
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendGET("/user_meals/{$user1->id}/", [
    'date-from' => '2016-04-06',
    'date-to'   => '2016-06-07',
    'time-from' => '04:30',
    'time-to'   => '22:30',
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('The token could not be parsed from the request');

/**
 * Try to retrieve meals with invalid token
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendGET("/user_meals/{$user1->id}/", [
    'token'     => '1231231223234',
    'date-from' => '2016-04-06',
    'date-to'   => '2016-06-07',
    'time-from' => '04:30',
    'time-to'   => '22:30',
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('The token could not be parsed from the request');

/**
 * Try to retrieve meals of not existing user.
 * Should return 404
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendGET("/user_meals/555/", [
    'token'     => $admin->token,
    'date-from' => '2016-06-06',
    'date-to'   => '2016-06-07',
    'time-from' => '18:30',
    'time-to'   => '22:30',
]);
$I->seeResponseCodeIs(404);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('"message": "Resource not found"');
