(function () {
    'use strict';

    /**
     * Special service for $rootScope (global) functions and variables
     *
     * Should never be injected and should return nothing.
     */

    angular.module('app')
        .factory('Globals', ['appConfig', '$http', '$rootScope',
            function (appConfig, $http, $rootScope) {

                /**
                 * Flag for hiding/showing modal window background
                 * All windows should use only this variable for this purpose.
                 */
                $rootScope.modal_back_show = false;

                /**
                 * Error handler for error ajax responses
                 * All queries to API should use only this unified handler.
                 */
                $rootScope.errorsFromRequest = function (response) {
                    if (typeof(response.error) === 'undefined') response = response.data;

                    $rootScope.error = 'Unknown error';
                    if (typeof(response.error.errors) === 'object')
                        $rootScope.error = response.error.errors.join('\n');
                    else if (typeof(response.error.message) === 'string')
                        $rootScope.error = response.error.message;
                };

                /**
                 * Returns date in specified format.
                 * Should be used to show all dates to unify app appearance
                 */
                $rootScope.dateFormat = function (date) {
                    return moment(date).format('Do MMMM YYYY');
                };

                /**
                 * MUST be empty.
                 * Service only for global vars and functions.
                 * Never injected
                 */
                return {};
            }
        ]);
})();
