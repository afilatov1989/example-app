<?php
$I = new ApiTester($scenario);
$I->wantTo('Users crud change password: check token and role restrictions');

// create common users, manager and admin for checking permissions
$user1 = $I->getUserByEmail('user1@test.com');
$user2 = $I->getUserByEmail('user2@test.com');
$manager = $I->getUserByEmail('manager@test.com');
$admin = $I->getUserByEmail('admin@test.com');

/**
 * Change password to current user. Should be ok
 */
$I->sendPUT("/users/change_password/{$user1->id}/?token={$user1->token}", [
    'password' => 'new_pass1',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'data' => [
        'message' => 'Password successfully changed',
        'id'      => $user1->id,
    ],
]);

/**
 * Sign In with new password. Should be ok
 */
$I->sendPOST('/signin', [
    'email'    => 'user1@test.com',
    'password' => 'new_pass1',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsToken();

/**
 * Sign In with old password. Should be 401 error
 */

$I->sendPOST('/signin', [
    'email'    => 'user1@test.com',
    'password' => 'qwerty123',
]);
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();
$I->seeResponseContains('Invalid credentials');


/**
 * Change password using manager's token. Should be ok
 */
$I->sendPUT("/users/change_password/{$user1->id}/?token={$manager->token}", [
    'password' => 'new_pass2',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'data' => [
        'message' => 'Password successfully changed',
        'id'      => $user1->id,
    ],
]);

/**
 * Sign In with new password. Should be ok
 */
$I->sendPOST('/signin', [
    'email'    => 'user1@test.com',
    'password' => 'new_pass2',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsToken();


/**
 * Change password using admin's token. Should be ok
 */
$I->sendPUT("/users/change_password/{$user1->id}/?token={$admin->token}", [
    'password' => 'new_pass3',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    'data' => [
        'message' => 'Password successfully changed',
        'id'      => $user1->id,
    ],
]);

/**
 * Sign In with new password. Should be ok
 */
$I->sendPOST('/signin', [
    'email'    => 'user1@test.com',
    'password' => 'new_pass3',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsToken();

