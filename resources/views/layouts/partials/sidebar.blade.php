
@section('sidebar')
<!--sidebar-menu-->
<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-file"></i> Menu</a>
  <ul>
    <li><a href="{{route('dashboard')}}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="submenu"><a href="#" ><i class="icon icon-user"></i> <span>Users</span></a>
  
      <ul>
        <li><a href="{{route('users')}}">View Users</a></li>
        <li><a href="{{route('add-user')}}">Add User</a></li>
      </ul>
  
  </li>

    <li><a href="{{route('institution')}}"><i class="icon icon-signal"></i> <span>Institution</span></a> </li>
   
    <li class="submenu"><a href="#"><i class="icon icon-signal"></i> <span>Course</span></a> 
    <ul>
        <li><a href="{{route('course')}}">View Course</a></li>
        <li><a href="{{route('add-course')}}">Add Course</a></li>
      </ul>
  </li>

    <li  class="submenu"><a href="#"><i class="icon  icon-reorder"></i> <span>Subscription</span></a>
    <ul>
        <li><a  href="{{route('subscription')}}">View Subscription</a></li>
        <li><a href="{{route('add-subscription')}}">Add Subscription</a></li>
      </ul>
  </li>

    <li class="submenu"><a href="#"><i class="icon  icon-book"></i> <span>Exams</span></a>
    <ul>
        <li><a  href="{{route('exam')}}">Exam</a></li>
        <li><a  href="{{route('add-exam')}}">Add Exam</a></li>
      </ul>
  </li>


   <li ><a href="{{route('user-exam-list')}}"><i class="icon  icon-book"></i> <span>User Exam</span></a>
   

      <li><a href="{{route('result')}}"><i class="icon  icon-hdd"></i> <span>Result</span></a></li>

      <li class="submenu"><a href="#"><i class="icon  icon-book"></i> <span>Question File</span></a>
    <ul>
        <li><a  href="{{route('download-file')}}">Download</a></li>
      </ul>
  </li>

   <li ><a href="{{route('feedback-messages')}}"><i class="icon  icon-book"></i> <span>Feedback</span></a>
     
    </li>
      <li ><a href="{{route('announcement')}}"><i class="icon  icon-book"></i> <span>Announcement</span></a>
    </li>
   
  </ul>
</div>

@endsection