(function () {
    'use strict';

    /**
     * Special service for $rootScope (global) functions and variables
     * Also contains custom directives
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

    /**
     * creates bootstrap validation classes if an input is invalid
     * should be applied to form groups
     * (e.g. <div class="form-group" show-errors>... )
     */
    angular.module('app').directive('showErrors', function () {
        return {
            restrict: 'A',
            require: '^form',
            link: function (scope, el, attrs, formCtrl) {
                // find the text box element, which has the 'name' attribute
                var inputEl = el[0].querySelector("[name]");
                // convert the native text box element to an angular element
                var inputNgEl = angular.element(inputEl);
                // get the name on the text box so we know the property to check
                // on the form controller
                var inputName = inputNgEl.attr('name');

                // only apply the has-error class after the user leaves the text box
                inputNgEl.bind('blur', function () {
                    el.toggleClass('has-error', formCtrl[inputName].$invalid);
                });

                scope.$on('show-errors-check-validity', function () {
                    el.toggleClass('has-error', formCtrl[inputName].$invalid);
                });
            }
        }
    });
})();
