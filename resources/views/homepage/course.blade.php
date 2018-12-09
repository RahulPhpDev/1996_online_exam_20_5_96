
<section class="section mycontainer">
		<div class="container home">
			<div class="col-sm-12">
	             <h3 class="title-small text-center">Courses Exam Can Help For  You</h3>
  
                <div class="fancy-collapse-panel">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  @foreach($courseData as $course)  	
                   <div class = "col-sm-5 col-sm-offset-1 couse_exam_div"> 	
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">

                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse_{{$course['id']}}" aria-expanded="true" aria-controls="collapseOne">
                                    	 {{$course['course']}}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse_{{$course['id']}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    @php echo htmlspecialchars_decode($course['description']) @endphp
                                </div>
                              @foreach($course['exam'] as $exam)  
                  	<div class = "exam_couse">
                               <ul class="card-details hidden-on-attempted">
							<li>
								<h5>Exam </h5><span class="count ">{{$exam->exam_name}}</span>
							</li>
						<li>
						<h5> Total Time </h5> <span class="count">{{$exam->time}} Mins</span>
					  </li>
				</ul>
				<div class="panel-footer exam_explore_div">
					<a href="{{ route('exam-instruction', ['id' => Crypt::encrypt($exam->id) ]) }}"><button type = "button" class = "button btn-success btn-custom"> Explore </button></a> 
				</div>
			</div>


				@endforeach
				@if(count($course['exam'])>= 3)	
						<div class = "pull-right">
						 <a href = "#">view All Exam</a>		
						</div>
						@endif
                            </div>
                        </div>
                      </div>
                     @endforeach 
                      
                       
                    </div>
                </div>
           
				   
	    	</div>
	    </div>
		
</section> 