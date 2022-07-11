<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="utf-8">
    <title><?php echo _("enPunto - TASM"); ?></title>
    <meta name="description" content="TASM">
    <meta name="author" content="enPunto">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- #CSS Links -->
    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="https://static.enpuntocontrol.com/app/v1/css/bootstrap.min.css">
    <link rel="preload" onload="this.onload=null;this.rel='stylesheet'" as="style" media="screen" href="https://static.enpuntocontrol.com/app/v1/css/font-awesome.min.css">
    <link rel="preload" onload="this.onload=null;this.rel='stylesheet'" as="style" media="screen" href="https://static.enpuntocontrol.com/app/v1/css/bootstrap-datetimepicker.min.css">
    <link rel="preload" onload="this.onload=null;this.rel='stylesheet'" as="style" media="screen" href="https://static.enpuntocontrol.com/app/v1/css/smartadmin-production-plugins.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="https://static.enpuntocontrol.com/app/v1/css/smartadmin-production.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="https://static.enpuntocontrol.com/app/v1/css/smartadmin-skins.min.css">
    <link rel="preload" onload="this.onload=null;this.rel='stylesheet'" as="style" media="screen" href="https://static.enpuntocontrol.com/app/v1/css/chosen.min.css"/>
    <link rel="preload" onload="this.onload=null;this.rel='stylesheet'" as="style" media="screen" href="https://static.enpuntocontrol.com/app/v1/css/multi-select.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="https://static.enpuntocontrol.com/app/v1/css/style.css"/>

    <!-- #FAVICONS -->
    <link rel="icon" href="https://static.enpuntocontrol.com/app/v1/img/favicon/favicon.ico" type="image/x-icon">

    <!-- #GOOGLE FONT -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <!-- #APP SCREEN / ICONS -->
    <!-- Specifying a Webpage Icon for Web Clip
         Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="https://static.enpuntocontrol.com/app/v1/img/splash/sptouch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="57x57" href="https://static.enpuntocontrol.com/app/v1/img/splash/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="https://static.enpuntocontrol.com/app/v1/img/splash/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="https://static.enpuntocontrol.com/app/v1/img/splash/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://static.enpuntocontrol.com/app/v1/img/splash/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="https://static.enpuntocontrol.com/app/v1/img/splash/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://static.enpuntocontrol.com/app/v1/img/splash/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="https://static.enpuntocontrol.com/app/v1/img/splash/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://static.enpuntocontrol.com/app/v1/img/splash/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://static.enpuntocontrol.com/app/v1/img/splash/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="https://static.enpuntocontrol.com/app/v1/img/splash/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="https://static.enpuntocontrol.com/app/v1/img/splash/favicon-194x194.png" sizes="194x194">
    <link rel="icon" type="image/png" href="https://static.enpuntocontrol.com/app/v1/img/splash/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="https://static.enpuntocontrol.com/app/v1/img/splash/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="https://static.enpuntocontrol.com/app/v1/img/splash/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="https://static.enpuntocontrol.com/app/v1/img/splash/manifest.json">
    <link rel="mask-icon" href="https://static.enpuntocontrol.com/app/v1/img/splash/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="https://static.enpuntocontrol.com/app/v1/img/splash/mstile-144x144.png">
    <meta name="theme-color" content="#f3f3f3">


    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="https://static.enpuntocontrol.com/app/v1/img/splash/ipad-landscape.png"
          media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="https://static.enpuntocontrol.com/app/v1/img/splash/ipad-portrait.png"
          media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="https://static.enpuntocontrol.com/app/v1/img/splash/iphone.png" media="screen and (max-device-width: 320px)">

