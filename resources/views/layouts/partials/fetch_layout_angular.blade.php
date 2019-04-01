<!-- fetch_layout_angular.blade.php -->

<script src="{{ asset('js/angular/angular.min.js') }}"></script>
<script src="{{ asset('js/angular/angular-sanitize.js') }}"></script>
<script src="{{ asset('js/angular/angular-datatables.min.js') }}"></script>
<script src= "{{asset('js/ng-google-chart.js') }}"></script>

	<script type="text/javascript">
		var app = angular.module('maarulaapp', ['datatables','googlechart']);
		app.config(config);
			config.$inject = ['$interpolateProvider'];
			function config($interpolateProvider){

			$interpolateProvider.startSymbol('<@');
			$interpolateProvider.endSymbol('@>');
		}

	app.factory("chartService", [function(){
        var obj={};
        obj.data={};
        obj.type = "PieChart";
        obj.options = {
        'title': '','is3D': true,
        'chartArea':{
            'left':'5%','top':'10%','width':'50%','height':'100%',
         },
        'pieHole':0,
         'pieSliceText': 'value-and-percentage'
    };
  
        obj.chartTypes = [
        {name:"Pie Chart", type:"PieChart"},
        {name:"Column Chart", type:"ColumnChart"},
       // {name:"Bar Chart", type:"BarChart"},
        //{name:"Line Chart", type:"LineChart"},
       // {name:"Area Chart", type:"AreaChart"}
   	 ];
    
        obj.data["cols"] = [
            {id:1, label:"", type:"string"},
            {id:2, label:"", type:"number"}
        ];
        obj.data["rows"] = [];
        obj.addColumn = function(label,value){
            obj.data["rows"].push({
                c: [
                    {v: label},{v: value}
                ]
            });
        }
    return obj;
    }
]);
		  

	</script>