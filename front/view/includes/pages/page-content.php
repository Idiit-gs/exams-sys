<!-- <!-- <!-- <div class="container">
    
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
            <div class="col-md-4 pull-right">                        
                <div class="form-group">
                    <label class="control-label col-sm-3 col-md-3">Search: </label>
                    <input type="text" placeholder="type text here to filter the table" class="form-control" ng-model="searchName"/>                                
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive" datatable="ng" dt-options="dtOptions">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Reg. No</th>
                            <th>
                                <a href="#" ng-click="sortType = 'name'; sortReverse = !sortReverse">
                                    Student Name
                                    <span ng-show="sortType == 'name' && !sortReverse" class="fa fa-caret-down"></span>
                                    <span ng-show="sortType == 'name' && sortReverse" class="fa fa-caret-up"></span>
                                </a>
                            </th>
                            <th>
                                <a href="#" ng-click="sortType = 'score'; sortReverse = !sortReverse">
                                    Score
                                    <span ng-show="sortType == 'score' && !sortReverse" class="fa fa-caret-down"></span>
                                    <span ng-show="sortType == 'score' && sortReverse" class="fa fa-caret-up"></span>
                                </a>
                            </th>
                            <th>Grade</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>                               
                    <tbody>
                        <tr ng:repeat="score in SCORES | orderBy:sortType:sortReverse | filter:searchName">
                            <td>{{$index + 1}}</td>
                            <td>{{score.student_info.id}}</td>
                            <td>{{score.student_info.first_name + " " + score.student_info.last_name}}</td>
                            <td>{{score.score_info.score}}</td>
                            <td>{{score.score_info.grade}}</td>
                            <td><center><a ng-href="#score/edit/{{score.student_info.id}}"><i class="fa fa-edit text-warning" style="font-size: 2em;"></i></a></center></td>
                            <td><center><a ng-href="#score/delete/{{score.student_info.id}}"><i class="fa fa-close text-danger" style="font-size: 2em;"></i></a></center></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group-one-unit">
                <div class="page-subtitle">
                    <h3>Add a new student</h3>
                </div>
               <div class="row">
                    <div class="col-md-2">
                        <div class="form-group form-group-custom form-control-clear">
                            <label>Registration No </label>
                            <input type="text" class="form-control" placeholder="Enter reg. no"/>
                        </div>
                    </div>

                    <div class="col-md-3">                        
                        <div class="form-group form-group-custom form-control-clear">
                            <label>First Name </label>
                            <input type="text" placeholder="Enter student first name" class="form-control"/>                                
                        </div>
                    </div>

                     <div class="col-md-3">                        
                        <div class="form-group form-group-custom form-control-clear">
                            <label>Last Name </label>
                            <input type="text" placeholder="enter student last name" class="form-control"/>                                
                        </div>
                    </div>

                     <div class="col-md-2">                        
                        <div class="form-group form-group-custom form-control-clear">
                            <label>Score </label>
                            <input type="text" placeholder="enter student score" class="form-control"/>                                
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group form-group-custom form-control-clear">
                            <button type="submit" class="btn btn-default col-md-12">Submit</button>                         
                        </div>                       
                    </div>
                </div>              
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
</div> --> --> -->