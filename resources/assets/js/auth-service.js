(function () {
    'use strict';

    angular.module('app')
        .factory('Auth', ['appConfig', '$http', '$localStorage', function (appConfig, $http, $localStorage) {
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

            return {
                signup: function (data, success, error) {
                    $http.post(appConfig.apiUrl + 'signup', data).success(success).error(error);
                },
                signin: function (data, success, error) {
                    $http.post(appConfig.apiUrl + 'signin', data).success(success).error(error);
                },
                logout: function (success) {
                    delete $localStorage.token;
                    $localStorage.$save();
                    success();
                },
                getTokenClaims: function () {
                    var token = $localStorage.token;
                    var user = {};
                    if (typeof token !== 'undefined') {
                        var encoded = token.split('.')[1];
                        user = JSON.parse(urlBase64Decode(encoded));
                    }
                    return user;
                }
            };
        }
        ]);
})();