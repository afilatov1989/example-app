<?php
use App\User;

$I = new ApiTester($scenario);
$I->wantTo('Users crud create: test fields combinations');

// create common user, manager and admin for checking permissions
$manager = $I->getUserByEmail('manager@test.com');

/**
 * Manager creates user with roles. Should be ok.
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST("/users/?token={$manager->token}", [
    'name'             => 'John Smith',
    'email'            => 'new_user@test.com',
    'password'         => 'qwerty123',
    'calories_per_day' => 3000,
    'roles'            => [1, 2],
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$user = User::find($I->grabDataFromResponseByJsonPath('data.id')[0]);

/**
 * Check new user has 2 assigned roles
 */
$I->sendGET("/users/{$user->id}/", [
    'token' => $manager->token,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsJson([
    'data' => [
        'id'               => $user->id,
        'name'             => 'John Smith',
        'email'            => 'new_user@test.com',
        'calories_per_day' => 3000,
        'roles'            => [
            [
                "id" => 1,
            ],
            [
                "id" => 2,
            ]
        ],
    ],
]);


/**
 * Manager tries to create user without name
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST("/users/?token={$manager->token}", [
    'email'            => 'new_user@test.com',
    'password'         => 'qwerty123',
    'calories_per_day' => 3000,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('The name field is required');

/**
 * Manager tries to create user with invalid email
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST("/users/?token={$manager->token}", [
    'name'             => 'John Smith',
    'email'            => 'new_user',
    'password'         => 'qwerty123',
    'calories_per_day' => 3000,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('The email must be a valid');

/**
 * Manager tries to create user without password
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST("/users/?token={$manager->token}", [
    'name'             => 'John Smith',
    'email'            => 'new_user@mail.com',
    'calories_per_day' => 3000,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('The password field is required');

/**
 * Password is too short
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST("/users/?token={$manager->token}", [
    'name'             => 'John Smith',
    'email'            => 'new_user@mail.com',
    'password'         => 'asd',
    'calories_per_day' => 3000,
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('The password must be at least');

/**
 * Calories not integer
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST("/users/?token={$manager->token}", [
    'name'             => 'John Smith',
    'email'            => 'new_user@mail.com',
    'password'         => 'asdasdasdasd',
    'calories_per_day' => 'qqqqq',
]);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('The calories per day must be an integer');


