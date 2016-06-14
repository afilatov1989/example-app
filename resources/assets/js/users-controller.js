(function () {
    'use strict';

    angular.module('app')
        .controller('UsersController', ['$location', '$route', '$routeParams', '$rootScope', '$scope', 'User', 'Auth',
            function ($location, $route, $routeParams, $rootScope, $scope, User) {

                /**
                 * There are only get and delete method in this controller.
                 *
                 * Create, update and change password are made global,
                 * because they are called from various places
                 * (e.g. navbar, meals)
                 *
                 * You can find those methods in users-service.js
                 * (updateOrCreateUser and changeUserPassword methods)
                 */

                /**
                 * =============================================================
                 *
                 * GET users list
                 *
                 * =============================================================
                 */
                $scope.filter_data = {
                    page: 1
                };
                $rootScope.getUsers = function () {
                    $scope.filter_data.page = $routeParams.page;
                    $scope.filter_data.email = $routeParams.email;
                    $scope.filter_data.name = $routeParams.name;

                    User.getAll($scope.filter_data, function (response) {
                        var response_data = response.data.data;
                        $scope.userlist = response_data.data;
                        $scope.num_pages = response_data.last_page;
                        $scope.current_page = response_data.current_page;
                        $scope.users_count = response_data.total;
                        $rootScope.page_content_loaded = true;
                        if ($scope.filter_data.page > $scope.num_pages)
                            $scope.setPage($scope.num_pages);
                    });
                };
                $rootScope.getUsers();

                /**
                 * Changes current page without page reload
                 * Filter values preserved
                 */
                $scope.setPage = function (page) {
                    $scope.filter_data.page = page;
                    $scope.applyFilter();
                };

                /**
                 * Applies users filter and add get params to URI
                 * without page reload
                 */
                $scope.applyFilter = function () {
                    $location.path('/users').search({
                        name: $scope.filter_data.name,
                        email: $scope.filter_data.email,
                        page: $scope.filter_data.page || 1
                    });
                };

                /**
                 * Generates array of pages for pagination
                 */
                $scope.getPager = function () {
                    var pages = {};
                    for (var i = 5; i > 0; i--) {
                        if ($scope.current_page - i >= 1)
                            pages[$scope.current_page - i] = '';
                    }
                    pages[$scope.current_page] = 'active';
                    for (i = 1; i < 6; i++) {
                        if ($scope.current_page + i <= $scope.num_pages)
                            pages[$scope.current_page + i] = '';
                    }

                    return pages;
                }

                /**
                 * =============================================================
                 *
                 * DELETE a user
                 *
                 * =============================================================
                 */

                /**
                 * Shows delete confirmation message
                 */
                $scope.deleteUserFormToggle = function (user) {
                    $scope.deleting_user = user;

                    $scope.user_delete_show = !$scope.user_delete_show;
                    $rootScope.modal_back_show = !$rootScope.modal_back_show;
                };

                /**
                 * Deletes provided user
                 */
                $scope.deleteUser = function (user) {
                    User.del(user.id, function () {
                        $rootScope.getUsers();
                        $scope.deleteUserFormToggle(null);
                    });
                };

            }
        ]);
})();