var blogApp = angular.module('blogApp', [
    'ngRoute',
    'blogControllers'
]);

blogApp.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
    
    $locationProvider.html5Mode(true); // pretty urls

    // routes
    $routeProvider.
        when('/', {
            templateUrl: 'html/pages/home.html',
            controller: 'NavCtrl'
        }).
        when('/blog', {
            templateUrl: 'html/pages/blog.html',
            controller: 'BlogCtrl'
        }).
        when('/blog/:post', {
            templateUrl: 'html/pages/blog-post.html',
            controller: 'BlogCtrl'
        }).
        when('/projects', {
            templateUrl: 'html/pages/projects.html',
            controller: 'NavCtrl'
        }).
        when('/contact', {
            templateUrl: 'html/pages/contact.html',
            controller: 'NavCtrl'
        }).
        when('/login', {
            templateUrl: 'html/pages/login-form.html',
            controller: 'LoginCtrl'
        }).

        when('/admin', {
            templateUrl: 'html/admin/admin-panel.html',
            controller: 'AdminCtrl'
        }).

        otherwise({
            redirectTo: '/'
        });
}]);

blogApp.factory('User', ['$resource', function($resource){
    return function name(){
        
    };
}]);