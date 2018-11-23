@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')  

<style>
.product_container{
    margin:15px;
}
.package_image{
    float:right;
    margin-right:10px;
}
.items{
    width:80%;
    margin:auto;
    text-align:center;
    /* border:1px dashed #ddd; */
}
.item_details{
    margin:10px 0px 0px 10px ;
    min-height:250px;
    position:relative;
    
}

.package_image{padding:20px;  text-align:center;
        vertical-align:middle;
        display:table-cell;   }
        
        .package_description, .shop{
            display:table;
        }
        .shop{
            margin-top:10px;
        }
        .package_title{
            float:left;
            margin-top:25px;
            margin-left:19px;
        }
        .package_title > h1{
            font-weight:600;
            font-size:20px;
            text-transform:uppercase;
            letter-spacing:2px;
        }
        .clear{
            clear: both;
        }
</style>

 <link href="{{ asset('/frontend/css/package_style.css') }}" rel="stylesheet">
<section class="section mycontainer" style="padding-bottom: 30px">
        
        <div class="item-container"> 
        @php $i = 1; @endphp
        @foreach($allPackage as $package)  
            <?php $background = ($i %2 == 0) ? '#EBE9E9' : "#F1F1F1"; ?>
            <div class = "  items" style = "background:{{ $background}}">
             <div class = "row item_details">
                <div class = "col-sm-4">
                    <div class = "package_image">
                      <img src="{{ asset('frontend/img/nia.png') }}" alt="Test123" id="item-display"  />       
                    </div>
                </div> 

                <div class = "col-sm-6">
                    

                    <div class = "description"> <div class = "package_title">
                        <h1> {{$package['name']}}</h1>
                    </div>
                    <div class  = "clear"> </div>
                    <div class = "package_description">
                   
                       @php echo htmlspecialchars_decode($package['description']) @endphp
                    </div>

                        <div classs = "exams_info" style = "display:table"> 
                        <strong>Exams :</strong>
                         <span class="text-info"><strong>
                                   @foreach($package->Exam as $exam)
                                    {{$exam->exam_name}} |
                                   @endforeach
                            </strong>
                        </div>
                        <?php if(Auth::user()){ 
                            $url = '/save-package-exam/'.Crypt::encrypt($package['id']);
                             }else{
                               $url = '/login';
                             }
                            ?>
                        <div class = "shop">
                        <div class="addtocart">
                                    <a href="{{ $url}}"  class="btn btn-success shopCart" id="addtocart" style="background: #68c6ec;border: #68c6ec;"><span class="fa fa-shopping-cart"></span>&nbsp;Buy And Explore</a>                           
                               </div>
                        </div>
                    </div>
                </div>    
                </div>
            </div> <!--row-->
            @php $i++; @endphp
            @endforeach
        </div>
    </section>
    
       @endsection
