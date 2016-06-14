(function () {
    'use strict';

    angular.module('app')
        .factory('User', ['$route', 'appConfig', '$http', '$rootScope', 'Auth',
            function ($route, appConfig, $http, $rootScope, Auth) {

                /**
                 * Returns a copy of provided user
                 */
                function clone(user) {
                    if (!user) return null;

                    var new_user = {};
                    new_user.id = user.id;
                    new_user.name = user.name;
                    new_user.calories_per_day = user.calories_per_day;
                    new_user.email = user.email;
                    new_user.roles = user.roles;
                    new_user.password = user.password; // passed only when creating a new user
                    new_user.is_admin = user.is_admin;
                    new_user.is_manager = user.is_manager;

                    return new_user;
                }

                /**
                 * Creates an array of Role IDs from an array of Role JSON objects
                 */
                function prepareRolesDataForAPI(data) {
                    // Common user can not change even own roles. Just delete roles key
                    if (!$rootScope.userHasRole($rootScope.current_user, appConfig.adminRoleID)
                        && !$rootScope.userHasRole($rootScope.current_user, appConfig.managerRoleID)
                    ) {
                        delete data.roles;
                        return data;
                    }

                    var new_roles = [];
                    if (data.is_admin) new_roles.push(appConfig.adminRoleID);
                    if (data.is_manager) new_roles.push(appConfig.managerRoleID);
                    data.roles = new_roles;

                    return data;
                }

                /**
                 * Checks whether user object contains role with specific ID
                 */
                $rootScope.userHasRole = function (user, role_id) {
                    if (!user) return false;

                    for (var num in user.roles) {
                        if (user.roles[num].id == role_id) return true;
                    }

                    return false;
                };

                /**
                 * returns array of IDs of all user roles
                 */
                $rootScope.userGetRoles = function (user) {
                    if (!user) return false;
                    var roles = [];
                    for (var num in user.roles) {
                        roles.push(user.roles[num].id);
                    }

                    return roles;
                };


                /**
                 * =============================================================
                 *
                 * Rest API CRUD functions
                 *
                 * =============================================================
                 */

                function getUser(user_id, success) {
                    $http.get(appConfig.apiUrl + 'users/' + user_id)
                        .success(success)
                        .error($rootScope.errorsFromRequest);
                }

                function getAll(data, success) {
                    $http({
                        method: 'GET',
                        url: appConfig.apiUrl + 'users',
                        params: data
                    }).then(success, $rootScope.errorsFromRequest);
                }

                function create(data, success, error) {
                    data.roles = [];
                    data = prepareRolesDataForAPI(data);
                    $http.post(appConfig.apiUrl + 'users', data)
                        .success(success)
                        .error(error);
                }

                function update(data, success, error) {
                    data['_method'] = 'PUT';
                    data = prepareRolesDataForAPI(data);
                    $http.post(appConfig.apiUrl + 'users/' + data.id, data)
                        .success(success)
                        .error(error);
                }

                function del(user_id, success) {
                    $http.post(appConfig.apiUrl + 'users/' + user_id, {'_method': 'DELETE'})
                        .success(success)
                        .error($rootScope.errorsFromRequest);
                }

                function chPass(user_id, data, success, error) {
                    data['_method'] = 'PUT';
                    $http.post(appConfig.apiUrl + 'users/change_password/' + user_id, data)
                        .success(success)
                        .error(error);
                }

                /**
                 * =============================================================
                 *
                 * CREATE and UPDATE user global methods
                 *
                 * These functions should be used in views (HTML-templates)
                 * to open user editing modal window and
                 * to process form submissions
                 *
                 * =============================================================
                 */

                /**
                 * Toggles user update window.
                 * Can be called from every page, hence should be global
                 */
                $rootScope.updateCurUserFormToggle = function (user) {
                    $rootScope.modalUserFormSuccess = '';
                    $rootScope.modalUserFormErrors = '';
                    $rootScope.modalPasswordFormSuccess = '';
                    $rootScope.modalPasswordFormErrors = '';

                    if (!user || !user.id) {
                        $rootScope.updating_user = null;
                        $rootScope.cur_user_update_show = !$rootScope.cur_user_update_show;
                        $rootScope.modal_back_show = !$rootScope.modal_back_show;
                        return;
                    }

                    getUser(user.id, function (response) {
                        $rootScope.updating_user = response.data;
                        $rootScope.updating_user.is_admin = $rootScope.userHasRole(response.data, appConfig.adminRoleID);
                        $rootScope.updating_user.is_manager = $rootScope.userHasRole(response.data, appConfig.managerRoleID);
                        $rootScope.cur_user_update_show = !$rootScope.cur_user_update_show;
                        $rootScope.modal_back_show = !$rootScope.modal_back_show;
                    });
                };

                /**
                 * Creates or updates user, retrieving info from
                 * user editing modal window
                 */
                $rootScope.updateOrCreateUser = function () {
                    // frontend validation
                    $rootScope.modalUserFormSuccess = '';
                    $rootScope.modalUserFormErrors = '';
                    $rootScope.$broadcast('show-errors-check-validity');
                    if ($rootScope.modalUserForm.$invalid) {
                        return;
                    }

                    // Choose action (create or update a meal)
                    var action = create;
                    if ($rootScope.updating_user.id > 0) {
                        action = update;
                    }

                    // request to API
                    action(clone($rootScope.updating_user), function (response) {
                        // if user ID matches with current user or meals owner, update them too
                        if (response.data.id == $rootScope.current_user.id)
                            Auth.updateCurrentUser(response.data);
                        if ($rootScope.meals_owner && response.data.id == $rootScope.meals_owner.id)
                            $rootScope.meals_owner = response.data;

                        // if action was update, show message. If create - show message and clear form
                        if (action === update)
                            $rootScope.modalUserFormSuccess = 'Information successfully updated';
                        else {
                            $rootScope.modalUserFormSuccess = 'User successfully created';
                            $rootScope.updating_user = null;
                        }

                        // if current page is user list, update this list
                        if ($route.current && $route.current.templateUrl == 'partials/users.html') {
                            $rootScope.getUsers();
                        }

                    }, function (response) {
                        $rootScope.modalUserFormErrors = response.error.errors.join('\n');
                    });
                };

                /**
                 * Changes user password, retrieving info from
                 * user editing modal window
                 */
                $rootScope.changeUserPassword = function () {
                    $rootScope.modalPasswordFormSuccess = '';
                    $rootScope.modalPasswordFormErrors = '';

                    if ($rootScope.updating_user.id <= 0) return;

                    chPass($rootScope.updating_user.id, {'password': $rootScope.change_password_input},
                        function () {
                            $rootScope.modalPasswordFormSuccess = 'Password successfully changed';
                        }, function (response) {
                            $rootScope.modalPasswordFormErrors = response.error.errors.join('\n');
                        });
                };

                return {
                    getUser: getUser,
                    getAll: getAll,
                    create: create,
                    update: update,
                    del: del,
                    chPass: chPass,
                    clone: clone
                };
            }
        ]);
})();