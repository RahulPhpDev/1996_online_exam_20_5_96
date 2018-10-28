@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 

 <link href="{{ asset('/frontend/css/package_style.css') }}" rel="stylesheet">

 <link href="{{ asset('/frontend/css/package_exam.css') }}" rel="stylesheet">

<style type="text/css">
  .prodcut_div{
    margin-top: 20px;
  }
</style>
 <div class="item-container">    
            <div class="container"> 
                <div class="col-md-12">
                   <div class="product prodcut_div col-md-5 service-image-left ">
                        <div class="mycontainer">
                            <center>
                          
                      <img src="{{ asset('frontend/img/nia.png') }}" alt="Test123" id="item-display" />           
                       </center>
                       <div class="product_description">
                        <?php echo htmlspecialchars_decode($package['description']);?>
                                         
                       </div>
                        </div>
                    </div>


        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 bhoechie-tab-container">
             @php $componentData = array('package' => $package,); @endphp
                      @component('permit.exam.template.view_package_exams', $componentData)
                    @endcomponent
                       

         </div>
      </div>
  </div>
<script>
$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>

    @endsection