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
     data-ng-controller="HomeController">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Toptal screening app</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li data-ng-hide="token"><a ng-href="/signin">Signin</a></li>
                <li data-ng-hide="token"><a ng-href="/signup">Signup</a></li>
                <li data-ng-show="token"><a ng-href="/" ng-click="logout()">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container" ng-view=""></div>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ elixir('js/all.js') }}"></script>
</body>
</html>