<?php
//customPagination.php
class customPagination{
    public function __construct(){
      
    }
    public function customRendar($totalPage = 0){
      echo '<ul class="pagination"  role="navigation">';
      for($i = 0; $i <= $totalPage ; $i++){
        $pageNum = $i+1;
    //   echo '<a id = "page_$pageNum" href = "dfs?page=$pageNum ">  ".$pageNum."  </a>';
      echo ' <li class="page-item"> ';
      echo '<a class="page-link" id = "page_'.$pageNum.'" href = "'.url()->current().'?page='.$pageNum.'">  '.$pageNum.'  </a>';
      echo '</li>';
      }
      echo '</ul>';
    }
}
