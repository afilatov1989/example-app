<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head;
    any other head content must come *after* these tags -->

    <base href="/">
    <title>Toptal screening app</title>

    <!-- Bootstrap -->
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/js/ie9.min.js"></script>
    <![endif]-->
</head>
<body ng-app="app">
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
                        data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div ng-cloak data-ng-hide="token" class="navbar-collapse collapse">
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
                    <button type="button" class="close" ng-click="error = ''">
                        &times;
                    </button>
                    <span ng-bind="error"></span>
                </div>
            </div>
        </div>
        <div data-ng-show="success" ng-cloak class="col-lg-6 col-lg-offset-3">
            <div class="bs-component">
                <div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" ng-click="success = ''">
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

MODAL WINDOW FOR UPDATING CURRENT USER

**************************************************************************** -->

<div data-ng-controller="AuthController">
    <div ng-cloak data-ng-show="cur_user_update_show" class="modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            aria-hidden="true"
                            ng-click="updateCurUserFormToggle()">&times;</button>
                    <h4 class="modal-title">Account settings</h4>
                </div>
                <div class="modal-body">
                    <p ng-bind="updating_user.name"></p>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-default"
                            ng-click="updateCurUserFormToggle()">
                        Cancel
                    </button>
                    <button type="button"
                            class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div ng-cloak data-ng-show="modal_back_show" class="modal-backdrop fade in">
    </div>
</div>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ elixir('js/all.js') }}"></script>
</body>
</html>