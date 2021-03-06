<?php
use App\User;

$I = new ApiTester($scenario);
$I->wantTo('Users crud update: test fields combinations');

// create common user, manager and admin for checking permissions
$manager = $I->getUserByEmail('manager@test.com');

/**
 * Creates user with 1 role for further updates.
 */
$I->sendPOST("/users/?token={$manager->token}", [
    'name'             => 'John Smith',
    'email'            => 'new_user@test.com',
    'password'         => 'qwerty123',
    'calories_per_day' => 3000,
    'roles'            => [1],
]);
$user = User::find($I->grabDataFromResponseByJsonPath('data.id')[0]);

/**
 * Update using manager's token. Should be ok
 */
$I->sendPUT("/users/{$user->id}/?token={$manager->token}", [
    'name'             => 'New name2',
    'email'            => 'new_email2@test.com',
    'calories_per_day' => 8500,
    'roles'            => [2],
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'data' => [
        'name'             => 'New name2',
        'email'            => 'new_email2@test.com',
        'calories_per_day' => 8500,
        'id'               => $user->id,
    ],
]);

/**
 * Check all fields are correct (including roles)
 */
$I->sendGET("/users/{$user->id}/", [
    'token' => $manager->token,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'data' => [
        'id'               => $user->id,
        'name'             => 'New name2',
        'email'            => 'new_email2@test.com',
        'calories_per_day' => 8500,
        'roles'            => [
            [
                "id" => 2,
            ]
        ],
    ],
]);

/**
 * User tries to update email used by another user. Should be 409 (conflict)
 */
$I->sendPUT("/users/{$user->id}/?token={$manager->token}", [
    'name'             => 'New name2',
    'email'            => 'user10@test.com',
    'calories_per_day' => 8500,
]);
$I->seeResponseCodeIs(409);
$I->seeResponseIsJson();
$I->seeResponseContains('"The email has already been taken."');
