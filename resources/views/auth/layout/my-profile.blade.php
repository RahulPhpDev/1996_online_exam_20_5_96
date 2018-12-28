
 <h2 class="title-border"> My Profile </h2>
<div class = "profile_details"> 
 <div  class="form-horizontal" >
                <div class="form-group">
                        <label for="group_name" class="col-sm-4 control-label">Email :</label>
                        <div class="col-sm-4 details">
                                     {{Auth::User()->email}} 

                           </div>
                        </div>
            </div>
            <div  class="form-horizontal" >
                <div class="form-group">
                        <label for="group_name" class="col-sm-4 control-label">Name :</label>
                        <div class="col-sm-4 details">
                                     {{Auth::User()->fname.' '.Auth::User()->lname}} 
                           </div>
                        </div>
            </div>
            <?php
            if(!is_null(Auth::user()->profile_image)){
               $profilePic = '/images/profile/thumbnail/'.Auth::user()->profile_image;
           ?>
            <div  class="form-horizontal" >
                <div class="form-group">
                        <label for="group_name" class="col-sm-4 control-label">Profile Picture :</label>
                        <div class="col-sm-4 details">
                                <img src = "{{$profilePic }}" class = "img_style">
                           </div>
                        </div>
            </div>
        <?php } ?>
            </div>