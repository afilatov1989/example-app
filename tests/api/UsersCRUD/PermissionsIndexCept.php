<?php
$I = new ApiTester($scenario);
$I->wantTo('Users crud index: check token and role restrictions');

// create common user, manager and admin for checking permissions
$user1 = $I->getUserByEmail('user1@test.com');
$manager = $I->getUserByEmail('manager@test.com');
$admin = $I->getUserByEmail('admin@test.com');

/**
 * Common user tries to retrieve. Should be prohibited
 */
$I->sendGET("/users/", [
    'token' => $user1->token,
]);
$I->seeResponseCodeIs(403);
$I->seeResponseIsJson();
$I->seeResponseContains("Access denied");

/**
 * Manager tries to retrieve. Should be OK
 */
$I->sendGET("/users/", [
    'token' => $manager->token,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('"current_page": 1');

/**
 * Admin tries to retrieve. Should be OK
 */
$I->sendGET("/users/", [
    'token' => $admin->token,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('"current_page": 1');

/**
 * Pagination should work
 */
$I->sendGET("/users/", [
    'page'  => 2,
    'token' => $admin->token,
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('"current_page": 2');
