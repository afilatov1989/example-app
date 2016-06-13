<?php
$I = new ApiTester($scenario);
$I->wantTo('Users crud deletion: check token and role restrictions');

// create common users, manager and admin for checking permissions
$user1 = $I->getUserByEmail('user1@test.com');
$user2 = $I->getUserByEmail('user20@test.com');
$manager = $I->getUserByEmail('manager@test.com');
$admin = $I->getUserByEmail('admin@test.com');

/**
 * Common user tries to delete himself. Should be prohibited (403)
 */
$I->sendDELETE("/users/{$user1->id}/?token={$user1->token}", []);
$I->seeResponseCodeIs(403);
$I->seeResponseIsJson();
$I->seeResponseContains('Access denied');

/**
 * Common user tries to delete another user. Should be prohibited (403)
 */
$I->sendDELETE("/users/{$user2->id}/?token={$user1->token}", []);
$I->seeResponseCodeIs(403);
$I->seeResponseIsJson();
$I->seeResponseContains('Access denied');

/**
 * Manager tries to delete a user. Should be OK
 */
$I->sendDELETE("/users/{$user2->id}/?token={$manager->token}", []);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJSON([
    'data' => [
        'message' => 'User successfully deleted',
        'id'      => $user2->id,
    ],
]);

/**
 * Retrieve deleted user. Should be 404
 */
$I->sendGET("/users/{$user2->id}/", [
    'token' => $manager->token,
]);
$I->seeResponseCodeIs(404);
$I->seeResponseIsJson();
$I->seeResponseContains('not found');
