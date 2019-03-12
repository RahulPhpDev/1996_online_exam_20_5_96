<!-- fetch_layout_angular.blade.php -->

 <script src="{{ asset('js/angular/angular.min.js') }}"></script>
  <script src="{{ asset('js/angular/angular-sanitize.js') }}"></script>
	<script type="text/javascript">
		var app = angular.module('maarulaapp', []);
		app.config(config);
			config.$inject = ['$interpolateProvider'];
			function config($interpolateProvider){

			$interpolateProvider.startSymbol('<@');
			$interpolateProvider.endSymbol('@>');
		}

		  

	</script>