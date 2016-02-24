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
                    <p ng-show="submit-success">New student registered successfully</p>
                </div>
               <div class="row">
                    <div class="col-md-2">
                        <div class="form-group form-group-custom form-control-clear">
                            <label>Registration No </label>
                            <input type="text" class="form-control" placeholder="Enter reg. no" ng-model="reg_num"/>
                        </div>
                    </div>

                    <div class="col-md-3">                        
                        <div class="form-group form-group-custom form-control-clear">
                            <label>First Name </label>
                            <input type="text" placeholder="Enter student first name" class="form-control" ng-model="first_name"/>                                
                        </div>
                    </div>

                     <div class="col-md-3">                        
                        <div class="form-group form-group-custom form-control-clear">
                            <label>Last Name </label>
                            <input type="text" placeholder="enter student last name" class="form-control" ng-model="last_name"/>                                
                        </div>
                    </div>

                     <div class="col-md-2">                        
                        <div class="form-group form-group-custom form-control-clear">
                            <label>Score </label>
                            <input type="text" placeholder="enter student score" class="form-control" ng-model="score"/>                                
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group form-group-custom form-control-clear">
                            <button type="submit" class="btn btn-primary btn-lg col-md-12" ng-click="registerNewStudent()">Submit</button>                         
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

        <div id="file-upload-section" ng-show="SHOWFILEUPLOAD">

            <div id="my-dropzone" class="dev-widget alert alert-primary" style="border: 1px solid #ccc !important; height: 200px !important; padding-top: 80px;">
                <div class="text-center"><span>Drop files in here or click the button to upload a file</span></div>
            </div>

            <div class="modal fade" style="" id="show-uploaded" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="margin-left: 28.3%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="largeModalHead">File Uploaded Successfully 
                        <small>Please verify the content of the file before we save it to the database</small>
                        <p class="pull-right">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                        <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save</button>
                        </p>
                        </h4> 
                    </div>
                    <div class="modal-body">
                        <div>
                           <div class="col-md-4">                        
                            <div class="form-group">
                                <label>Course </label>
                                <select class="form-control">
                                    <option ng:repeat="course in _COURSES" ng-value="course.id">{{course.name}}</option>
                                 </select>
                            </div>
                           </div>
                           <div class="col-md-4 pull-right">                        
                            <div class="form-group">
                                <label>Semester </label>
                                 <select class="form-control" ng-options="session.id as session.name for session in SESSIONS" ng-model="SESSION">
                                    <option>Select session</option>
                                 </select>
                            </div>
                           </div>
                        </div>

                        <div class="table-responsive"  style="height: 350px !important; overflow-y: scroll">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Reg. No</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Score</th>
                                        </tr>
                                    </thead>
                                    <tbody id="uploaded-csv-file">
                                        
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
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