<script>
    /*! loadCSS. [c]2017 Filament Group, Inc. MIT License */
    /* This file is meant as a standalone workflow for
    - testing support for link[rel=preload]
    - enabling async CSS loading in browsers that do not support rel=preload
    - applying rel preload css once loaded, whether supported or not.
    */
    (function( w ){
        "use strict";
        // rel=preload support test
        if( !w.loadCSS ){
            w.loadCSS = function(){};
        }
        // define on the loadCSS obj
        var rp = loadCSS.relpreload = {};
        // rel=preload feature support test
        // runs once and returns a function for compat purposes
        rp.support = (function(){
            var ret;
            try {
                ret = w.document.createElement( "link" ).relList.supports( "preload" );
            } catch (e) {
                ret = false;
            }
            return function(){
                return ret;
            };
        })();

        // if preload isn't supported, get an asynchronous load by using a non-matching media attribute
        // then change that media back to its intended value on load
        rp.bindMediaToggle = function( link ){
            // remember existing media attr for ultimate state, or default to 'all'
            var finalMedia = link.media || "all";

            function enableStylesheet(){
                link.media = finalMedia;
            }

            // bind load handlers to enable media
            if( link.addEventListener ){
                link.addEventListener( "load", enableStylesheet );
            } else if( link.attachEvent ){
                link.attachEvent( "onload", enableStylesheet );
            }

            // Set rel and non-applicable media type to start an async request
            // note: timeout allows this to happen async to let rendering continue in IE
            setTimeout(function(){
                link.rel = "stylesheet";
                link.media = "only x";
            });
            // also enable media after 3 seconds,
            // which will catch very old browsers (android 2.x, old firefox) that don't support onload on link
            setTimeout( enableStylesheet, 3000 );
        };

        // loop through link elements in DOM
        rp.poly = function(){
            // double check this to prevent external calls from running
            if( rp.support() ){
                return;
            }
            var links = w.document.getElementsByTagName( "link" );
            for( var i = 0; i < links.length; i++ ){
                var link = links[ i ];
                // qualify links to those with rel=preload and as=style attrs
                if( link.rel === "preload" && link.getAttribute( "as" ) === "style" && !link.getAttribute( "data-loadcss" ) ){
                    // prevent rerunning on link
                    link.setAttribute( "data-loadcss", true );
                    // bind listeners to toggle media back
                    rp.bindMediaToggle( link );
                }
            }
        };

        // if unsupported, run the polyfill
        if( !rp.support() ){
            // run once at least
            rp.poly();

            // rerun poly on an interval until onload
            var run = w.setInterval( rp.poly, 500 );
            if( w.addEventListener ){
                w.addEventListener( "load", function(){
                    rp.poly();
                    w.clearInterval( run );
                } );
            } else if( w.attachEvent ){
                w.attachEvent( "onload", function(){
                    rp.poly();
                    w.clearInterval( run );
                } );
            }
        }


        // commonjs
        if( typeof exports !== "undefined" ){
            exports.loadCSS = loadCSS;
        }
        else {
            w.loadCSS = loadCSS;
        }
    }( typeof global !== "undefined" ? global : this ) );

</script>
</head>


<body class="smart-style-0 fixed-ribbon fixed-header fixed-navigation">

