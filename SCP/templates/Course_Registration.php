<!DOCTYPE html>
<html lang="en">
<head>
  <title>Assignment</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <style type="text/css">
    .error{
      color:red;
    }
    th, td {
      padding: 15px;
    }
  </style>
</head>
<body>

<?php
  include_once('../class.Course_Details.php');

  $obj = new Course_Details();
  $data = $obj->GetStudentCourseData();

?>

    <div class="container">
      <h2>Student Course Registrtion</h2>
      <form class="form-horizontal" id="CourseRegForm">
        <div class="form-group">
          <label class="control-label col-sm-2" for="studentname">Student Name</label>
          <div class="col-sm-5">
            <select class="form-control" autocomplete="off" 
            id="studentname" name="studentname">
              <option>
                Select Student
              </option>
              <?php foreach($data['data']['students'] as $value){ ?>
              <option value="<?php echo $value['student_id']; ?>">
                <?php echo $value['firstname']." ".$value['lastname']; ?>
              </option>
              <?php } ?>
            </select>
            <span class="error-studentname error"></span>
          </div>

        </div>
        
        <div class="form-group">
          <label class="control-label col-sm-2" for="course_name">Course Name</label>
          <div class="col-sm-5">          
            <select class="form-control" autocomplete="off" 
            id="course_name" name="course_name">
              <option>
                Select Course
              </option>
              <?php foreach($data['data']['courses'] as $value){ ?>
              <option value="<?php echo $value['course_id']; ?>">
                <?php echo $value['course_name']; ?>
              </option>
              <?php } ?>
            </select>
            <span class="error-course_name error"></span>
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button name="insert" id="btnval" onclick="SubmitStuCourse()" type="button" class="btn btn-default">Submit</button>
          </div>
        </div>

      </form>
    </div>


    <div style="margin-left: 19%">
      <table border="2" style="width:50%">
      
      <thead>
        <tr>
          <th>Student Name</th>
          <th>Course Name</th>
        </tr>
      </thead>
      <thead id="appendall">
          
      </thead>
      
      </table>
      <br>
      <div id="pagination_data">
        
      </div>
    </div>

    <script type="text/javascript">

      function SubmitStuCourse(){

        $('.error-studentname').html('');
        $('.error-course_name').html('');
        
        if($('#studentname').val() == ""){
          $('.error-studentname').html("Student is required");
          return false;
        }
        if($('#course_name').val() == ""){
          $('.error-course_name').html("CourseName is required");
          return false;
        }
    
        if($('#btnval').html() == 'Submit'){
          $.ajax({
            type: "POST",
            url: 'courseformactions.php',
            data: {
              'student_id':$('#studentname').val(),
              'course_id':$('#course_name').val(),
              'form':'insertcourse'
            },
            dataType: 'json',
            success: function(response){

              if(response.status == 200){
                $('#CourseRegForm')[0].reset();
                alert(response.message);
                GetCourseRegData(1);
                
              }else{
                alert(response.message);
                
              }
            }
          });
          return false;  
        }
      }

      function GetCourseRegData(page){
        $.ajax({
          type: "GET",
          url: 'courseformactions.php',
          data: {'form':'fetchcoursereg','page':page},
          dataType: 'json',
          success: function(response){
            
            if(response.status == 200){

              var str = "";
              
              $.each(response.data,function(k,v){
                str += "<tr>";
                str += "<td>"+v.firstname+" "+v.lastname+"</td>";
                str += "<td>"+v.course_name+"</td>";
                str += "</tr>";
                
              });

              $('#appendall').html(str);
              $('#pagination_data').html(response.paginate);
              
            }else{
              alert(response.message);
              
            }
          }
        }); 
       return false;
      }

      $(document).ready(function(){
        GetCourseRegData(1);
        
        $(document).on('click', '.pagination_link', function(){
          var page = $(this).attr('id');
          GetCourseRegData(page);      
        });
      });
    </script>

  </body>
</html>