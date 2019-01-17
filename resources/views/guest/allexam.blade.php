@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')  


 <link href="{{ asset('/frontend/css/package_style.css') }}" rel="stylesheet">

 <section class="section mycontainer" style="position: relative;background-size: cover;min-height: 350px;text-align: center;">
	 	<div class="container home">
	 		<div class="top-bg-overlay-fill"></div>
			<div class="lb-content text-center">
	<div class = "mt-10" style = "margin-top:40px"> </div>
      <div class = "row">
            @foreach($allExam as $exam)	    
			<div class = "col-sm-3 exam--card">	
                    <div class="panel-group col-sm-offset-1">
                        <div class="panel panel-info">
                        @php  $pic = (!is_null($exam['image'])) ? '/images/exam/thumbnail/'.$exam['image'] : '/images/exam/exam_icon_2.png'; 
                    
                        $finalPic = (!file_exists(public_path().$pic)) ? '/images/exam/exam_icon_2.png' : $pic  @endphp
                        <div class="panel-heading"> <img style = "max-width:120px;    height: 95px;" src="{{ asset( $finalPic )}}"  class="avatarbox material_avatar package_img"/></div>
                        <h4 class="group inner list-group-item-heading exam--name_tag"><strong  title="{{$exam['exam_name']}}" ><?php echo trim_words($exam['exam_name']); ?></strong></h4>
                        <div class="panel-body">
                        <ul class="card-details hidden-on-attempted">
                        <li>
                                <h5>Questions </h5><span class="count ">{{$exam['total_question']}}</span>
                            </li>
                            <li>
                                <h5> Total Time </h5> <span class="count">{{$exam['time']}} Mins</span>
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
            <?php if($paginate == true){ ?>
            <div class = "pull-right">
            <?php
                require_once(app_path().'/paginate/customPagination.php');
                $obj = new customPagination();
                $obj->customRendar($totalPage);
            ?>
            
            </div>
            <?php } ?>
        </div>
        
        
    </div>	
    </section>
    <script>
        "<?php $pageId =  isset($_GET['page']) ? $_GET['page']-1 : 0;?>" ;
        var id = "<?php echo $pageId+1;?>"; 
        var element = document.getElementById("page_"+id);
        // console.log(element);
        element.classList.add('activeli');
        element.classList.add('disable');

    var x = document.getElementsByClassName("disable");
    x[0].onclick = function(e) {
        e.preventDefault();
    }
    </script>


        
       @endsection
