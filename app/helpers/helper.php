<?php
if (!function_exists('rahul')) {
    function rahul()
    {
     return 'rahul';
    }
}



<div class="mt-card daily-quiz-card has-tags ng-scope" ng-class="quiz.cardClass" ng-repeat="quiz in curCourseQuizArr" data-tid="5af0c4456f09f15df8723a8b" data-serve-on-date="1525890600000">
<div class="card-tags ng-binding">
<i class="tb-icon tb-tag"></i> Company Test
</div>
<div class="card-title ng-binding">
L&amp;T Infotech - Test 1
</div>
<div class="tags">
<!-- ngRepeat: item in quiz.specificExams --><span ng-repeat="item in quiz.specificExams" class="ng-binding ng-scope">L&amp;T</span><!-- end ngRepeat: item in quiz.specificExams -->
</div>
<div class="date-time">
Expires in: <span class="ng-binding">0</span>
</div>
<ul class="card-details hidden-on-attempted">
<li>Questions <span class="count ng-binding">60</span></li>
<li>Total Time <span class="count ng-binding">120mins</span></li>
</ul>
<ul class="card-details visible-on-attempted">
<li>Correct <span class="count ng-binding">0/60</span></li>
<li>Time Taken <span class="count ng-binding">0 mins</span></li>
</ul>
<div class="card-actions">
<button type="button" class="btn btn-block btn-theme hidden-on-attempted start-resume-btn" ng-click="storeCurrQuizInfoInLS(quiz, quiz.startURLQuiz)"></button>
<button type="button" class="btn btn-block btn-gray-1 visible-on-attempted" ng-click="storeCurrQuizInfoInLS(quiz, quiz.analysisURLQuiz)">View Quiz</button>
</div>
</div>

<style>

 .daily-quiz-card {
    height: 288px;
    padding: 12px 16px 46px;
    border-radius: 3px;
    border-color: transparent;
    background-color: #fff;
    -webkit-box-shadow: 0 2px 4px 1px rgba(0,0,0,.15);
    box-shadow: 0 2px 4px 1px rgba(0,0,0,.15);
}
 .mt-card {
    position: relative;
    float: left;
    width: 224px;
    white-space: normal;
    border: 2px solid #eaeaea;
    z-index: 20;
    margin: 20px 12px;
}

 .daily-quiz-card .card-tags {
    color: #8e9aa9;
    font-size: 12px;
    margin-bottom: 6px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
 .daily-quiz-card .card-title {
    font-size: 18px;
    line-height: 1.25;
    color: #495563;
    font-weight: 500;
    min-height: 46px;
    margin-bottom: 8px;
}

 .card-actions {
    position: absolute;
    left: 16px;
    right: 16px;
    bottom: 12px;
}
.card-details {
    position: absolute;
    left: 16px;
    right: 16px;
    bottom: 46px;
    padding: 0;
    margin: 0;
    list-style: none;
}
</style>