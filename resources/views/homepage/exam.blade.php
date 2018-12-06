
<section class="section mycontainer" style="position: relative;background-size: cover;min-height: 350px;text-align: center;">
	<div class="mb50"></div>
	 	<div class="container home">
	 		<div class="top-bg-overlay-fill"></div>
			<div class="lb-content text-center">
				<h1 class="text-center font_bold m0" style="color: #fff;margin-bottom:40px">Start Your Exam Preparation Now!</h1>
	<div class = "mt-10" style = "margin-top:40px"> </div>
            @foreach($allExam as $exam)	    
			<div class = "col-sm-3">	
			<div class="panel-group col-sm-offset-1">
				<div class="panel panel-info">
				@php  $pic = (!is_null($exam['image'])) ? '/images/exam/thumbnail/'.$exam['image'] : '/images/exam/exam_icon_2.png';  @endphp
              
				<div class="panel-heading"> <img style = "max-width:120px;    height: 95px;" src="{{ asset( $pic )}}"  class="avatarbox material_avatar package_img"/></div>
				<h4 class="group inner list-group-item-heading"><strong>{{$exam['exam_name']}}</strong></h4>
				<div class="panel-body">
				<ul class="card-details hidden-on-attempted">
				<li>
						<h5>Questions </h5><span class="count ">{{$exam['total_question']}}</span>
					</li>
					<li>
						<h5> Total Time </h5> <span class="count">120mins</span>
					</li>
				</ul>
				</div>
				<div class="panel-footer">
					<a href="{{ route('exam-instruction', ['id' => Crypt::encrypt($exam['id']) ]) }}"><button type = "button" class = "button btn-success btn-custom"> Explore </button></a> 
				</div>
			  </div>
			</div>
			</div>
			    @endforeach			 
            </div>
		</div>	
		<div class="mb50"></div>
	
</section>