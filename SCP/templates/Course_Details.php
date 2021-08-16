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

    <div class="container">
      <h2>Course Details</h2>
      <form class="form-horizontal" id="CourseDetForm">
        <div class="form-group">
          <label class="control-label col-sm-2" for="coursename">Course Name</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" autocomplete="off" 
            id="coursename" placeholder="coursename" name="coursename" maxlength="50">
            <span class="error-coursename error"></span>
          </div>

        </div>
        
        <div class="form-group">
          <label class="control-label col-sm-2" for="course_details">Course Details</label>
          <div class="col-sm-5">          
            <textarea type="text" class="form-control" id="course_details" autocomplete="off" name="course_details"></textarea>
            <span class="error-course_details error"></span>
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button name="insert" id="btnval" onclick="SubmitCourseDetail()" type="button" class="btn btn-default">Submit</button>
          </div>
        </div>

        <div class="form-group" style="display: none">
          <label class="control-label col-sm-2" for="course_id"></label>
          <div class="col-sm-5">          
            <input type="text" class="form-control" id="course_id" autocomplete="off" 
            placeholder="" name="course_id">
            
          </div>
        </div>

      </form>
    </div>


    <div style="margin-left: 19%">
      <table border="2" style="width:50%">
      
      <thead>
        <tr>
          <th>ID</th>
          <th>Coursename</th>
          <th>CourseDetail</th> 
          <th>Action</th>
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
      
      function GetCourseData(page){
       $.ajax({
          type: "GET",
          url: 'courseformactions.php',
          data: {'form':'fetch','page':page},
          dataType: 'json',
          success: function(response){
            
            if(response.status == 200){

              var str = "";
              // var i=1;
              $.each(response.data,function(k,v){
                str += "<tr><td>"+v.course_id+"</td>";
                str += "<td>"+v.course_name+"</td>";
                str += "<td>"+v.course_details+"</td>";
                str += "<td>"+
                "<button style='margin-right:5px' data-sid='"+v.course_id+"' type='button' class='btn btn-default btn-sm editicon'>Edit</button>"+
                "<button type='button' data-sid='"+v.course_id+"' class='btn btn-warning btn-sm deleteicon'>Delete</button>"+
                "</td></tr>";
                
                // i++;
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

      function SubmitCourseDetail(){
    
        $('.error-coursename').html('');
        $('.error-coursedetails').html('');
        
        if($('#coursename').val() == ""){
          $('.error-coursename').html("CourseName is required");
          return false;
        }
        if($('#course_details').val() == ""){
          $('.error-course_details').html("Course Detail is required");
          return false;
        }
    
    
        if($('#btnval').html() == 'Submit'){
          $.ajax({
            type: "POST",
            url: 'courseformactions.php',
            data: {
              'coursename':$('#coursename').val(),
              'course_details':$('#course_details').val(),
              'form':'insert'
            },
            dataType: 'json',
            success: function(response){

              if(response.status == 200){
                $('#CourseDetForm')[0].reset();
                alert(response.message);
                GetCourseData(1);
                
              }else{
                alert(response.message);
                
              }
            }
          });
          return false;  
        }
        else if($('#btnval').html() == 'Update'){
          
          $.ajax({
            type: "POST",
            url: 'courseformactions.php',
            data: {
              'coursename':$('#coursename').val(),
              'course_details':$('#course_details').val(),
              'course_id':$('#course_id').val(),
              'form':'update'
            },
            dataType: 'json',
            success: function(response){

              if(response.status == 200){
                
                $('#CourseDetForm')[0].reset();
                $('#btnval').html('Submit');
                alert(response.message);
                GetCourseData(1);
                
              }else{
                alert(response.message);
                
              }
            }
          });
          return false; 
        }
      }

      $(document).ready(function(){
        GetCourseData(1);

      $(document).on('click', '.pagination_link', function(){
        var page = $(this).attr('id');
        GetCourseData(page);      
      });

      $(document).on('click','.editicon',function(){

        // alert($(this).attr('data-sid'));
        $('#course_id').val($(this).attr('data-sid'));

        $.ajax({
        type: "GET",
        url: 'courseformactions.php',
        data: {'form':'edit','course_id':$(this).attr('data-sid')},
        dataType: 'json',
        success: function(response){
          
          if(response.status == 200){

            $.each(response.data,function(k,v){
              $('#coursename').val(v.course_name);
              $('#course_details').val(v.course_details);
              
            });

            $('#btnval').html('Update');
            
          }else{
            alert(response.message);
          }
          }
        });
      return false;
      });

      $(document).on('click','.deleteicon',function(){
      // alert($(this).attr('data-sid'));
      $.ajax({
        type: "GET",
        url: 'courseformactions.php',
        data: {'form':'delete','course_id':$(this).attr('data-sid')},
        dataType: 'json',
        success: function(response){
          
          if(response.status == 200){

            $('#CourseDetForm')[0].reset();
            alert(response.message);
            GetCourseData(1);
            
          }else{
            alert(response.message);
          }
        }
      });
      return false;
      });

      });

    </script>

  </body>
</html>