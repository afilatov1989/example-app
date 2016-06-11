(function () {
    'use strict';

    angular.module('app')
        .factory('User', ['appConfig', '$http', '$localStorage', function (appConfig, $http, $localStorage) {

            return {
                getUser: function (user_id, success, error) {
                    $http.get(appConfig.apiUrl + 'users/' + user_id).success(success).error(error);
                },
                getAllUsers: function (data, success, error) {
                    $http({
                        method: 'GET',
                        url: appConfig.apiUrl + 'users',
                        params: data
                    }).then(success, error);
                },
                createUser: function (data, success, error) {
                    $http.post(appConfig.apiUrl + 'users', data).success(success).error(error);
                },
                updateUser: function (user_id, data, success, error) {
                    data['_method'] = 'PUT';
                    $http.post(appConfig.apiUrl + 'users/' + user_id, data).success(success).error(error);
                },
                deleteUser: function (user_id, data, success, error) {
                    data['_method'] = 'DELETE';
                    $http.post(appConfig.apiUrl + 'users/' + user_id, data).success(success).error(error);
                },
                chUserPass: function (user_id, data, success, error) {
                    data['_method'] = 'PUT';
                    $http.post(appConfig.apiUrl + 'users/change_password/' + user_id, data)
                        .success(success).error(error);
                }
            };
        }
        ]);
})();