<div class="mycontainer">
                            <div class="product-title"><strong>{{$package['name']}}</strong></div>
                            <hr>


                            <div class="product-price">
                               <span
                                    class="text-success"><big><strong> 200.00</strong></big></span>
                            </div>
                          @if($package['isDatePermit'] == 0)  
                            <div class="product-stock">
                                Expiry : <span
                                    class="text-info"><strong>{{$package['duration']}} Month </strong></span>
                            </div>
                          @endif  

                    @if($package['isDatePermit'] == 1)  
                            <div class="product-stock">
                                Valid Till To  : 
                                <span class="text-info">
                                  <strong>{{$package['end_date']}}</strong>
                                </span>
                            </div>
                          @endif

                            <div class="product-stock">
                                <strong>Exams :</strong> <span
                                    class="text-info"><strong>
                                   @foreach($package->Exam as $exam)
                                    {{$exam->exam_name}}
                                   @endforeach
                                         </strong></span>
                            </div>
                            <hr>
                             <?php if(Auth::user()){ 
                            $url = '/save-package-exam/'.Crypt::encrypt($package['id']);
                             }else{
                               $url = '/login';
                             }
                            ?>
                           <div class="addtocart">
                                    <a href="{{$url}}"  class="btn btn-success shopCart" id="addtocart" style="background: #68c6ec;border: #68c6ec;"><span class="fa fa-shopping-cart"></span>&nbsp;Buy And Explore</a>                           
                               </div>
                           </div>