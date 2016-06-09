(function () {
    'use strict';

    angular.module('app', [
            'ngStorage',
            'ngRoute',
            'angular-loading-bar'
        ])
        .config(['$routeProvider', '$httpProvider', '$locationProvider',
            function ($routeProvider, $httpProvider, $locationProvider) {
                $routeProvider.when('/', {
                    templateUrl: 'partials/home.html',
                    controller: 'HomeController'
                }).when('/signin', {
                    templateUrl: 'partials/signin.html',
                    controller: 'HomeController'
                }).when('/signup', {
                    templateUrl: 'partials/signup.html',
                    controller: 'HomeController'
                }).otherwise({
                    redirectTo: '/'
                });

                $locationProvider.html5Mode(true);

                $httpProvider.interceptors.push(['$q', '$location', '$localStorage', function ($q, $location, $localStorage) {
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
                                $location.path('/signin');
                            }
                            return $q.reject(response);
                        }
                    };
                }]);
            }
        ]).run(['$rootScope', '$location', '$localStorage', function ($rootScope, $location, $localStorage) {
        $rootScope.$on("$routeChangeStart", function (event, next) {
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