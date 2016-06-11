(function () {
    'use strict';

    angular.module('app')
        .factory('User', ['appConfig', '$http', '$rootScope',
            function (appConfig, $http, $rootScope) {

                // Toggles user update window.
                // Can be called from every page, hence should be global
                $rootScope.cur_user_update_show = false;
                $rootScope.updating_user = $rootScope.current_user;
                $rootScope.updateCurUserFormToggle = function (user) {
                    $rootScope.updating_user = user;
                    $rootScope.cur_user_update_show = !$rootScope.cur_user_update_show;
                    $rootScope.modal_back_show = !$rootScope.modal_back_show;
                };

                return {
                    getUser: function (user_id, success) {
                        $http.get(appConfig.apiUrl + 'users/' + user_id)
                            .success(success)
                            .error($rootScope.errorsFromRequest);
                    },
                    getAllUsers: function (data, success) {
                        $http({
                            method: 'GET',
                            url: appConfig.apiUrl + 'users',
                            params: data
                        }).then(success, $rootScope.errorsFromRequest);
                    },
                    createUser: function (data, success) {
                        $http.post(appConfig.apiUrl + 'users', data)
                            .success(success)
                            .error($rootScope.errorsFromRequest);
                    },
                    updateUser: function (user_id, data, success) {
                        data['_method'] = 'PUT';
                        $http.post(appConfig.apiUrl + 'users/' + user_id, data)
                            .success(success)
                            .error($rootScope.errorsFromRequest);
                    },
                    deleteUser: function (user_id, data, success) {
                        data['_method'] = 'DELETE';
                        $http.post(appConfig.apiUrl + 'users/' + user_id, data)
                            .success(success)
                            .error($rootScope.errorsFromRequest);
                    },
                    chUserPass: function (user_id, data, success) {
                        data['_method'] = 'PUT';
                        $http.post(appConfig.apiUrl + 'users/change_password/' + user_id, data)
                            .success(success)
                            .error($rootScope.errorsFromRequest);
                    }
                };
            }
        ]);
})();