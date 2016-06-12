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

                // ROUTES
                $routeProvider.when('/signin', {
                    templateUrl: 'partials/signin.html',
                    controller: 'AuthController'
                }).when('/signup', {
                    templateUrl: 'partials/signup.html',
                    controller: 'AuthController'
                }).when('/password_reset', {
                    templateUrl: 'partials/password_reset.html',
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

                $httpProvider.interceptors.push(['$q', '$location', '$localStorage', '$injector',
                    function ($q, $location, $localStorage, $injector) {
                        return {
                            // Add token header to each request
                            'request': function (config) {
                                config.headers = config.headers || {};
                                if ($localStorage.token) {
                                    config.headers.Authorization = 'Bearer ' + $localStorage.token;
                                }
                                return config;
                            },
                            // Logout user if she is not authenticated
                            // or tried to access restricted resource
                            'responseError': function (response) {
                                var Auth = $injector.get('Auth');
                                if (response.status === 401 || response.status === 403) {
                                    Auth.logout();
                                }
                                return $q.reject(response);
                            }
                        };
                    }]);
            }
        ])
        .run(['$rootScope', '$location', 'Auth', '$injector',
            function ($rootScope, $location, Auth, $injector) {

                // load app info from Auth service to $rootScope
                Auth.loadTokenToRootScope();
                Auth.loadUserToRootScope();

                // load global and user functions to $rootScope
                $injector.get('Globals');
                $injector.get('User');

                $rootScope.$on("$routeChangeStart", function (event, next) {

                    // Show page only if content loaded correctly
                    $rootScope.page_content_loaded = false;

                    // Renew messages list for each page
                    $rootScope.error = '';
                    $rootScope.success = '';

                    // Authentication redirects
                    if ($rootScope.token == null && next.controller != 'AuthController') {
                        $location.path("/signin");
                    }
                    if ($rootScope.token != null && next.controller == 'AuthController') {
                        $location.path("/");
                    }

                });
            }]);
})();