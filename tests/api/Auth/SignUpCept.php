<?php

$I = new ApiTester($scenario);
$I->wantTo('check new user registration via /api/v1/signup');

/**
 * Correct registration
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('/signup', [
    'name'     => 'John Smith',
    'email'    => 'davert@codeception.com',
    'password' => 'qwerty123',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsToken();
$I->seeResponseContainsJson([
    'data' => [
        'name'  => 'John Smith',
        'email' => 'davert@codeception.com',
    ]
]);

/**
 * Sign In created user. Should be OK
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('/signin', [
    'email'    => 'davert@codeception.com',
    'password' => 'qwerty123',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsToken();

/**
 * Try to sign up with existing email
 */

$I->sendPOST('/signup', [
    'name'     => 'John Smith',
    'email'    => 'davert@codeception.com',
    'password' => 'qwerty123',
]);
$I->seeResponseCodeIs(409);
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseIsJson();
$I->seeResponseContains('User already exists');

/**
 * Try to sign up without name
 */

$I->sendPOST('/signup', [
    'email'    => 'davert@codeception.com',
    'password' => 'qwerty123',
]);
$I->seeResponseCodeIs(400);
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseIsJson();
$I->seeResponseContains('The name field is required');

/**
 * Try to sign up with invalid email
 */

$I->sendPOST('/signup', [
    'name'     => 'John Smith',
    'email'    => 'davert@codece',
    'password' => 'qwerty123',
]);
$I->seeResponseCodeIs(400);
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseIsJson();
$I->seeResponseContains('The email must be a valid');

/**
 * Try to sign up with too short password
 */

$I->sendPOST('/signup', [
    'name'     => 'John Smith',
    'email'    => 'davert@codeception.com',
    'password' => 'qw',
]);
$I->seeResponseCodeIs(400);
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseIsJson();
$I->seeResponseContains('password must be at least');
