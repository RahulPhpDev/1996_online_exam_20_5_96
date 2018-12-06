@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')  
 <link href="{{ asset('/frontend/css/package_style.css') }}" rel="stylesheet">

<section class="section mycontainer" style="padding-bottom: 30px">
        <!-- <span class="pdp-breadcrumb">

           <a href="javascript::void(0)" class="back-page"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to Packages</a>
        </span> -->
        <div class="item-container">    
            <div class="container"> 
                <div class="col-md-12">
                    <div class="product col-md-7 service-image-left ">
                        <div class="mycontainer">
                            <center style = "border-bottom:1px dashed #ddd">
                            @php  $pic = (!is_null($package->image)) ? '/images/package/thumbnail/'.$package->image : '/images/package/dummy.jpg';  @endphp
                      <img src="{{ asset( $pic) }}" alt="Package" id="item-display" />           
                       </center>
                       <div class="product_description">
                        <?php echo htmlspecialchars_decode($package['description']);?>
                                         
                       </div>
                        </div>
                    </div>
                     <div class="col-md-5">
                    @php $componentData = array('package' => $package,); @endphp
                      @component('guest.template.package-detail', $componentData)
                    @endcomponent
                       
                            
                        </div>
                </div>
            </div> 
        </div>
         
    </section>
       
        <div class="container-fluid">    

        @php $componentData = array('otherPackage' => $otherPackage); @endphp
          @component('guest.template.other_pacakge', $componentData)
        @endcomponent

            
    </div>
    @endsection