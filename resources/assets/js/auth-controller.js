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

                    Auth.signin(formData);
                };

                $scope.signup = function () {
                    var formData = {
                        name: $scope.name,
                        email: $scope.email,
                        password: $scope.password,
                        password_confirmation: $scope.password_confirmation
                    };

                    Auth.signup(formData);
                };

                $scope.logout = function () {
                    Auth.logout();
                };

            }]);
})();
