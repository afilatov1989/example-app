(function () {
    'use strict';

    angular.module('app')
        .controller('MealsController', ['$rootScope', '$scope', '$location', 'Meal', 'Auth', '$routeParams',
            function ($rootScope, $scope, $location, Meal, Auth, $routeParams) {

                /* Get user_id from route parameter
                 or get current user if user_id is not provided */
                var user_id = $rootScope.current_user.id;
                if (typeof($routeParams.user) !== 'undefined') user_id = $routeParams.user;

                /**
                 * =============================================================
                 *
                 * GET meals list
                 *
                 * =============================================================
                 */

                /* Set filter initial values */
                $scope.date_from = new Date();
                $scope.date_from.setDate($scope.date_from.getDate() - 7);
                $scope.date_to = new Date();
                $scope.time_from = null;
                $scope.time_to = null;

                /**
                 * Loads Meals from REST API to scope
                 */
                $scope.getMeals = function () {
                    $scope.filter_errors = '';
                    $scope.$broadcast('show-errors-check-validity');
                    if (typeof $scope.filterForm !== 'undefined'
                        && $scope.filterForm.$invalid) {
                        return;
                    }

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
                    }, function (response) {
                        $scope.filter_errors = response.data.error.errors.join('\n');
                    });
                };
                $scope.getMeals();

                /**
                 * =============================================================
                 *
                 * UPDATE or CREATE a meal
                 *
                 * =============================================================
                 */

                /**
                 * Toggles meal modal window
                 * If meal object is passed, loads it for update
                 * If null - shows a blank form for creating a new meal
                 */
                $scope.updateMealFormToggle = function (meal, form_name) {
                    $scope.$broadcast('flush-all-validation-errors');
                    $scope.modalMealFormErrors = '';

                    // Keep old meal data for counting difference
                    $scope.current_meal = Meal.setDates(Meal.clone(meal));

                    // Set form name and show/hide modal window
                    $scope.form_name = form_name;
                    $scope.meal_update_show = !$scope.meal_update_show;
                    $rootScope.modal_back_show = !$rootScope.modal_back_show;
                };

                /**
                 * Creates or updates a meal
                 * Actions depends on scope (whether meal id is provided or not)
                 */
                $scope.updateOrCreateMeal = function () {
                    $scope.meal_modal_errors = '';
                    $scope.$broadcast('show-errors-check-validity');
                    if ($scope.modalMealForm.$invalid) {
                        return;
                    }

                    // decide, create or update a meal
                    var action = Meal.create;
                    if ($scope.current_meal.id > 0) {
                        action = Meal.update;
                    }

                    action(user_id, Meal.clone($scope.current_meal), function () {
                        $scope.getMeals();
                        $scope.updateMealFormToggle(null);
                        $scope.modalMealFormErrors = '';
                    }, function (response) {
                        $scope.modalMealFormErrors = response.error.errors.join('\n');
                    });
                };

                /**
                 * =============================================================
                 *
                 * DELETE a meal
                 *
                 * =============================================================
                 */

                /**
                 * Shows delete confirmation message
                 */
                $scope.deleteMealFormToggle = function (meal) {
                    $scope.modalDeleteMealErrors = '';

                    $scope.current_meal = Meal.setDates(Meal.clone(meal));

                    $scope.meal_delete_show = !$scope.meal_delete_show;
                    $rootScope.modal_back_show = !$rootScope.modal_back_show;
                };

                /**
                 * Deletes provided meal
                 */
                $scope.deleteMeal = function (meal) {
                    Meal.delete(user_id, meal.id, function () {
                        $scope.getMeals();
                        $scope.deleteMealFormToggle(null);
                    }, function (response) {
                        $scope.modalDeleteMealErrors = response.error.errors.join('\n');
                    });
                };


            }]);
})();
