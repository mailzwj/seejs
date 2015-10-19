<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Seejs Bolg v1.0</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/article.css">
</head>
<body>
<div class="menubar">
    <a href="index.php" target="_self" class="logo">
        &#xe864;
    </a>
    <p class="site-name">
        SEEJS
    </p>
    <div class="menus">
        <ul class="menu-list">
            <li class="menu">
                <a href="index.php" class="menu-url">
                    Home <span class="icons icon-chevron18"></span>
                </a>
            </li>
            <li class="menu">
                <a href="index.php" class="menu-url">
                    Archive <span class="icons icon-chevron18"></span>
                </a>
            </li>
            <li class="menu">
                <a href="index.php" class="menu-url">
                    Works <span class="icons icon-chevron18"></span>
                </a>
            </li>
            <li class="menu">
                <a href="index.php" class="menu-url">
                    Messages <span class="icons icon-chevron18"></span>
                </a>
            </li>
            <li class="menu">
                <a href="index.php" class="menu-url">
                    About <span class="icons icon-chevron18"></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="other-link">
        <a href="http://github.com/mailzwj" target="_blank" class="link">
            <span class="icon-github11"></span>
            <span class="link-name">mailzwj</span>
        </a>
        <a href="http://weibo.com/ys800" target="_blank" class="link">
            <span class="icon-weibo"></span>
            <span class="link-name">OAuth_v2</span>
        </a>
        <a href="#" target="_blank" class="link">
            <span class="icon-speech59"></span>
            <span class="link-name">无痕</span>
        </a>
    </div>
</div>
<div class="sidebar">
    <!-- 敬请期待... -->
</div>
<div class="wrap">
    <div class="article-wrap">
        <h1 class="art-title">
            Make your single page apps work with screen readers
        </h1>
        <div class="content">
            <h2>Patrick Fox considers ways you can indicate view changes on your single-page app to screen readers.</h2>
            <p>Single-page apps pose a significant accessibility challenge when it comes to communicating view changes. Without a page refresh, screen readers do not pick up these important UI changes, leaving vision-impaired users confused and unaware.</p>
            <p>One solution is to create a message based on the page title, and leverage an <a href="#" target="_blank">ARIA</a> live region to explicitly announce, via a helpful message, that a new view has loaded. First create a function that is called when viewContent is updated. AngularJS provides a $viewContentLoaded event for this purpose. In the controller code, listen for the event and call a function (in CoffeeScript):</p>
            <p>app.controller 'PageController', ($scope, $location, $http) -><br>$scope.$on '$viewContentLoaded', announce_view_loaded<br>In the announce_view_loaded function, update the page title and announce the message. While single-page frameworks do not automatically update page titles, keeping the page title synced with the current view improves users’ understanding of the view.</p>
            <p>
                <img src="assets/image/pict.png">
            </p>
            <h2>Patrick Fox considers ways you can indicate view changes on your single-page app to screen readers.</h2>
            <p>Single-page apps pose a significant accessibility challenge when it comes to communicating view changes. Without a page refresh, screen readers do not pick up these important UI changes, leaving vision-impaired users confused and unaware.</p>
            <p>One solution is to create a message based on the page title, and leverage an <a href="#" target="_blank">ARIA</a> live region to explicitly announce, via a helpful message, that a new view has loaded. First create a function that is called when viewContent is updated. AngularJS provides a $viewContentLoaded event for this purpose. In the controller code, listen for the event and call a function (in CoffeeScript):</p>
            <p>app.controller 'PageController', ($scope, $location, $http) -><br>$scope.$on '$viewContentLoaded', announce_view_loaded<br>In the announce_view_loaded function, update the page title and announce the message. While single-page frameworks do not automatically update page titles, keeping the page title synced with the current view improves users’ understanding of the view.</p>
        </div>
        <div class="art-foot">
            <div class="art-info">
                <span class="pub-date">
                    <span class="icons icon-calendar52"></span>&nbsp;2015/10/10
                </span>
                <span class="art-cate">
                    <span class="icons icon-four29"></span>&nbsp;前端开发
                </span>
                <a href="#" class="art-praise">
                    <span class="icons icon-thumbs26"></span>&nbsp;(29)
                </a>
            </div>
            <div class="reprint">
                转载请注明原文来自<a href="index.php" target="_self">SEEJS</a>的：<a href="#" target="_self">《Make your single page apps work with screen readers》</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
