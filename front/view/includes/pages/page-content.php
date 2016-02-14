<div class="container">
    
    <!-- page title -->
    <div class="page-title">
        <h1 ng-bind="PAGE_TITLE_HEADER"></h1>
        <p ng-bind="PAGE_TITLE_DESC"></p>
        
        <ul class="breadcrumb">
            <li><a href="#"></a></li>
        </ul>
    </div>                        
    <!-- ./page title -->
    
    <!-- boxed layout -->
    <div class="wrapper wrapper-white">
        <div id="result-section" ng-show="SHOWRESULTS">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sortable table-responsive">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Reg. No</th>
                            <th>Student Name</th>
                            <th>Score</th>
                            <th>Grade</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>                               
                    <tbody>
                        <tr ng:repeat="score in SCORES">
                            <td>1</td>
                            <td>{{score.student_info.id}}</td>
                            <td>{{score.student_info.first_name + " " + score.student_info.last_name}}</td>
                            <td>{{score.score_info.score}}</td>
                            <td>{{score.score_info.grade}}</td>
                            <td><center><i class="fa fa-edit text-warning" style="font-size: 2em;"></i></center></td>
                            <td><center><i class="fa fa-close text-danger" style="font-size: 2em;"></i></center></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="dashboard-section" ng-show="SHOWDASHBOARD">
           <h1 class="text-primary" style="margin-top: 10%; margin-bottom: 10%; font-style: bold"><center>WELCOME TO YOUR DASHBOARD</center></h1>
        </div>

        <div id="loading-anim-section" style="margin-top: 10%; margin-bottom: 10%;" ng-show="SHOWLOADING">
            <center><img src="<?= BINDIRABSOLUTE.'/img/plugins/blueimp/loading.gif'; ?>"/></center>
           <h2 class="text-info" style="font-style: bold"><center>Loading...</center></h2>
        </div>
    </div>
    <!-- ./boxed layout -->
    
    <!-- Copyright -->
    <div class="copyright">
        <div class="pull-left">
            <?= Res::COPYRIGHT; ?>
        </div>
        <div class="pull-right">
            <a href="#">Terms of use</a> / <a href="#">Privacy Policy</a>
        </div>
    </div>
    <!-- ./Copyright -->
</div>