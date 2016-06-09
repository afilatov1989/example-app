<?php
$I = new ApiTester($scenario);
$I->wantTo('Meal crud index: test fields combinations');

// create new user without meals
$user = $I->createNewUser();
$user_data = $user->toArray();
unset($user_data['token']);

/**
 * Retrieve meals of empty user. Should return 200 with empty data
 */
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendGET("/user_meals/{$user->id}/", [
    'token'     => $user->token,
    'date-from' => '2016-04-06',
    'date-to'   => '2016-06-07',
    'time-from' => '04:30',
    'time-to'   => '22:30',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsJson([
    'data' => [
        'user'       => $user_data,
        'daily_data' => [],
    ],
]);

// add two meals
$meal1 = $I->createNewMealByUser(
    $user,
    '2016-06-06',
    '13:30',
    'Test meal text, some random words for app testing. Lorem Ipsum.',
    300
);

$meal2 = $I->createNewMealByUser(
    $user,
    '2016-06-06',
    '19:30',
    'Test meal text, some random words for app testing. Lorem Ipsum.',
    500
);

/**
 * Retrieve meals of the same user.
 * Should return 200
 * Date filter should show only 2nd meal
 * But 'day_calories' should be equal to the sum of both meals
 */

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendGET("/user_meals/{$user->id}/", [
    'token'     => $user->token,
    'date-from' => '2016-06-06',
    'date-to'   => '2016-06-07',
    'time-from' => '18:30',
    'time-to'   => '22:30',
]);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->haveHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsJson([
    'data' => [
        'user'       => $user_data,
        'daily_data' => [
            '2016-06-06' => [
                'day_calories' => 800,
                'meals'        => [
                    (array)$meal2,
                ],
            ],
        ],
    ]
]);

