(function () {
    'use strict';

    angular.module('app', [
            'ngStorage',
            'ngRoute',
            'angular-loading-bar'
        ])
        .constant('appConfig', {
            apiUrl: '/api/v1/'
        })
        .config(['$routeProvider', '$httpProvider', '$locationProvider',
            function ($routeProvider, $httpProvider, $locationProvider) {
                $routeProvider.when('/signin', {
                    templateUrl: 'partials/signin.html',
                    controller: 'AuthController'
                }).when('/signup', {
                    templateUrl: 'partials/signup.html',
                    controller: 'AuthController'
                }).when('/', {
                    templateUrl: 'partials/meals.html',
                    controller: 'MealsController'
                }).when('/user_meals/:user', {
                    templateUrl: 'partials/meals.html',
                    controller: 'MealsController'
                }).when('/users', {
                    templateUrl: 'partials/users.html',
                    controller: 'UsersController'
                }).otherwise({
                    redirectTo: '/'
                });

                $locationProvider.html5Mode(true);

                $httpProvider.interceptors.push(['$q', '$location', '$localStorage',
                    function ($q, $location, $localStorage) {
                        return {
                            'request': function (config) {
                                config.headers = config.headers || {};
                                if ($localStorage.token) {
                                    config.headers.Authorization = 'Bearer ' + $localStorage.token;
                                }
                                return config;
                            },
                            'responseError': function (response) {
                                if (response.status === 401 || response.status === 403) {
                                    $location.path('/');
                                }
                                return $q.reject(response);
                            }
                        };
                    }]);
            }
        ])
        .run(['$rootScope', '$location', '$localStorage',
            function ($rootScope, $location, $localStorage) {
                $rootScope.errorsFromRequest = function (response) {
                    if (typeof(response.error) === 'undefined') response = response.data;
                    if (typeof(response.error.errors) === 'object')
                        $rootScope.error = response.error.errors.join('\n');
                    else if (typeof(response.error.message) === 'string')
                        $rootScope.error = response.error.message;
                    else
                        $rootScope.error = 'Unknown error';
                };

                $rootScope.$on("$routeChangeStart", function (event, next) {

                    $rootScope.error = '';

                    if ($localStorage.token == null) {
                        if (next.templateUrl !== "partials/signin.html" &&
                            next.templateUrl !== "partials/signup.html") {

                            $location.path("/signin");
                        }
                    } else {
                        if (next.templateUrl === "partials/signin.html" ||
                            next.templateUrl === "partials/signup.html") {

                            $location.path("/");
                        }
                    }
                });
            }]);
})();