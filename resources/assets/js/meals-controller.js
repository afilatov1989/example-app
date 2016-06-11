(function () {
    'use strict';

    angular.module('app')
        .controller('MealsController', ['$rootScope', '$scope', '$location', 'Meal', 'Auth', '$routeParams',
            function ($rootScope, $scope, $location, Meal, Auth, $routeParams) {

                // Get user_id from route parameter
                // or get current user if user_id is not provided
                var user_id = $rootScope.current_user.id;
                if (typeof($routeParams.user) !== 'undefined') user_id = $routeParams.user;

                /**
                 * GET meals list
                 */

                $scope.date_from = new Date();
                $scope.date_from.setDate($scope.date_from.getDate() - 7);
                $scope.date_to = new Date();
                $scope.time_from = null;
                $scope.time_to = null;

                // load Meals from API to scope
                $scope.getMeals = function () {

                    var data = {
                        "date-from": ($scope.date_from !== null) ?
                            moment($scope.date_from).format('YYYY-MM-DD') : '',

                        "date-to": ($scope.date_to !== null) ?
                            moment($scope.date_to).format('YYYY-MM-DD') : '',

                        "time-from": ($scope.time_from !== null) ?
                            moment($scope.time_from).format('HH:mm') : '00:00',

                        "time-to": ($scope.time_to !== null) ?
                            moment($scope.time_to).format('HH:mm') : '23:59'
                    };

                    Meal.getMeals(user_id, data, function (response) {
                        $rootScope.error = '';
                        $rootScope.page_content_loaded = true;
                        $scope.daily_data = response.data.data.daily_data;
                        $scope.meals_owner = response.data.data.user;
                    });
                };
                $scope.getMeals();

                /**
                 * UPDATE meal
                 */

                $scope.current_meal = null;
                $scope.meal_update_show = false;
                $scope.updateMealFormToggle = function (meal) {
                    $scope.current_meal = meal;
                    $scope.meal_update_show = !$scope.meal_update_show;
                    $rootScope.modal_back_show = !$rootScope.modal_back_show;
                };

            }]);
})();
