<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\User;

class Api extends \Codeception\Module
{

    /**
     * Returns a valid token of a user with given $email
     * If user is not found, throws an exception
     *
     * @param $email
     * @return mixed
     * @throws \Codeception\Exception\ModuleException
     */
    public function getUserByEmail($email)
    {
        $user = User::getByEmail($email);

        $this->getModule('REST')->sendPOST('/signin', [
            'email'    => $email,
            'password' => 'qwerty123',
        ]);

        $token = json_decode($this->getModule('REST')->response)->data->token;
        $user->token = $token;

        return $user;
    }

    /**
     * Creates new user without any meals
     * Returns his token
     * If there are any errors, throws exception
     *
     * @param string $email
     * @param string $pass
     * @param string $name
     * @return mixed
     * @throws \Codeception\Exception\ModuleException
     */
    public function createNewUser(
        $email = 'test_user@test.com',
        $pass = 'qwerty123',
        $name = 'John Doe'
    ) {
        $this->getModule('REST')->sendPOST('/signup', [
            'name'                  => $name,
            'email'                 => $email,
            'password'              => $pass,
            'password_confirmation' => $pass,
        ]);

        $token = json_decode($this->getModule('REST')->response)->data->token;
        $user = User::getByEmail($email);
        $user->token = $token;

        return $user;
    }

    /**
     * Checks if there is a token in response.
     * Correctness of token is not checked, only the structure of response
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function seeResponseContainsToken()
    {
        $response = json_decode($this->getModule('REST')->response, true);
        $this->assertArrayHasKey('data', $response, '');
        $this->assertArrayHasKey('token', $response['data'], '');
    }

    /**
     * Creates new meal by user token (string value) for testing
     * If service returns an error, throws exception
     *
     * @param $user
     * @param string $date
     * @param string $time
     * @param string $text
     * @param int $calories
     * @return mixed
     * @throws \Codeception\Exception\ModuleException
     */
    public function createNewMealByUser(
        $user,
        $date = '2016-04-06',
        $time = '13:30',
        $text = 'Test meal text, some random words for app testing. Lorem Ipsum.',
        $calories = 670
    ) {

        $this->getModule('REST')->sendPOST("/user_meals/{$user->id}/?token=" . $user->token,
            [
                'date'     => $date,
                'time'     => $time,
                'text'     => $text,
                'calories' => $calories,
            ]);

        return json_decode($this->getModule('REST')->response)->data;
    }

}
