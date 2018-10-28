<div class="col-md-12 product-info">
             <div class="col-md-12">
                <div class="page-heading">
                    <div class="widget">
                        <h2 class="title-border">Recommended Packages</h2>
                    </div>
                </div>
        <div class="flexslider carousel">
          <ul class="slides">
               <li>
               	@php $i = 0; @endphp
                 @if($i < 3)	
              	 	@foreach($otherPackage as $other)
               	 		@php $i++ @endphp
                            <div class="col-md-3">
                                 <a  href="{{ route('package', ['id' => Crypt::encrypt($other->id) ]) }}">
                                    <div class="img-thumbnail">
                          <img src="{{ asset('frontend/img/nia.png') }}" alt="Test123" id="item-display" />                                            </div>
                                    <div style="clear: both;"></div>

                                 <h4 class="text-info text-center">{{$other->name}}</h4>
                                 </a>
                            </div>
                         @endforeach
                       @endif  
                        </li>
                  </ul>
            </div>

            </div>
        </div>