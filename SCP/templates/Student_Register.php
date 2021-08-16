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
  <h2>Student Registration</h2>
  <form class="form-horizontal" id="StuRegForm">
    <div class="form-group">
      <label class="control-label col-sm-2" for="firstname">FirstName</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" autocomplete="off" 
        id="firstname" placeholder="FirstName" name="firstname" maxlength="50">
        <span class="error-firstname error"></span>
      </div>

    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="lastname">LastName</label>
      <div class="col-sm-5">          
        <input type="text" class="form-control" autocomplete="off"
        id="lastname" placeholder="LastName" name="lastname" maxlength="50">
        <span class="error-lastname error"></span>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="dob">DOB</label>
      <div class="col-sm-5">          
        <input type="date" class="form-control" autocomplete="off" 
        id="dob" name="dob">
        <span class="error-dob error"></span>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="contactno">ContactNo</label>
      <div class="col-sm-5">          
        <input type="text" class="form-control" id="contactno" autocomplete="off" 
        placeholder="ContactNo" name="contactno">
        <span class="error-contactno error"></span>
      </div>
    </div>
    
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button name="insert" id="btnval" onclick="SubmitStuReg()" type="button" class="btn btn-default">Submit</button>
      </div>
    </div>

    <div class="form-group" style="display: none">
      <label class="control-label col-sm-2" for="student_id"></label>
      <div class="col-sm-5">          
        <input type="text" class="form-control" id="student_id" autocomplete="off" 
        placeholder="" name="student_id">
        
      </div>
    </div>

  </form>
</div>


<div style="margin-left: 19%">
  <table border="2" style="width:50%">
  
  <thead>
    <tr>
      <th>ID</th>
      <th>Firstname</th>
      <th>Lastname</th> 
      <th>DOB</th>
      <th>Contact No</th>
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

  function GetStudentRegData(page){
   $.ajax({
      type: "GET",
      url: 'formactions.php',
      data: {'form':'fetch','page':page},
      dataType: 'json',
      success: function(response){
        
        if(response.status == 200){

          var str = "";
          var i=1;
          $.each(response.data,function(k,v){
            str += "<tr><td>"+v.student_id+"</td>";
            str += "<td>"+v.firstname+"</td>";
            str += "<td>"+v.lastname+"</td>";
            str += "<td>"+v.dob+"</td>";
            str += "<td>"+v.contactno+"</td>";
            str += "<td>"+
            "<button style='margin-right:5px' data-sid='"+v.student_id+"' type='button' class='btn btn-default btn-sm editicon'>Edit</button>"+
            "<button type='button' data-sid='"+v.student_id+"' class='btn btn-warning btn-sm deleteicon'>Delete</button>"+
            "</td></tr>";
            
            i++;
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

  function SubmitStuReg(){
    
    $('.error-firstname').html('');
    $('.error-lastname').html('');
    $('.error-dob').html('');
    $('.error-contactno').html('');

    if($('#firstname').val() == ""){
      $('.error-firstname').html("FirstName is required");
      return false;
    }
    if($('#lastname').val() == ""){
      $('.error-lastname').html("LastName is required");
      return false;
    }
    if($('#dob').val() == ""){
      $('.error-dob').html("DOB is required");
      return false;
    }
    if($('#contactno').val() == ""){
      $('.error-contactno').html("ContactNo is required");
      return false;
    }
    
    if($('#btnval').html() == 'Submit'){
      $.ajax({
        type: "POST",
        url: 'formactions.php',
        data: {
          'firstname':$('#firstname').val(),
          'lastname':$('#lastname').val(),
          'dob':$('#dob').val(),
          'contactno':$('#contactno').val(),
          'form':'insert'
        },
        dataType: 'json',
        success: function(response){

          if(response.status == 200){
            $('#StuRegForm')[0].reset();
            alert(response.message);
            GetStudentRegData(1);
            
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
        url: 'formactions.php',
        data: {
          'firstname':$('#firstname').val(),
          'lastname':$('#lastname').val(),
          'dob':$('#dob').val(),
          'contactno':$('#contactno').val(),
          'student_id':$('#student_id').val(),
          'form':'update'
        },
        dataType: 'json',
        success: function(response){

          if(response.status == 200){
            
            $('#StuRegForm')[0].reset();
            $('#btnval').html('Submit');
            alert(response.message);
            GetStudentRegData(1);
            
          }else{
            alert(response.message);
            
          }
        }
      });
      return false; 
    }

  }

  $(document).ready(function(){
    GetStudentRegData(1);

    $(document).on('click', '.pagination_link', function(){
      var page = $(this).attr('id');
      GetStudentRegData(page);      
    });

    $(document).on('click','.editicon',function(){
      
        // alert($(this).attr('data-sid'));
        $('#student_id').val($(this).attr('data-sid'));

        $.ajax({
        type: "GET",
        url: 'formactions.php',
        data: {'form':'edit','student_id':$(this).attr('data-sid')},
        dataType: 'json',
        success: function(response){
          
          if(response.status == 200){

            $.each(response.data,function(k,v){
              $('#firstname').val(v.firstname);
              $('#lastname').val(v.lastname);
              $('#dob').val(v.dob);
              $('#contactno').val(v.contactno);
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
        url: 'formactions.php',
        data: {'form':'delete','student_id':$(this).attr('data-sid')},
        dataType: 'json',
        success: function(response){
          
          if(response.status == 200){

            $('#StuRegForm')[0].reset();
            alert(response.message);
            GetStudentRegData(1);
            
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