@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')
@push('angular')
  @include('frontend_layouts.partials.fetch_angular')
@endpush


@section('content') 

<script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({
   
     showMathMenu: false,
  extensions: ["tex2jax.js"],
  jax: ["input/TeX", "output/HTML-CSS"],
  tex2jax: {
      skipTags: ["body"],
      processClass: "equation"
  }
  });
</script>


<script type="text/javascript">

app.controller('appController', function($scope,$timeout,$sce, $http){
$scope.examDetails = <?php echo $examDetails->getContent(); ?>;

$scope.resultDetails =<?php echo $resultDetails->getContent(); ?>; 


$scope.Total = function() { return parseInt($scope.examDetails.total_question ) + parseInt($scope.resultDetails.not_attempt ); };

});
</script>
<style type="text/css">
  .table{
    font-size: 19px;
    padding:10px;
    width: 90%;
    margin:auto;

  }
td, th{
  text-align: center;
}
</style>
<div class="maincontent" id="wrapper">
  <div class="overlay"></div>
    <section class="section_instruct">
      <div class="container-fluid" style="margin-top:130px">
    	 	<div class="row" ng-controller="appController">

       		<div class="col-md-12"  style="overflow-x:auto">
            <table class = "table res_table">
                <tr>
                  <th>Exam</th>
                  <th> Total Question </th>
                  <th> Attempt Question </th>
                  <th> Total Mark </th>
                  <th> Obtain Mark </th>
                  <th> Negative Mark </th>
                  <th> Time Taken </th>
                  <th>Result</th>
                  <th>Answer Sheet</th>
                </tr>
              
              <tr>
                <td> <@ examDetails.exam_name @></td>
                <td> <@ examDetails.total_question @></td>
                <td> <@ Total() @></td>
                <td> <@ examDetails.total_marks @></td>
                <td> <@ resultDetails.obtain_mark @></td>
                <td> <@ resultDetails.negative_marks @></td>
                <td> <@ resultDetails.time_taken @></td>
                <td> <@ resultDetails.result_status == 1 ? ' Pass ' : ' Fail' @></a> </span></td>
                <td><a href = "{{route('answer-sheet',['id'=>Crypt::encrypt($r_id)]) }}" class="btn btn-og btn-exam-custom ">View</a></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection