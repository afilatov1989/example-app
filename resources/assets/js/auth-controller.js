(function () {
    'use strict';

    angular.module('app')
        .controller('AuthController', ['$rootScope', '$scope', 'Auth',
            function ($rootScope, $scope, Auth) {

                $scope.signin = function () {
                    $scope.$broadcast('show-errors-check-validity');
                    if ($scope.signInForm.$invalid) {
                        return;
                    }

                    var formData = {
                        email: $scope.email,
                        password: $scope.password
                    };

                    Auth.signin(formData);
                };

                $scope.signup = function () {
                    $scope.$broadcast('show-errors-check-validity');
                    if ($scope.signUpForm.$invalid) {
                        return;
                    }

                    var formData = {
                        name: $scope.name,
                        email: $scope.email,
                        password: $scope.password,
                        password_confirmation: $scope.password_confirmation
                    };

                    Auth.signup(formData);
                };

                $scope.resetPass = function () {
                    $scope.$broadcast('show-errors-check-validity');
                    if ($scope.resetPassForm.$invalid) {
                        return;
                    }

                    var formData = {
                        email: $scope.email
                    };

                    Auth.resetPass(formData);
                };

                $scope.logout = function () {
                    Auth.logout();
                };

            }]);
})();
