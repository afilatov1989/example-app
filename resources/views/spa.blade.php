@extends('layout')

@section('content')
    <body ng-class="modal_back_show ? 'modal-open' : ''" ng-app="app">
    <div class="navbar navbar-default navbar-fixed-top" role="navigation"
         data-ng-controller="AuthController">
        <div class="container">
            <div class="col-lg-10 col-lg-offset-1">
                <div ng-cloak data-ng-show="token"
                     class="navbar-right nav-username navbar-text cursor"
                     data-toggle="dropdown"
                     data-target=".user-dropdown">
                    <i class="fa fa-user"></i>
                    <span ng-bind="current_user.name"></span>
                    <b class="caret"></b>
                </div>
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">Toptal screening app</a>
                    <button ng-cloak data-ng-hide="token"
                            type="button" class="navbar-toggle collapsed"
                            data-toggle="collapse"
                            data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div ng-cloak data-ng-hide="token"
                     class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li ng-cloak data-ng-hide="token"><a ng-href="/signin">Signin</a>
                        </li>
                        <li ng-cloak data-ng-hide="token"><a ng-href="/signup">Signup</a>
                        </li>
                    </ul>
                </div>
                <ul ng-cloak data-ng-show="token"
                    class="nav navbar-nav navbar-user navbar-right">
                    <li class="dropdown user-dropdown">

                        <ul class="dropdown-menu">
                            <li>
                                <a ng-click="updateCurUserFormToggle(current_user)"
                                   href="#">
                                    <i class="fa fa-gear"></i> Settings
                                </a>
                            </li>
                            <li data-ng-show="tokenClaims.can_manage_users"
                                class="divider"></li>
                            <li ng-cloak
                                data-ng-show="tokenClaims.can_manage_users">
                                <a ng-href="/users/">
                                    <i class="fa fa-cogs"></i> Manage users
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a ng-href="/" ng-click="logout()">
                                    <i class="fa fa-power-off"></i> Log Out
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div data-ng-show="error" ng-cloak class="col-lg-6 col-lg-offset-3">
                <div class="bs-component">
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close"
                                ng-click="error = ''">
                            &times;
                        </button>
                        <span ng-bind="error"></span>
                    </div>
                </div>
            </div>
            <div data-ng-show="success" ng-cloak
                 class="col-lg-6 col-lg-offset-3">
                <div class="bs-component">
                    <div class="alert alert-dismissible alert-success">
                        <button type="button" class="close"
                                ng-click="success = ''">
                            &times;
                        </button>
                        <span ng-bind="success"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" ng-view=""></div>

    <!-- ***************************************************************************

    MODAL WINDOW FOR UPDATING ANY USER

    **************************************************************************** -->

    <div>
        <div ng-cloak data-ng-show="cur_user_update_show"
             class="modal modal-open fade in">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close_wrapper">
                        <button type="button" class="close"
                                aria-hidden="true"
                                ng-click="updateCurUserFormToggle()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form name="modalUserForm" role="form" novalidate
                              class="form-horizontal">
                            <fieldset>
                                <legend>User information</legend>

                                <input type="hidden" name="id"
                                       ng-model="updating_user.id">

                                <div class="form-group" show-errors>
                                    <label class="col-lg-2 control-label"
                                           for="user_form_name">Name</label>
                                    <div class="col-lg-10">
                                        <input ng-model="updating_user.name"
                                               type="text"
                                               name="user_form_name"
                                               id="user_form_name"
                                               class="form-control"
                                               required>
                                        <p class="help-block"
                                           ng-if="modalUserForm.user_form_name.$error.required">
                                            The name field is required
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group" show-errors>
                                    <label class="col-lg-2 control-label"
                                           for="user_form_email">Email</label>
                                    <div class="col-lg-10">
                                        <input ng-model="updating_user.email"
                                               type="email"
                                               name="user_form_email"
                                               id="user_form_email"
                                               class="form-control"
                                               required>
                                        <p class="help-block"
                                           ng-if="modalUserForm.user_form_email.$error.required">
                                            The email field is required
                                        </p>
                                        <p class="help-block"
                                           ng-if="modalUserForm.user_form_email.$error.email">
                                            Email is invalid
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group" show-errors>
                                    <label class="col-lg-2 control-label"
                                           for="user_form_calories_per_day">
                                        Calories day limit
                                    </label>
                                    <div class="col-lg-10">
                                        <input ng-model="updating_user.calories_per_day"
                                               type="number"
                                               name="user_form_calories_per_day"
                                               id="user_form_calories_per_day"
                                               class="form-control"
                                               required>
                                        <p class="help-block"
                                           ng-if="modalUserForm.user_form_calories_per_day.$error.required">
                                            The name field is required
                                        </p>
                                    </div>
                                </div>

                                <div ng-show="updating_user.id == null"
                                     class="form-group">
                                    <label class="col-lg-2 control-label"
                                           for="user_form_password">Password</label>
                                    <div class="col-lg-10">
                                        <input type="password"
                                               ng-model="updating_user.password"
                                               name="user_form_password"
                                               id="user_form_password"
                                               class="form-control">
                                    </div>
                                </div>

                                <div ng-cloak
                                     ng-show="tokenClaims.can_manage_users"
                                     class="form-group">
                                    <label class="col-lg-2 control-label">Roles</label>
                                    <div class="col-lg-10">
                                        <div class="checkbox">
                                            <label>
                                                <input ng-model="updating_user.is_admin"
                                                       type="checkbox">
                                                Admin
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input ng-model="updating_user.is_manager"
                                                       type="checkbox">
                                                User Manager
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-9 modal-form-message">
                                        <p ng-show="modalUserFormSuccess"
                                           ng-bind="modalUserFormSuccess"
                                           class="text-success">
                                        </p>

                                        <p ng-show="modalUserFormErrors"
                                           ng-bind="modalUserFormErrors"
                                           class="text-danger">
                                        </p>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit"
                                                class="btn btn-primary"
                                                ng-click="updateOrCreateUser()">
                                            Save changes
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <form ng-show="updating_user.id > 0"
                              name="modalPasswordForm" role="form" novalidate
                              class="form-horizontal">
                            <fieldset>
                                <legend>Change password</legend>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label"
                                           for="user_password">Password</label>
                                    <div class="col-lg-10">
                                        <input ng-model="change_password_input"
                                               type="password"
                                               name="user_password"
                                               id="user_password"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-9 modal-form-message">
                                        <p ng-show="modalPasswordFormSuccess"
                                           ng-bind="modalPasswordFormSuccess"
                                           class="text-success">
                                        </p>

                                        <p ng-show="modalPasswordFormErrors"
                                           ng-bind="modalPasswordFormErrors"
                                           class="text-danger">
                                        </p>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit"
                                                class="btn btn-primary"
                                                ng-click="changeUserPassword()">
                                            Save changes
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div ng-cloak data-ng-show="modal_back_show"
         class="modal-backdrop fade in">
    </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ elixir('js/all.js') }}"></script>
    </body>
@endsection
