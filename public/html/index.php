<html ng-app="blogApp">
<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <link rel="stylesheet" href="/packages/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <script src="/packages/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="/packages/bower_components/angular/angular.js"></script>
    <script src="/packages/bower_components/angular-route/angular-route.js"></script>
    <script src="/packages/bower_components/angular-resource/angular-resource.js"></script>
    
    <script src="/js/controllers.js"></script>
    <script src="/js/app.js"></script>
    <base href="/" />
</head>
<body>
    <header class="navbar navbar-default navbar-static-top" ng-controller="NavCtrl">
        <div class="container">
            
            <div class="navbar-header">

                 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-kch">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>

                <div class="navbar-brand">TODO: witty title</div>
                <!-- bread? -->
            </div>

            <nav class="collapse navbar-collapse" id="navbar-collapse-kch">
                <ul class="nav nav-pills navbar-nav navbar-right">
                    <li ng-class="{'active': isActivePage('/')}"><a href="#/" class="navbar-lnk-kch" id="home-lnk">Home</a></li>
                    <li ng-class="{'active': isActivePage('/blog')}"><a href="#/blog" class="navbar-lnk-kch" id="blog-lnk">Blog</a></li>
                    <li ng-class="{'active': isActivePage('/projects')}"><a href="#/projects" class="navbar-lnk-kch" id="projects-lnk">Projects</a></li>
                    <li ng-class="{'active': isActivePage('/contact')}"><a href="#/contact" class="navbar-lnk-kch" id="contact-lnk">Contact</a></li>
                    <li ng-class="{'active': isActivePage('/admin')}"><a href="#/admin" class="navbar-lnk-kch" id="contact-lnk">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-md-9 col-sm" role="main" ng-view>
                
            </div>
            <div role="complementary" class="col-md-3 nav-twit-kch hidden-sm hidden-xs">
                <a class="twitter-timeline" href="https://twitter.com/Kuiche" data-widget-id="455057431190462464">Tweets by @Kuiche</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

            </div>
        </div>
    </div>
</body>
</html>