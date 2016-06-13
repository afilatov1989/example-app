(function () {
    'use strict';

    angular.module('app')
        .factory('Meal', ['appConfig', '$http', '$rootScope',
            function (appConfig, $http, $rootScope) {

                /**
                 * Converts meal date and time from text to JS objects
                 * Returns the same meal with converted dates (NOT a copy)
                 */
                function setDates(meal) {
                    // default date for meal creation is current moment
                    if (!meal) return {
                        date: new Date(moment().format('YYYY-MM-DD') + " 00:00:00"),
                        time: new Date("1970-01-01 " + moment().format('HH:mm') + ":00")
                    };

                    meal.date = new Date(meal.date + " 00:00:00");
                    meal.time = new Date("1970-01-01 " + meal.time + ":00");

                    return meal;
                }

                /**
                 * Converts meal date and time from JS objects to text format,
                 * acceptable in REST api queries
                 *
                 * Returns the same meal with converted dates (NOT a copy)
                 */
                function datesToText(meal) {
                    if (!meal) return null;

                    meal.date = moment(meal.date).format('YYYY-MM-DD');
                    meal.time = moment(meal.time).format('HH:mm');

                    return meal;
                }

                /**
                 * Returns a copy of a meal
                 */
                function clone(meal) {
                    if (!meal) return null;

                    var new_meal = {};
                    new_meal.id = meal.id;
                    new_meal.date = meal.date;
                    new_meal.time = meal.time;
                    new_meal.text = meal.text;
                    new_meal.calories = meal.calories;

                    return new_meal;
                };

                /**
                 * CRUD functions for interaction with API
                 */
                return {
                    getMeals: function (user_id, data, success, error) {
                        $http({
                            method: 'GET',
                            url: appConfig.apiUrl + 'user_meals/' + user_id,
                            params: data
                        }).then(success, error);
                    },
                    create: function (user_id, data, success, error) {
                        datesToText(data);
                        $http.post(appConfig.apiUrl + 'user_meals/' + user_id, data)
                            .success(success)
                            .error(error);
                    },
                    update: function (user_id, data, success, error) {
                        data['_method'] = 'PUT';
                        datesToText(data);
                        $http.post(appConfig.apiUrl + 'user_meals/' + user_id + '/' + data.id, data)
                            .success(success)
                            .error(error);
                    },
                    delete: function (user_id, meal_id, success) {
                        var data = {
                            '_method': 'DELETE'
                        };
                        $http.post(appConfig.apiUrl + 'user_meals/' + user_id + '/' + meal_id, data)
                            .success(success)
                            .error($rootScope.errorsFromRequest);
                    },
                    clone: clone,
                    setDates: setDates,
                    datesToText: datesToText
                };
            }
        ]);
})();