@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')

@section('content')
<div id="content">
     <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Edit Instution</h5>
          </div>
          <div class="widget-content nopadding">
            
              <form class="form-horizontal" action="{{ route('updateinstitution',$getData['id'])}}" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate">
                  @csrf
              <div class="control-group">
                <label class="control-label"> Name</label>
                <div class="controls">
                    <input type="text" name="ins_name" id="required" value = "{{$getData['name']}}">
                </div>
              </div>
                  
              <div class="form-actions">
                <input type="submit" value="Update" name ="update" class="btn btn-success">
              </div>
            </form>
              
              
          </div>
        </div>
        </div>
        </div>
</div>
</div>
@endsection