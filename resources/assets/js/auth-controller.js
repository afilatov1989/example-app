(function () {
    'use strict';

    angular.module('app')
        .controller('AuthController', ['$rootScope', '$scope', '$location', '$localStorage', 'Auth',
            function ($rootScope, $scope, $location, $localStorage, Auth) {

                $scope.signin = function () {
                    var formData = {
                        email: $scope.email,
                        password: $scope.password
                    };

                    Auth.signin(formData, successAuth, $rootScope.errorsFromRequest)
                };

                $scope.signup = function () {
                    var formData = {
                        name: $scope.name,
                        email: $scope.email,
                        password: $scope.password,
                        password_confirmation: $scope.password_confirmation
                    };

                    Auth.signup(formData, successAuth, $rootScope.errorsFromRequest)
                };

                function successAuth(res) {
                    $localStorage.token = res.data.token;
                    $localStorage.$save();
                    $rootScope.token = res.data.token;
                    $rootScope.tokenClaims = Auth.getTokenClaims();
                    $location.path("/");
                }

                $scope.logout = function () {
                    Auth.logout(function () {
                        $rootScope.token = false;
                        $rootScope.tokenClaims = false;
                        $location.path("/signin");
                    });
                };

                $rootScope.token = $localStorage.token;
                $rootScope.tokenClaims = Auth.getTokenClaims();
                $rootScope.cur_user_update_show = false;
                $rootScope.modal_back_show = false;
                $rootScope.updateCurUserFormToggle = function () {
                    $rootScope.cur_user_update_show = !$rootScope.cur_user_update_show;
                    $rootScope.modal_back_show = !$rootScope.modal_back_show;
                };
            }]);
})();