<!-- #HEADER -->
<header id="header">
    <div id="logo-group">

        <span id="logo"> <img src="https://static.enpuntocontrol.com/app/v1/img/logo_flat.png" alt="enPunto - TASM"> </span>

    </div>


    <div class="project-context hidden-xs">

        <!--	<h1>Time Attendance Server Manager</h1> -->

    </div>

    <div class="pull-right">


        <!-- #MOBILE -->
        <!-- Top menu profile link : this shows only when top menu is active -->
        <ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
            <li class="">
                <a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown">
                    <?php
                    if (isset($_SESSION['USUARIO']['id']) && Registry::getInstance()->Usuario->getImagen() == '') {
                        echo '<img src="https://static.enpuntocontrol.com/app/v1/img/avatars/male-big.png" alt="me" class="online" />';
                    } else {
                        echo '<img src="imagen.php?usu_id=' . Registry::getInstance()->Usuario->getId() . '" alt="me" class="online" />';
                    }
                    ?>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i
                                class="fa fa-cog"></i> Setting</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#ajax/profile.html" class="padding-10 padding-top-0 padding-bottom-0"> <i
                                class="fa fa-user"></i> <u>P</u>rofile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"
                           data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"
                           data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="login.html" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i
                                class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- logout button -->
        <div id="logout" class="btn-header transparent pull-right">
            <span> <a href="<?php echo WEB_ROOT; ?>/logout.php" title="Salir"
                      data-logout-msg="Está seguro que desea salir?"><i class="fa fa-sign-out"></i></a> </span>
        </div>
        <!-- end logout button -->

        <!-- collapse menu button -->
        <div id="hide-menu" class="btn-header pull-right">
            <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i
                        class="fa fa-reorder"></i></a> </span>
        </div>
        <!-- end collapse menu -->

        <div id="help" class="btn-header transparent pull-right">
            <span> <a href="soporte.php" target="_blank" onclick="" title="Ayuda"><i
                        class="fa fa-question"></i></a> </span>
        </div>

        <div id="help" class="btn-header transparent pull-right hidden-mobile">
            <span> <a href="soporte.php" target="_blank" onclick="" title="Manual"><i
                        class="fa fa-file-pdf-o"></i></a> </span>
        </div>


        <!-- fullscreen button -->
        <div id="fullscreen" class="btn-header transparent pull-right">
            <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i
                        class="fa fa-arrows-alt"></i></a> </span>
        </div>
        <!-- end fullscreen button -->


        <!-- multiple lang dropdown : find all flags in the flags page -->
        <ul class="header-dropdown-list hidden-xs">
            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img alt=""
                                                                                 src="https://static.enpuntocontrol.com/app/v1/img/flags/ar.png">
                    <span> AR </span> <i class="fa fa-angle-down"></i> </a>
                <ul class="dropdown-menu pull-right">
                    <li class="active">
                        <a href="javascript:void(0);"><img alt="" src="https://static.enpuntocontrol.com/app/v1/img/flags/ar.png"> ES</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><img alt="" src="https://static.enpuntocontrol.com/app/v1/img/flags/us.png"> EN</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><img alt="" src="https://static.enpuntocontrol.com/app/v1/img/flags/de.png"> DE</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- end multiple lang -->

    </div>
    <!-- end pulled right: nav area -->

</header>
<!-- END HEADER -->

<!-- #NAVIGATION -->
<!-- Left panel : Navigation area -->
<aside id="left-panel">

    <!-- User info -->
    <div class="login-info">
				<span>					
					<a href="#">
                        <?php
                        if (isset($_SESSION['USUARIO']['id']) && Registry::getInstance()->Usuario->getImagen() == '') {
                            echo '<img src="https://static.enpuntocontrol.com/app/v1/img/avatars/male-big.png" alt="me" class="online" />';
                        } else {
                            echo '<img src="imagen.php?usu_id=' . Registry::getInstance()->Usuario->getId() . '" alt="me" class="online" />';
                        }
                        ?>

                        <span>
							<strong><?php echo isset($_SESSION['USUARIO']['id']) ? Registry::getInstance()->Usuario->getNombre() . ' ' . Registry::getInstance()->Usuario->getApellido() : _('Anónimo'); ?></strong> 
						</span>

                    </a>
					
				</span>
    </div>
    <!-- end user info -->


    <?php require_once(APP_PATH . '/includes/menu.inc.php'); ?>


    <span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>

</aside>
<!-- END NAVIGATION -->

<!-- #MAIN PANEL -->
<div id="main" role="main">

    <!-- RIBBON -->
    <div id="ribbon" style="display:none;" >

        <!-- breadcrumb -->
        <ol class="breadcrumb">
            <!-- This is auto generated -->
        </ol>
        <!-- end breadcrumb -->
        <?php
        $multiEmpresa = 'display:none;';
        if (Config_L::p('usar_multi_empresa'))
            $multiEmpresa = '';

        ?>
        <div id="selEmpresaDiv" class="widget-toolbar smart-form" style="<?php echo $multiEmpresa; ?>">

            <label class="select"> <span class="icon-prepend fa fa-industry"></span>
                <select name="selEmpresa" id="selEmpresa" style="padding-left: 32px;height: 30px;">
                    <?php echo HtmlHelper::array2htmloptions(Empresa_L::obtenerTodos(), 0, true, true, '', 'Todas Las Empresas'); ?>
                </select> <i style="top: 10px;height: 10px;"></i> </label>

        </div>

    </div>
    <!-- END RIBBON -->

    <!-- #MAIN CONTENT -->
    <div id="content">

    </div>
    <!-- END #MAIN CONTENT -->

