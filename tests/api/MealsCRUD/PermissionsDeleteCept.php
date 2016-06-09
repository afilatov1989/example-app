<?php
$I = new ApiTester($scenario);
$I->wantTo('Meal crud delete: check token and role restrictions');

// create common user
$user = $I->getUserByEmail('user1@test.com');
$meal = $I->createNewMealByUser($user);

/**
 * Delete a meal. Should be successful
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendDELETE("/user_meals/{$user->id}/{$meal->id}/?token={$user->token}", []);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('"id": "' . $meal->id . '"');


/**
 * Try to delete a meal which does not exist. Should be 404
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendDELETE("/user_meals/{$user->id}/{$meal->id}/?token={$user->token}", []);
$I->seeResponseCodeIs(404);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('Meal not found');


// create common users and admin for checking permissions
$user1 = $I->getUserByEmail('user1@test.com');
$user2 = $I->getUserByEmail('user2@test.com');
$admin = $I->getUserByEmail('admin@test.com');
$meal = $I->createNewMealByUser($user1);

/**
 * Try to delete a meal with another user's token. Should be prohibited
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendDELETE("/user_meals/{$user1->id}/{$meal->id}/?token={$user2->token}",
    []);
$I->seeResponseCodeIs(403);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('Access denied');

/**
 * Try to delete a user's meal with admin's token. Should be OK
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendDELETE("/user_meals/{$user1->id}/{$meal->id}/?token={$admin->token}",
    []);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('Meal successfully deleted');
$I->seeResponseContains('"id": "' . $meal->id . '"');


$meal = $I->createNewMealByUser($user1);

/**
 * Try to delete a meal without a token
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendDELETE("/user_meals/{$user1->id}/{$meal->id}", []);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('The token could not be parsed from the request');

/**
 * Try to delete a meal with invalid token
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendDELETE("/user_meals/{$user1->id}/{$meal->id}/?token=123123123", []);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContains('The token could not be parsed from the request');
