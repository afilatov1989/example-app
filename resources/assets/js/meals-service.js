(function () {
    'use strict';

    angular.module('app')
        .factory('Meal', ['appConfig', '$http', '$rootScope',
            function (appConfig, $http, $rootScope) {

                return {
                    getMeals: function (user_id, data, success) {
                        $http({
                            method: 'GET',
                            url: appConfig.apiUrl + 'user_meals/' + user_id,
                            params: data
                        }).then(success, $rootScope.errorsFromRequest);
                    },
                    createMeal: function (user_id, data, success) {
                        $http.post(appConfig.apiUrl + 'user_meals/' + user_id, data)
                            .success(success)
                            .error($rootScope.errorsFromRequest);
                    },
                    updateMeal: function (user_id, data, success) {
                        data['_method'] = 'PUT';
                        $http.post(appConfig.apiUrl + 'user_meals/' + user_id + '/' + meal_id, data)
                            .success(success)
                            .error($rootScope.errorsFromRequest);
                    },
                    deleteMeal: function (user_id, data, success) {
                        data['_method'] = 'DELETE';
                        $http.post(appConfig.apiUrl + 'user_meals/' + user_id + '/' + meal_id, data)
                            .success(success)
                            .error($rootScope.errorsFromRequest);
                    }
                };
            }
        ]);
})();