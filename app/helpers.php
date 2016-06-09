<?php

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;

function rest_data_response(array $data)
{
    return response()->json([
        'data' => $data
    ])->setJsonOptions(JSON_PRETTY_PRINT);
}

function rest_error_response($code, $message, array $errors = [])
{
    $response = [
        'error' => [
            'code'    => $code,
            'message' => $message,
        ]
    ];

    if (count($errors) > 0) {
        $response['error']['errors'] = $errors;
    }

    return response()->json($response, $code)
        ->setJsonOptions(JSON_PRETTY_PRINT);
}

function rest_validator_error_response(Validator $validator)
{
    $errors = $validator->getMessageBag()->all();

    return rest_error_response(
        Response::HTTP_BAD_REQUEST, 'Bad request', $errors
    );
}
