

<section class="section mycontainer" style="position: relative;background-size: cover;min-height: 350px;text-align: center;">
	<div class="mb50"></div>
	 	<div class="container home">
	 		<div class="top-bg-overlay-fill"></div>
			<div class="lb-content text-center">
				<h1 class="text-center font_bold m0" style="color: #fff;margin-bottom:40px">Start Your Exam Preparation Now!</h1>
				
				
<style type="text/css">
	.caption_bottom >div{
		display: inline-block;
		margin:0px 10px 0px 10px;
	}
	.exam_icon{
		width:55px;
	}

	
	.daily-quiz-card {
    height: 288px;
    padding: 12px 16px 46px;
    border-radius: 3px;
    border-color: transparent;
    background-color: #fff;
    -webkit-box-shadow: 0 2px 4px 1px rgba(0,0,0,.15);
    box-shadow: 0 2px 4px 1px rgba(0,0,0,.15);
}
 .mt-card {
    position: relative;
    float: left;
    width: 224px;
    white-space: normal;
    border: 2px solid #eaeaea;
    z-index: 20;
    margin: 20px 12px;
}

	.card-details {
		position: relative;
    left: -25px;
    right: 37px;
    bottom: 46px;
    padding: 0;
    margin: 0;
    list-style: none;
    color: black;
    top: 23px;
    text-align: center;
    height: 120px;
}
.card-details .count {
    float: right;
    color: #495563;
}
.card-details li {
    text-transform: uppercase;
    font-size: 13px;
    color: #8e9aa9;
    padding: 12px 0;
}
</style>

	<div class = "mt-10" style = "margin-top:40px"> </div>
            @foreach($allExam as $exam)	    
			<div class="panel-group col-sm-4">
				<div class="panel panel-info">
				@php // $pic = (!is_null($exam['image'])) ? '/images/exam/thumbnail/'.$exam['image'] : '';  @endphp
              
				<div class="panel-heading"> <img src="" ></div>
				<h4 class="group inner list-group-item-heading"><strong>{{$exam['exam_name']}}</strong></h4>
				<div class="panel-body">
				<ul class="card-details hidden-on-attempted">
					<li>Questions <span class="count ng-binding">{{$exam['total_question']}}</span></li>
				   <li>Total Time <span class="count ng-binding">120mins</span></li>
				</ul>
				
				</div>
			  </div>
			</div>

			    @endforeach			 
            </div>
         
         
 
		</div>	
		<div class="mb50"></div>
	
</section>