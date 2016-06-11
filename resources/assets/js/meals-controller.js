(function () {
    'use strict';

    angular.module('app')
        .controller('MealsController', ['$rootScope', '$scope', '$location', 'Meal', 'Auth', '$routeParams',
            function ($rootScope, $scope, $location, Meal, Auth, $routeParams) {

                // Get user_id from token or route parameter
                var user_id = Auth.getTokenClaims().sub;
                if (typeof($routeParams.user) !== 'undefined') user_id = $routeParams.user;

                $scope.date_from = new Date();
                $scope.date_from.setDate($scope.date_from.getDate() - 7);
                $scope.date_to = new Date();
                $scope.time_from = null;
                $scope.time_to = null;

                $scope.meal_update_show = false;
                $scope.updateMealForm = function (meal) {
                    $scope.current_meal = meal;
                    $scope.meal_update_show = !$scope.meal_update_show;
                    $rootScope.modal_back_show = !$rootScope.modal_back_show;
                };
                $scope.updateMealFormClose = function () {
                    $scope.current_meal = null;
                    $scope.meal_update_show = !$scope.meal_update_show;
                    $rootScope.modal_back_show = !$rootScope.modal_back_show;
                };

                $scope.dateFormat = function (date) {
                    return moment(date).format('Do MMMM YYYY');
                }

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
                        $rootScope.user = response.data.data.user;
                    }, $rootScope.errorsFromRequest);
                };

                $scope.getMeals();

            }]);
})();
