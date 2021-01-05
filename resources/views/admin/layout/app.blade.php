<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>@yield('title')</title>
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		@if(env('APP_ENV') == "production")
		<!-- start Mixpanel -->
		<script type="text/javascript">(function(e,a){if(!a.__SV){var b=window;try{var c,l,i,j=b.location,g=j.hash;c=function(a,b){return(l=a.match(RegExp(b+"=([^&]*)")))?l[1]:null};g&&c(g,"state")&&(i=JSON.parse(decodeURIComponent(c(g,"state"))),"mpeditor"===i.action&&(b.sessionStorage.setItem("_mpcehash",g),history.replaceState(i.desiredHash||"",e.title,j.pathname+j.search)))}catch(m){}var k,h;window.mixpanel=a;a._i=[];a.init=function(b,c,f){function e(b,a){var c=a.split(".");2==c.length&&(b=b[c[0]],a=c[1]);b[a]=function(){b.push([a].concat(Array.prototype.slice.call(arguments,
		0)))}}var d=a;"undefined"!==typeof f?d=a[f]=[]:f="mixpanel";d.people=d.people||[];d.toString=function(b){var a="mixpanel";"mixpanel"!==f&&(a+="."+f);b||(a+=" (stub)");return a};d.people.toString=function(){return d.toString(1)+".people (stub)"};k="disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset opt_in_tracking opt_out_tracking has_opted_in_tracking has_opted_out_tracking clear_opt_in_out_tracking people.set people.set_once people.unset people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
		for(h=0;h<k.length;h++)e(d,k[h]);a._i.push([b,c,f])};a.__SV=1.2;b=e.createElement("script");b.type="text/javascript";b.async=!0;b.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===e.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";c=e.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c)}})(document,window.mixpanel||[]);
		mixpanel.init("fb524507ebb7cd3bc8c139af1cf06089");</script>
		<!-- end Mixpanel -->
		@endif
		<link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
		@stack('styles')
	</head>
	<body>
        <div id="loader">
            <div class="loader"></div>
        </div>
		<div style="background-color: #62cb31;height: 3px;width: 100%;position: fixed;top: 0;z-index: 99999;">&nbsp;&nbsp;</div>
		@include('admin.partials.main-menu')
		@stack('moduleTitle')
		<main>
			@include('admin.partials.navbar')
            <div id="app" class="container" style="margin-top: 25px;">
                @yield('content')
			</div>
		</main>
        @stack('modals')
        @if(env('APP_ENV') == 'production')
            <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.min.js"></script>
        @else
            <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
        @endif
		<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
        <script>
            var beamer_config = {
                product_id : 'ZPXaeSWQ4574', //DO NOT CHANGE: This is your product code on Beamer
                selector: 'notification',
                top: 6,
                right: 2
            };
        </script>
        <script type="text/javascript" src="https://app.getbeamer.com/js/beamer-embed.js" defer="defer"></script>
		<script src="{{ asset('admin/js/leyenda.js') }}"></script>
		@stack('scripts')
		@if(env('APP_ENV') == "production")
            <script>
                var id = '{{ auth()->user()->id }}';
                var email = '{{ auth()->user()->email }}';
                var businessName = '{{ (!is_null(auth()->user()->dbConfig->shop)) ? auth()->user()->dbConfig->shop->shopname : ' ' }}';

                mixpanel.track("@yield('title')", {
                    '$email': email,
                    '$empresa': businessName
                });
            </script>
            <script>
                window.intercomSettings = {
                    app_id: "uujoat67",
                    email: "<?php echo auth_user()->email; ?>",
                    user_hash: "<?php echo hash_hmac('sha256', auth_user()->email, 'CBs9NOXwqrj_OASr9K3Se2OpPEdEmPHTDunTsH6Y'); ?>",
                    nombre_empresa: "<?php echo option('nombre_empresa') ?>",
                    tipo_empresa: "<?php echo option('tipo_negocio') ?>",
                };

                (function() {
                    var w = window;
                    var ic = w.Intercom;
                    if (typeof ic === "function") {
                        ic("reattach_activator");
                        ic("update", intercomSettings);
                    } else {
                        var d = document;
                        var i = function() {
                            i.c(arguments);
                        };
                        i.q = [];
                        i.c = function(args) {
                            i.q.push(args);
                        };
                        w.Intercom = i;
                        function l() {
                            var s = d.createElement("script");
                            s.type = "text/javascript";
                            s.async = true;
                            s.src = "https://widget.intercom.io/widget/uujoat67";
                            var x = d.getElementsByTagName("script")[0];
                            x.parentNode.insertBefore(s, x);
                        }
                        if (w.attachEvent) {
                            w.attachEvent("onload", l);
                        } else {
                            w.addEventListener("load", l, false);
                        }
                    }
                })();
            </script>
            <script>
                (function(h,o,t,j,a,r){
                    h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                    h._hjSettings={hjid:1806590,hjsv:6};
                    a=o.getElementsByTagName('head')[0];
                    r=o.createElement('script');r.async=1;
                    r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                    a.appendChild(r);
                })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
            </script>

            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-TLVSFX');
            </script>
            <!-- End Google Tag Manager -->

            <!-- Google Tag Manager (noscript) -->
            <noscript>
                <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TLVSFX" height="0" width="0" style="display:none;visibility:hidden"></iframe>
            </noscript>
            <!-- End Google Tag Manager (noscript) -->
        @endif
	</body>
</html>
