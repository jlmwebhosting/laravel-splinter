<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Splinter &middot; Split Testing for Laravel</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Split Testing library for Laravel">
		<meta name="author" content="Kelly Banman">

		<link href="{{ URL::to_asset('bundles/splinter/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ URL::to_asset('bundles/splinter/css/bootstrap-responsive.min.css') }}" rel="stylesheet">
		<link href="{{ URL::to_asset('bundles/splinter/css/select2.css') }}" rel="stylesheet">
		<link href="{{ URL::to_asset('bundles/splinter/css/font-awesome.css') }}" rel="stylesheet">
		<link href="{{ URL::to_asset('bundles/splinter/css/splinter.css') }}" rel="stylesheet">
		<style>
		
		/* Placeholder */
		#goalGraph {
			width: 200px;
			height: 200px;
			border-radius: 100px;
			background-color: #ccc;
			margin: 20px auto;
		}
		</style>

		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!--[if lt IE 8]>
			<link href="{{ URL::to_asset('bundles/splinter/css/font-awesome-ie7.css') }}" rel="stylesheet">
		<![endif]-->

		<!--
		<link rel="shortcut icon" href="ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
		-->
		<script type="text/javascript">

		var Splinter = {
			baseURL: '{{ URL::base() }}',
			appURL: function(uri) { 
				if (uri.substr(0, 1) != '/') {
					uri = '/' + uri;
				}
				return this.baseURL + uri;
			},
			uri: '{{ URI::current() }}',
		};

		</script>
	</head>

	<body>
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="brand" href="{{ URL::to('splinter') }}"><img src="{{ URL::to_asset('bundles/splinter/img/splinter_28.png') }}" width="28" height="28" /> Splinter</a>
					<span class="slogan">Split testing for Laravel</span>
					<div class="nav-collapse collapse">
						<a href="http://gittip.com/kbanman" class="btn btn-primary pull-right" target="_blank"><i class="icon-github"></i> Tip Me</a>
					</div><!--/.nav-collapse -->
				</div><!-- /.navbar-inner -->
			</div><!-- /.navbar -->

		</div><!-- /.container -->

		<div class="container marketing">

			<div class="row">
				<div id="leftPane" class="span4">
					<hgroup>
						<h3>Splits</h3>
						<a href="{{ URL::to('splinter/splits/new') }}" class="btn" data-target="dialog"><i class="icon-plus"></i></a>
					</hgroup>
					{{ $splitsList }}

					<hgroup>
						<h3>Goals</h3>
						<a href="{{ URL::to('splinter/goals/new') }}" class="btn" data-target="dialog"><i class="icon-plus"></i></a>
					</hgroup>
					{{ $goalsList }}

				</div>

				{{ $contentPane }}
			</div>

			<!-- FOOTER -->
			<footer>
				<p>Created by Kelly Banman
					 &middot; <a href="http://twitter.com/k_banman" target="_blank"><i class="icon-twitter"></i> @k_banman</a>
					 &middot; <a href="http://github.com/kbanman" target="_blank"><i class="icon-github"></i> kbanman</a>
					 &middot; <a href="http://gittip.com/kbanman" target="_blank">Tip me using GitTip</a>
				</p>
			</footer>

		</div><!-- /.container -->

		<div id="modalContainer"></div>

		<script type="text/javascript" src="{{ URL::to_asset('bundles/splinter/js/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::to_asset('bundles/splinter/js/select2.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::to_asset('bundles/splinter/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::to_asset('bundles/splinter/js/splinter.js') }}"></script>
	</body>
</html>
