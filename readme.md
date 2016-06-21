# Example one page app

The app consists of almost completely decoupled backend and frontend parts.

Frontend part is a single page application (SPA), created using **AngularJS**.

Backend part is a REST API, created using **Laravel** framework (PHP).

Test app deployment is accessible [here](http://example.a-filatov.com/).

## Test credentials
**Admin account (can CRUD all users and all records):**

- admin@test.com : qwerty123

**User manager account (can CRUD all users):**

- manager@test.com : qwerty123

**Common user accounts (can CRUD only their own records):**

- user1@test.com : qwerty123
- user2@test.com : qwerty123
- .......
- user50@test.com : qwerty123

## REST API methods and examples

There are 3 groups of methods in the API:

 - Authentication
 - Meals CRUD
 - Users CRUD

All parameters are required, unless explicity mentioned that some parameter is **optional**.

## Authentication methods

### 1. Sign In

**uri**: /api/v1/signin

**method**: POST

**params**:
 
 - email
 - password

**example response**:

    {
    "data": {
        "token": "<token value here>",
        "user": {
            "id": 3,
            "name": "Elisa Schumm",
            "calories_per_day": 2000,
            "email": "user1@test.com",
            "roles": []
        }
    }
    }

### 2. Sign Up

**uri**: /api/v1/signup

**method**: POST

**params**:

- name
- email
- password

**example response**:

    {
    "data": {
        "token": "<token value here>",
        "user": {
            "id": 3,
            "name": "Elisa Schumm",
            "calories_per_day": 2000,
            "email": "user1@test.com",
            "roles": []
        }
    }
    }

### 3. Password reset
**uri**: /api/v1/password_reset

**method**: PUT | PATCH

**params**:

- email

**example response**:

    {
    "data": {
        "message": "New credentials were sent to your email"
    }
    }

## Meals CRUD methods

All meals crud methods require token. 
It can be passed in the get parameter **token** or via HTTP-header **Authentication**.

### 1. Create a meal
**uri**: /api/v1/user_meals/{user_id}/

**method**: POST

**params**:

- date
- time
- text
- calories

**example response**:

    {
    "data": {
        "date": "2016-04-06",
        "time": "13:30",
        "text": "Some random text...",
        "calories": 670,
        "user_id": 3,
        "id": 1512
    }
    }

### 2. Get user's meals list
**uri**: /api/v1/user_meals/{user_id}/

**method**: GET

**params**:

- date-from
- date-to
- time-from
- time-to

**example response**:

    {
    {
        "user": {
            "id": 3,
            "name": "Maud Beer",
            "calories_per_day": 2000,
            "email": "user1@test.com"
        },
        "daily_data": {
            "2016-04-06": {
                "day_calories": 670,
                "meals": [
                    {
                        "id": 1517,
                        "user_id": 3,
                        "date": "2016-04-06",
                        "time": "13:30",
                        "text": "Test meal text, some random words for app",
                        "calories": 670
                    }
                ]
            },
            "2016-05-21": {
                "day_calories": 3447,
                "meals": [
                    {
                        "id": 2,
                        "user_id": 3,
                        "date": "2016-05-21",
                        "time": "14:21",
                        "text": "Aliquam sunt veritatis fuga nulla",
                        "calories": 2055
                    }
                ]
            }
        }
    }
    }

### 3. Update a meal
**uri**: /api/v1/user_meals/{user_id}/{meal_id}/

**method**: PUT | PATCH

**params**:

- date
- time
- text
- calories

**example response**:

    {
    "data": {
        "date": "2016-04-06",
        "time": "13:30",
        "text": "Some random text...",
        "calories": 670,
        "user_id": 3,
        "id": 1512
    }
    }

### 4. Delete a meal
**uri**: /api/v1/user_meals/{user_id}/{meal_id}/

**method**: DELETE

**params**:

no params

**example response**:

    {
    "data": {
        "message": "Meal successfully deleted",
        "id": "1526"
    }
    }


## Users CRUD methods


All users crud methods require token. 
It can be passed in the get parameter **token** or via HTTP-header **Authentication**.

### 1. Create a user
**uri**: /api/v1/users/

**method**: POST

**params**:

- name
- email
- password
- calories_per_day

**example response**:

    {
    "data": {
        "name": "John Smith",
        "email": "new_user@test.com",
        "calories_per_day": 3000,
        "id": 68
    }
    }

### 2. Get list of users

Name and email parameters filter user by name and email.
Page parameter provides pagination. Every page contains 10 users.

**uri**: /api/v1/users/

**method**: GET

**params**:

- name (optional)
- email (optional)
- page (optional)

**example response**:

    {
	"data": {
        "total": 52,
        "per_page": 10,
        "current_page": 1,
        "last_page": 6,
        "from": 1,
        "to": 10,
        "data": [
            {
                "id": 1,
                "name": "John Smith",
                "calories_per_day": 2000,
                "email": "admin@test.com"
            },
            {
                "id": 2,
                "name": "Jack Doe",
                "calories_per_day": 2000,
                "email": "manager@test.com"
            },
            ...................
        ]
    }
    }

### 3. Get user by ID
**uri**: /api/v1/users/{user_id}/

**method**: GET

**params**:

- no params

**example response**:

    {
    "data": {
        "id": 1,
        "name": "John Smith",
        "calories_per_day": 2000,
        "email": "admin@test.com",
        "roles": [
            {
                "id": 1,
                "name": "admin",
                "display_name": "Administrator",
                "description": "User is allowed to manage and edit other users and their records"
            }
        ]
    }
    }

### 4. Update a user

**uri**: /api/v1/users/{user_id}/

**method**: PUT | PATCH

**params**:

- name
- email
- calories_per_day

**example response**:

    {
    "data": {
        "name": "John Smith",
        "email": "new_user@test.com",
        "calories_per_day": 3000,
        "id": 68
    }
    }

### 5. Delete a user

**uri**: /api/v1/users/{user_id}/

**method**: DELETE

**params**:

no params

**example response**:

    {
    "data": {
         "message": "User successfully deleted",
        "id": 22
    }
    }


### 6. Change user password

**uri**: /api/v1/users/change_password/{user_id}/

**method**: PUT | PATCH

**params**:

- password

**example response**:

    {
    "data": {
        "message": "Password successfully changed",
        "id": 3
    }
    }