</div>
<!-- END #MAIN PANEL -->


<!--================================================== -->


<!-- #PLUGINS -->
<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    if (!window.jQuery) {
        document.write('<script src="https://static.enpuntocontrol.com/app/v1/js/libs/jquery-2.1.1.min.js"><\/script>');
    }
</script>

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
    if (!window.jQuery.ui) {
        document.write('<script src="https://static.enpuntocontrol.com/app/v1/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
    }
</script>

<!-- IMPORTANT: APP CONFIG -->
<script src="https://static.enpuntocontrol.com/app/v1/js/app.config.js"></script>

<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script>

<!-- BOOTSTRAP JS -->
<script src="https://static.enpuntocontrol.com/app/v1/js/bootstrap/bootstrap.min.js"></script>

<!-- CUSTOM NOTIFICATION -->
<script src="https://static.enpuntocontrol.com/app/v1/js/notification/SmartNotification.min.js"></script>

<!-- JARVIS WIDGETS -->
<script src="https://static.enpuntocontrol.com/app/v1/js/smartwidgets/jarvis.widget.min.js"></script>

<!-- EASY PIE CHARTS -->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

<!-- SPARKLINES -->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/sparkline/jquery.sparkline.min.js"></script>

<!-- JQUERY VALIDATE -->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/jquery-validate/jquery.validate.min.js"></script>

<!-- JQUERY MASKED INPUT -->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

<!-- JQUERY SELECT2 INPUT -->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/select2/select2.min.js"></script>

<!-- JQUERY UI + Bootstrap Slider -->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

<!-- browser msie issue fix -->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

<!-- FastClick: For mobile devices: you can disable this in app.js -->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/fastclick/fastclick.min.js"></script>

<!-- aCollaptable -->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/acollaptable/jquery.acollaptable.min.js"></script>

<!--[if IE 8]>
<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
<![endif]-->

<!-- MAIN APP JS FILE -->
<script src="https://static.enpuntocontrol.com/app/v1/js/app.min.js"></script>

<!-- MOMENT -->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/moment/moment.min.js"></script>
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/moment/es.js"></script>
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/moment/moment-timezone-with-data-2012-2022.js"></script>

<!-- SOCKET.IO -->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/socket-io/socket.io.js"></script>

<!-- DATETIME PICKER -->
<script src="https://static.enpuntocontrol.com/app/v1/js/plugin/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
    localStorage.setItem('API_URL', 'https://' + window.location.hostname.split('.')[0] + '.enpuntocontrol.com/api/v2');
    localStorage.setItem('AUTH_TOKEN', '<?php echo $_SESSION['authToken']; ?>');
</script>
<script async src="js/api.js"></script>


<!-- Your GOOGLE ANALYTICS CODE Below -->
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
    _gaq.push(['_trackPageview']);

    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();

</script>

<!-- to prevent backspace effect outside text fields -->
<script type="text/javascript">

    $(document).unbind('keydown').bind('keydown', function (event) {
        if (event.keyCode === 8) {
            var doPrevent = true;
            var types = ["text", "password", "file", "search", "email", "number", "date", "color", "datetime", "datetime-local", "month", "range", "search", "tel", "time", "url", "week"];
            var d = $(event.srcElement || event.target);
            var disabled = d.prop("readonly") || d.prop("disabled");
            if (!disabled) {
                if (d[0].isContentEditable) {
                    doPrevent = false;
                } else if (d.is("input")) {
                    var type = d.attr("type");
                    if (type) {
                        type = type.toLowerCase();
                    }
                    if (types.indexOf(type) > -1) {
                        doPrevent = false;
                    }
                } else if (d.is("textarea")) {
                    doPrevent = false;
                }
            }
            if (doPrevent) {
                event.preventDefault();
                return false;
            }
        }
    });

</script>



</body>

</html>
			
			
			
