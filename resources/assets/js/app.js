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

                $httpProvider.interceptors.push(['$q', '$location', '$localStorage', '$rootScope',
                    function ($q, $location, $localStorage, $rootScope) {
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
                                    delete $localStorage.token;
                                    $localStorage.$save();
                                    $rootScope.token = null;
                                    $rootScope.tokenClaims = null;
                                    $location.path('/signin');
                                }
                                return $q.reject(response);
                            }
                        };
                    }]);
            }
        ])
        .run(['$rootScope', '$location', '$localStorage', 'Auth',
            function ($rootScope, $location, $localStorage, Auth) {

                $rootScope.cur_user_update_show = false;
                $rootScope.modal_back_show = false;
                $rootScope.token = $localStorage.token;
                $rootScope.tokenClaims = Auth.getTokenClaims();

                $rootScope.updateCurUserFormToggle = function () {
                    $rootScope.cur_user_update_show = !$rootScope.cur_user_update_show;
                    $rootScope.modal_back_show = !$rootScope.modal_back_show;
                };

                $rootScope.errorsFromRequest = function (response) {
                    if (typeof(response.error) === 'undefined') response = response.data;

                    $rootScope.error = 'Unknown error';
                    if (typeof(response.error.errors) === 'object')
                        $rootScope.error = response.error.errors.join('\n');
                    else if (typeof(response.error.message) === 'string')
                        $rootScope.error = response.error.message;
                };

                $rootScope.$on("$routeChangeStart", function (event, next) {

                    $rootScope.error = '';

                    if ($localStorage.token == null && next.controller != 'AuthController') {
                        $location.path("/signin");
                    }

                    if ($localStorage.token != null && next.controller == 'AuthController') {
                        $location.path("/");
                    }

                });
            }]);
})();