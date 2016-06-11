<?php
$I = new ApiTester($scenario);
$I->wantTo('Users crud update: check token and role restrictions');

// create common users, manager and admin for checking permissions
$user1 = $I->getUserByEmail('user30@test.com');
$user2 = $I->getUserByEmail('user31@test.com');
$manager = $I->getUserByEmail('manager@test.com');
$admin = $I->getUserByEmail('admin@test.com');

/**
 * Update current user. Should be ok
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT("/users/{$user1->id}/?token={$user1->token}", [
    'name'             => 'New name',
    'email'            => 'new_email@test.com',
    'calories_per_day' => 8000,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsJson([
    'data' => [
        'name'             => 'New name',
        'email'            => 'new_email@test.com',
        'calories_per_day' => 8000,
        'id'               => $user1->id,
    ],
]);

/**
 * Update current try to check his own roles. Should be 403
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT("/users/{$user1->id}/?token={$user1->token}", [
    'name'             => 'New name',
    'email'            => 'new_email@test.com',
    'calories_per_day' => 8000,
    'roles'            => [1],
]);
$I->seeResponseCodeIs(403);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('Changing user roles is not allowed');


/**
 * Retrieve updated user. All fields should be updated
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendGET("/users/{$user1->id}/", [
    'token' => $user1->token,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsJson([
    'data' => [
        'id'               => $user1->id,
        'name'             => 'New name',
        'email'            => 'new_email@test.com',
        'calories_per_day' => 8000,
    ],
]);

/**
 * Update using manager's token. Should be ok
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT("/users/{$user1->id}/?token={$manager->token}", [
    'name'             => 'New name2',
    'email'            => 'new_email2@test.com',
    'calories_per_day' => 8500,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsJson([
    'data' => [
        'name'             => 'New name2',
        'email'            => 'new_email2@test.com',
        'calories_per_day' => 8500,
        'id'               => $user1->id,
    ],
]);

/**
 * Update using admin's token. Should be ok
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT("/users/{$user1->id}/?token={$admin->token}", [
    'name'             => 'New name3',
    'email'            => 'new_email3@test.com',
    'calories_per_day' => 9500,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsJson([
    'data' => [
        'name'             => 'New name3',
        'email'            => 'new_email3@test.com',
        'calories_per_day' => 9500,
        'id'               => $user1->id,
    ],
]);

/**
 * Retrieve updated user. All fields should be updated
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendGET("/users/{$user1->id}/", [
    'token' => $user1->token,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsJson([
    'data' => [
        'id'               => $user1->id,
        'name'             => 'New name3',
        'email'            => 'new_email3@test.com',
        'calories_per_day' => 9500,
    ],
]);

