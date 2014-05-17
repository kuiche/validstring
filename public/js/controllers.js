var blogServices = angular.module('blogServices', ['ngResource']).
value('APIRoutes', {
    "loginstatus" : "api/v1/loginstatus",
    "login" : "api/v1/login",
    "logout" : "api/v1/logout",
    "blog" : "api/v1/blog"
});;

blogServices.factory('Auth', ['$resource', '$http', '$q', 'APIRoutes', function($resource, $http, $q, APIRoutes){
	var user;
	var err;

	$http({url: APIRoutes.loginstatus, method: "GET"}).
	success(function (data, status, headers, config) {
		if (data.status)
			user = data.user;

		console.log(data);
	});

	return {
		setErr: function(seterr) {
			err = seterr;
		},
		getErr: function(){
			return err;
		},
		setUser: function(setusr) {
			user = setusr;
		},
		checkStatus: function() {
			var deferred = $q.defer();

			$http({url: APIRoutes.loginstatus, method: "GET"}).
			success(function (data, status, headers, config) {
				if (data.status){
					user = data.user;
				}

				deferred.resolve(data);
			}).error(function (data, status, headers, config){
				deferred.reject(data);
			});
			return deferred.promise;
		},
		state: function() {
			return (user ? user : false);
		},
		login: function(uname, pwd) {
			var deferred = $q.defer();

			$http({
				url: APIRoutes.login,
				method: "POST",
				data: {
					username: uname, 
					password: pwd
				}
			}).success(function (data, status, headers, config) {
				user = data;
				deferred.resolve(data);
			});

			return deferred.promise;
		},
		logout: function() {
			$http({
				url: APIRoutes.logout,
				method: "GET",
			}).success(function (data, status, headers, config) {
				user = false;
			});
		}
	};
}]);

blogServices.factory('Page', [function(){
	var title;
	return {
		setTitle: function(t) {title = t;},
		getTitle: function() {return title;}
	};
}]);

blogServices.factory('BlogPost', ['$resource', 'APIRoutes', function($resource, APIRoutes){
	return $resource(APIRoutes.blog+'/:postid', null, {
			'update': {method: 'PUT' },
			'create': {method: 'POST'},
			'index':  {method:'GET', isArray:true}
		});
}]);

var blogControllers = angular.module('blogControllers', ['blogServices']);

blogControllers.controller('NavCtrl', ['$scope', '$location', 'Page', function($scope, $location, Page){
	$scope.title = Page.getTitle();
	$scope.isActivePage = function (viewLocation) { 
        return viewLocation === $location.path();
    };
}]);

blogControllers.controller('LoginCtrl', ['$scope', '$location', 'Auth', function($scope, $location, Auth){
	$scope.errors = null;
	$scope.login = function(){
		var loginpromise = Auth.login($scope.formData.username, $scope.formData.password);
		
		loginpromise.then(function(goodresult){
			$location.path("/admin");
		}, function(badresult){
			$scope.errors = "ERROR OCCOURED";
		});
	};

	$scope.hasErrors = function() {
		return ($scope.errors);
	};
}]);

blogControllers.controller('AdminCtrl', ['$scope', '$location', 'Auth', 'BlogPost', 'APIRoutes', function($scope, $location, Auth, BlogPost, APIRoutes){
	
	var authpromise = Auth.checkStatus();
	authpromise.then(function(data){
		if(!data.status){
			Auth.setErr(true);
			$location.path('/login');
		}
	}, function(fail) {
		Auth.setErr(true);
		$location.path('/login');
	});

	$scope.blogposts = BlogPost.query();

	$scope.editBlogPost = function(id) {
		var post = $.grep($scope.blogposts, function(e){return e.id == id})[0];

		$scope.postform = {
			'title': post.title,
			'keywords': post['meta-keywords'],
			'body': post.body,
			'id': post.id
		};

		$('#post-form').modal('show');
	};

	$scope.deleteBlogPost = function(id){
		var post = $.grep($scope.blogposts, function(e){return e.id == id})[0];
		var idx = $scope.blogposts.indexOf(post);
		BlogPost.delete({postid: id});

		$scope.blogposts.splice(idx, 1);
	};

	$scope.addBlogPost = function(){
		$scope.postform = null;
	};
	$scope.submitBlogPostForm = function () {
		if ($scope.postform.id) {
			var post = $.grep($scope.blogposts, function(e){return e.id == $scope.postform.id})[0];

			post.title = $scope.postform.title;
			post['meta-keywords'] = $scope.postform.keywords;
			post.body = $scope.postform.body;

			BlogPost.update({postid:$scope.postform.id}, post);

		} else {
			var post = {
				'title' : $scope.postform.title,
				'meta-keywords' : $scope.postform.keywords,
				'body' : $scope.postform.body
			};

			BlogPost.create(post);
			$scope.blogposts.push(post);
		}
		$('#post-form').modal('hide');
		$scope.postform = null;
	};

	$scope.blogsort = "created_at";
	$scope.blogreverse = true;
}]);

blogControllers.controller('BlogCtrl', ['$scope', 'Page', 'BlogPost', '$location',  function($scope, Page, BlogPost, $location){
	$scope.blogposts = BlogPost.query()
	$scope.blogsort = "created_at";
	$scope.blogreverse = true;
}]);