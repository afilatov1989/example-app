<?php
$I = new ApiTester($scenario);
$I->wantTo('Users crud show: check token and role restrictions');

// create common users, manager and admin for checking permissions
$user1 = $I->getUserByEmail('user1@test.com');
$user2 = $I->getUserByEmail('user2@test.com');
$manager = $I->getUserByEmail('manager@test.com');
$admin = $I->getUserByEmail('admin@test.com');

/**
 * Retrieve current user. Should be ok
 */
$I->sendGET("/users/{$user1->id}/", [
    'token' => $user1->token,
]);

$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'data' => [
        'id'               => $user1->id,
        'name'             => $user1->name,
        'email'            => $user1->email,
        'calories_per_day' => $user1->calories_per_day,
    ],
]);

/**
 * Retrieve another user. Should be prohibited (403)
 */
$I->sendGET("/users/{$user1->id}/", [
    'token' => $user2->token,
]);
$I->seeResponseCodeIs(403);
$I->seeResponseIsJson();
$I->seeResponseContains('Access denied');

/**
 * Retrieve current user with admin's token. Should be ok
 */
$I->sendGET("/users/{$user1->id}/", [
    'token' => $admin->token,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'data' => [
        'id'               => $user1->id,
        'name'             => $user1->name,
        'email'            => $user1->email,
        'calories_per_day' => $user1->calories_per_day,
    ],
]);

/**
 * Retrieve current user with manager's token. Should be ok
 */
$I->sendGET("/users/{$user1->id}/", [
    'token' => $manager->token,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'data' => [
        'id'               => $user1->id,
        'name'             => $user1->name,
        'email'            => $user1->email,
        'calories_per_day' => $user1->calories_per_day,
    ],
]);


/**
 * Retrieve not existing user. Should be 404
 */
$I->sendGET("/users/666/", [
    'token' => $manager->token,
]);
$I->seeResponseCodeIs(404);
$I->seeResponseIsJson();
$I->seeResponseContains('not found');
