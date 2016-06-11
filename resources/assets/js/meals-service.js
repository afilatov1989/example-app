(function () {
    'use strict';

    angular.module('app')
        .factory('Meal', ['appConfig', '$http', '$localStorage', '$routeParams',
            function (appConfig, $http, $localStorage, $routeParams) {

                return {
                    getMeals: function (user_id, data, success, error) {
                        $http({
                            method: 'GET',
                            url: appConfig.apiUrl + 'user_meals/' + user_id,
                            params: data
                        }).then(success, error);
                    },
                    createMeal: function (user_id, data, success, error) {
                        $http.post(appConfig.apiUrl + 'user_meals/' + user_id, data).success(success).error(error);
                    },
                    updateMeal: function (user_id, data, success, error) {
                        data['_method'] = 'PUT';
                        $http.post(appConfig.apiUrl + 'user_meals/' + user_id + '/' + meal_id, data)
                            .success(success).error(error);
                    },
                    deleteMeal: function (user_id, data, success, error) {
                        data['_method'] = 'DELETE';
                        $http.post(appConfig.apiUrl + 'user_meals/' + user_id + '/' + meal_id, data)
                            .success(success).error(error);
                    }
                };
            }
        ]);
})();