(function () {
    'use strict';

    angular.module('app')
        .factory('Auth', ['$location', '$rootScope', 'appConfig', '$http', '$localStorage',
            function ($location, $rootScope, appConfig, $http, $localStorage) {

                function urlBase64Decode(str) {
                    var output = str.replace('-', '+').replace('_', '/');
                    switch (output.length % 4) {
                        case 0:
                            break;
                        case 2:
                            output += '==';
                            break;
                        case 3:
                            output += '=';
                            break;
                        default:
                            throw 'Illegal base64url string!';
                    }
                    return window.atob(output);
                }

                function saveToken(token) {
                    $localStorage.token = token;
                    $localStorage.$save();
                    $rootScope.token = token;
                    $rootScope.tokenClaims = getTokenClaims();
                }

                function deleteToken() {
                    delete $localStorage.token;
                    $localStorage.$save();
                    $rootScope.token = null;
                    $rootScope.tokenClaims = null;
                }

                function saveUser(user) {
                    $localStorage.current_user = user;
                    $localStorage.$save();
                    $rootScope.current_user = user;
                }

                function deleteUser() {
                    delete $localStorage.current_user;
                    $localStorage.$save();
                    $rootScope.current_user = null;
                }

                function getTokenClaims() {
                    var token = $localStorage.token;
                    var user = {};
                    if (typeof token === 'string') {
                        var encoded = token.split('.')[1];
                        user = JSON.parse(urlBase64Decode(encoded));
                    }
                    return user;
                }

                return {
                    signup: function (data) {
                        $http.post(appConfig.apiUrl + 'signup', data)
                            .success(function (response) {
                                saveToken(response.data.token);
                                saveUser(response.data.user);
                                $location.path("/");
                            })
                            .error($rootScope.errorsFromRequest);
                    },
                    signin: function (data) {
                        $http.post(appConfig.apiUrl + 'signin', data)
                            .success(function (response) {
                                saveToken(response.data.token);
                                saveUser(response.data.user);
                                $location.path("/");
                            })
                            .error($rootScope.errorsFromRequest);
                    },
                    logout: function () {
                        deleteToken();
                        deleteUser();
                        $location.path("/signin");
                    },
                    loadTokenToRootScope: function () {
                        $rootScope.token = $localStorage.token;
                        $rootScope.tokenClaims = getTokenClaims();
                    },
                    loadUserToRootScope: function () {
                        $rootScope.current_user = $localStorage.current_user;
                    }
                };
            }
        ]);
})();