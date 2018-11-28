

<section class="section mycontainer" style="position: relative;background-size: cover;min-height: 350px;text-align: center;">
	<div class="mb50"></div>
	 	<div class="container home">
	 		<div class="top-bg-overlay-fill"></div>
			<div class="lb-content text-center">
				<h1 class="text-center font_bold m0" style="color: #fff;">Start Your Exam Preparation Now!</h1>
				
				@if(count($allExam) > 3)
					<div class = "view_all">
					    <a href = "{{route('allpackage')}}" class = "button btn btn_blue view_all_btn"> View All </a>
					  </div> 
				 @endif  
<style type="text/css">
	.caption_bottom >div{
		display: inline-block;
		margin:0px 10px 0px 10px;
	}
	.exam_icon{
		width:55px;
	}
</style>

<div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
            <div class="MultiCarousel-inner">
            @foreach($allExam as $exam)	    
                <div class="item ">
                <div class = "item_margin" style="border:1px dashed #fff;">
                <div class="pad15">
             <a class="" href="{{ route('get-exam', ['id' => Crypt::encrypt($exam['id']) ]) }}">
                     <div class="caption" style = "height:80px;border-bottom:1px solid white; ">
                     	 <img src="{{ asset('/frontend/img/exam/exam_icon_3.png') }}" alt=" Exam" class="exam_icon" />

                        <h4 class="group inner list-group-item-heading"><strong>{{$exam['exam_name']}}</strong></h4>
                     </div>
                     <div class="caption_bottom">
                     	<div class = "sideline" style="    border-right: 2px solid #fff;     margin-top: 10px;">  <h2 style="position: relative;top: 25px; right: 50px;"> {{$exam['total_question']}} </h2> <h4 class = "center" style="position: relative; right: 50px;"> Question </h4> </div>

                     	<div class = "">  <h2 style="position: relative;top: 25px;left:16px"> {{$exam['total_marks']}} </h2> <h4 style=" " class = "center"> <span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>Marks </h4> </div>
                     </div>
                    </a>
                  </div>
                </div>
                   </div>
			    @endforeach			 
            </div>
           @if(count($allExam) > 3)
            <button class="btn btn-primary leftLst"> < </button>
            <button class="btn btn-primary rightLst"> > </button>
            @endif
         
    </div>


			</div>
		</div>	
		<div class="mb50"></div>
	
</section>