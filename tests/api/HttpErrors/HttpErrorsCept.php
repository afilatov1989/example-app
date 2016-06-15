<?php
$I = new ApiTester($scenario);
$I->wantTo('check user login via /api/v1/signin');
$user1 = $I->getUserByEmail('user1@test.com');

/**
 * random not existent resource. Should be 404
 */
$I->sendPOST('/asdasdasdasdasdasd', []);
$I->seeResponseCodeIs(404);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    "error" => [
        "code"   => 404,
        "errors" => [
            "Resource not found"
        ],
    ]
]);

/**
 * Try to "get" signIn resource (instead of post).
 * Should be 405 (Method not allowed)
 */
$I->sendGET('/signin', []);
$I->seeResponseCodeIs(405);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    "error" => [
        "code"   => 405,
        "errors" => [
            "Method not allowed"
        ],
    ]
]);

/**
 * Try user expired token.
 * Should be 401 (Unauthorized)
 */
$I->sendGET('/user_meals/7/?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL3NjcmVlbmluZy5kZXZcL2FwaVwvdjFcL3NpZ25pbiIsImlhdCI6MTQ2NTMxMzY0NCwiZXhwIjoxNDY1MzIwODQ0LCJuYmYiOjE0NjUzMTM2NDQsImp0aSI6ImM5MmJhOWRjNzMwY2M4ZWYxZjgxNjMyMzI5YzJmMDcwIn0.yX8TRfaCrb1tkk0pxX86oirIg0bz5xMxcDysIDke9jw',
    []);
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    "error" => [
        "code"   => 401,
        "errors" => [
            "Token has expired"
        ],
    ]
]);

/**
 * Try user invalid token.
 * Should be 400 (Bad request)
 */
$I->sendGET('/user_meals/7/?token=123123123',
    []);
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
    "error" => [
        "code"   => 400,
        "errors" => [
            "The token could not be parsed from the request"
        ],
    ]
]);

