<div class="dev-page-sidebar">
    <ul class="dev-page-navigation">
        <li class="title">Navigation</li>
        <li>
            <a href="#" ng-click="loadDashboard()"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
        </li>                        
        <li>
            <a href="#"><i class="fa fa-files-o"></i> <span>Courses</span></a>
            <ul>                       
               <li ng:repeat="course in COURSES"><a ng-click="loadCourse(course.id, course.name, course.description)" ng-href="#/{{course.name}}"><i class="fa fa-file-o"></i> <span>{{ course.name }}</span></a></li>
            </ul>
        </li>                        
        <li class="active">
            <a href="#" ng-click="loadFileUpload()"><i class="fa fa-cloud-upload"></i> <span>Upload Results</span></a>
        </li>
        <li class="title">Session</li>
        <li>
           <select class="form-control" ng-options="session.id as session.name for session in SESSIONS" ng-model="SESSION">
               <option>Select session</option>
           </select>
        </li>  
    </ul>
    
</div>