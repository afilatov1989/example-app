<?php
$I = new ApiTester($scenario);
$I->wantTo('Users crud create: check token and role restrictions');

// create common user, manager and admin for checking permissions
$user = $I->getUserByEmail('user1@test.com');
$manager = $I->getUserByEmail('manager@test.com');
$admin = $I->getUserByEmail('admin@test.com');

/**
 * Common user tries to create a new user. Should be prohibited (403)
 */
$I->sendPOST("/users/?token={$user->token}", [
    'name'             => 'John Smith',
    'email'            => 'new_user2@test.com',
    'password'         => 'qwerty123',
    'calories_per_day' => 5000,
]);
$I->seeResponseCodeIs(403);
$I->seeResponseIsJson();
$I->seeResponseContains('Access denied');

/**
 * Manager creates new user. Should be ok
 */
$I->sendPOST("/users/?token={$manager->token}", [
    'name'             => 'John Smith',
    'email'            => 'new_user@test.com',
    'password'         => 'qwerty123',
    'calories_per_day' => 3000,
]);

$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'data' => [
        'name'             => 'John Smith',
        'email'            => 'new_user@test.com',
        'calories_per_day' => 3000,
        'id'               => $I->grabDataFromResponseByJsonPath('data.id')[0],
    ],
]);

/**
 * New user should be able to sign in
 */
$I->sendPOST('/signin', [
    'email'    => 'new_user@test.com',
    'password' => 'qwerty123',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsToken();


/**
 * Admin creates new user. Should be ok
 */
$I->sendPOST("/users/?token={$admin->token}", [
    'name'             => 'John Smith',
    'email'            => 'new_user2@test.com',
    'password'         => 'qwerty123',
    'calories_per_day' => 5000,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'data' => [
        'name'             => 'John Smith',
        'email'            => 'new_user2@test.com',
        'calories_per_day' => 5000,
        'id'               => $I->grabDataFromResponseByJsonPath('data.id')[0],
    ],
]);

/**
 * New user should be able to sign in
 */
$I->sendPOST('/signin', [
    'email'    => 'new_user2@test.com',
    'password' => 'qwerty123',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsToken();
