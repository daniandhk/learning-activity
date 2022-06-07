<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Learning Activity</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style type="text/css">
      .table-bordered > thead {
        background-color: #F2F2F2 !important;
      }
      .table-bordered > tbody > tr:nth-last-child(-n+2) > td {
        background-color: #F2F2F2 !important;
      }
    </style>
</head>
<body>
<div class="container mt-2">
    <div class="row">
        <div id="header-main" class="col-sm-12 text-left font-weight-bold mb-4">
          <h2>Learning Activity</h2>
        </div>
        <div class="col-sm-12">
            <table class="table table-bordered">
              <thead>
                <tr id="tr-main-months" class="text-center">
                </tr>
              </thead>
              <tbody id="tbody-main-methods"> 
              </tbody>
            </table>
        </div>

        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewSchedule" class="btn btn-success">Add Schedule</button></div>
        <div class="col-md-12">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Date Start</th>
                  <th scope="col">Date End</th>
                </tr>
              </thead>
              <tbody id="tbody-schedule">
              </tbody>
            </table>
        </div>

        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewMethod" class="btn btn-success">Add Method</button></div>
        <div class="col-md-12">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody id="tbody-method">
              </tbody>
            </table>
        </div>

        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewMonth" class="btn btn-success">Add Month</button></div>
        <div class="col-md-12">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody id="tbody-month">
              </tbody>
            </table>
        </div>
    </div>        
</div>
<!-- boostrap model -->
<div class="modal fade" id="ajax-method-model" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="ajaxMethodModel"></h4>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0)" id="addEditMethodForm" name="addEditMethodForm" class="form-horizontal" method="POST">
              <input type="hidden" name="id" id="id">
              <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="title" name="title" placeholder="Enter Method Name" value="" maxlength="50" required="">
                </div>
              </div>
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewMethod">Save changes
                </button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
<!-- end bootstrap model -->
<!-- boostrap model -->
<div class="modal fade" id="ajax-schedule-model" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="ajaxScheduleModel"></h4>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0)" id="addEditScheduleForm" name="addEditScheduleForm" class="form-horizontal" method="POST">
              <input type="hidden" name="id" id="id">
              <div id="select-method" class="form-group">
              </div>
              <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="title" name="title" placeholder="Enter Schedule Name" value="" maxlength="50" required="">
                </div>
              </div>
              <div class="form-group">
                <label for="date_start" class="col-sm-2 control-label">Date Start</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="date_start" name="date_start" placeholder="DD/MM/YYYY" value="" maxlength="10" required="">
                </div>
              </div>
              <div class="form-group">
                <label for="date_end" class="col-sm-2 control-label">Date End</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="date_end" name="date_end" placeholder="DD/MM/YYYY" value="" maxlength="10" required="">
                </div>
              </div>
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewSchedule">Save changes
                </button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
<!-- end bootstrap model -->
<script type="text/javascript">
$(document).ready(function($){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  showMethods();
});
</script>

<script type="text/javascript">
function table_method_row(res){
    let htmlView = '';
    if(res.data.methods.length <= 0){
        htmlView+= `
            <tr>
            <td colspan="4">Empty.</td>
            </tr>`;
    }
    for(let i = 0; i < res.data.methods.length; i++){
        htmlView += `
            <tr>
                <td>`+ (i+1) +`</td>
                <td>`+res.data.methods[i].name+`</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-primary edit-method" data-id="`+res.data.methods[i].id+`">Edit</a>
                    <a href="javascript:void(0)" class="btn btn-primary delete-method" data-id="`+res.data.methods[i].id+`">Delete</a>
                </td>
            </tr>
    `;
    }
    $('#tbody-method').html(htmlView);

    let htmlView2 = '';
    if(res.data.schedules.length <= 0){
      htmlView2+= `
            <tr>
            <td colspan="4">Empty.</td>
            </tr>`;
    }
    for(let i = 0; i < res.data.schedules.length; i++){
      htmlView2 += `
            <tr>
                <td>`+ (i+1) +`</td>
                <td>`+res.data.schedules[i].name+`</td>
                <td>`+res.data.schedules[i].date_start+`</td>
                <td>`+res.data.schedules[i].date_end+`</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-primary edit-schedule" data-id="`+res.data.schedules[i].id+`">Edit</a>
                    <a href="javascript:void(0)" class="btn btn-primary delete-schedule" data-id="`+res.data.schedules[i].id+`">Delete</a>
                </td>
            </tr>
    `;
    }
    $('#tbody-schedule').html(htmlView2);

    let htmlView3 = '';
    if(res.data.months.length <= 0){
      htmlView3+= `
            <tr>
            <td colspan="4">Empty.</td>
            </tr>`;
    }
    for(let i = 0; i < res.data.months.length; i++){
      htmlView3 += `
            <tr>
                <td>`+ (i+1) +`</td>
                <td>`+res.data.months[i].name+`</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-primary delete-month" data-id="`+res.data.months[i].id+`">Delete</a>
                </td>
            </tr>
    `;
    }
    $('#tbody-month').html(htmlView3);

    let htmlTr = '';
    let htmlHeader = '';
    htmlTr+= `
            <th>Metode</th>
            `;
    if(res.data.months.length <= 0){
      htmlHeader+= `
          <h2>Learning Activity - Year 1</h2>
            `;
      htmlTr+= `
              <td>Empty.</td>
            </tr>`;
    }
    htmlHeader+= `
          <h2>Learning Activity - Year 1 (`+res.data.months[0].name+` s/d `+res.data.months[res.data.months.length-1].name+` 2022)</h2>
            `;
    for(let i = 0; i < res.data.months.length; i++){
      htmlTr+= `
          <th>`+res.data.months[i].name+`</th>
      `;
    }
    $('#header-main').html(htmlHeader);
    $('#tr-main-months').html(htmlTr);

    let htmlMain = '';
    if(res.data.methods.length <= 0){
      htmlMain+= `
            <tr class="text-center">
              <td>Empty.</td>
            </tr>`;
    }
    for(let i = 0; i < res.data.methods.length; i++){
      htmlMain += `
            <tr class="text-center">
              <td>`+res.data.methods[i].name+`</td>
    `;
      for(let j = 0; j < res.data.months.length; j++){
        $filtered = res.data.schedules.filter(function ($item) {               
            return ($item['method_id'] == res.data.methods[i].id);
        });
        if($filtered.length > 0){
          for(let k = 0; k < $filtered.length; k++){
            if($filtered[k]['month_start'] == res.data.months[j].name){
              htmlMain += `
                      <td class="d-flex justify-content-center">
                        <table class="table-borderless">
                          <tbody>
                            <tr>
                              <td class="p-2" rowspan="2" valign="top">•</td>
                              <td class="pt-2 pl-1 pr-1 pb-0">`+$filtered[k]['name']+`</td>
                            </tr>
                            <tr>
                              <td class="text-primary pt-1 pl-1 pr-1">(`+$filtered[k]['date_start']+` - `+$filtered[k]['date_end']+`)</td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
              `;
            }
            else{
              htmlMain += `
              <td>
              </td>
              `;
            }
          }
        }
        else{
              htmlMain += `
              <td>
              </td>
              `;
            }
      }
    }

    htmlMain += `<tr class="text-center">
                  <td>Job Assignment</td>
                  <td colspan="<?php echo count($months); ?>">Sesuai penugasan</td>
                </tr>`;
    $('#tbody-main-methods').html(htmlMain);

    let htmlInput = '';
    htmlInput+= `
      <label for="method_id">Select Method:</label>
      <select class="form-control" name="method_id" id="method_id">`;
    
    for(let i = 0; i < res.data.methods.length; i++){
      htmlInput += `
        <option value="`+res.data.methods[i].id+`">`+res.data.methods[i].name+`</option>
    `;
    }
    htmlInput+= `
      </select>`;
    $('#select-method').html(htmlInput);
}

function showMethods(){
    $.ajax({
        type : 'GET',
        dataType: "json",
        url: "{{ url('get-schedules') }}",
        success : function (res) {
            table_method_row(res);
        },error : function(error){
            console.log(error);
        }
    })
}

$('#addNewMethod').click(function () {
    $('#addEditMethodForm').trigger("reset");
    $('#ajaxMethodModel').html("Add Method");
    $('#ajax-method-model').modal('show');
});

$('body').on('click', '.edit-method', function () {
    var id = $(this).data('id');
    
    // ajax
    $.ajax({
        type:"POST",
        url: "{{ url('edit-method') }}",
        data: { id: id },
        dataType: 'json',
        success: function(res){
            $('#ajaxMethodModel').html("Edit Method");
            $('#ajax-method-model').modal('show');
            $('#id').val(res.id);
            $('#title').val(res.name);
        }
    });
});

$('body').on('click', '.delete-method', function () {
    if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');
            
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-method') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              showMethods();
              $('#ajax-method-model').modal('hide');
            }
        });
    }
});

$('body').on('click', '#btn-save', function (event) {
    var id = $("#id").val();
    var name = $("#title").val();
    $("#btn-save").html('Please Wait...');
    $("#btn-save"). attr("disabled", true);
        
    // ajax
    $.ajax({
        type:"POST",
        url: "{{ url('add-update-method') }}",
        data: {
            id:id,
            name:name,
        },
        dataType: 'json',
        success: function(res){
            showMethods();
            $('#ajax-method-model').modal('hide');
            $("#btn-save").html('Submit');
            $("#btn-save"). attr("disabled", false);
        }
    });
});

$('#addNewSchedule').click(function () {
    $('#addEditScheduleForm').trigger("reset");
    $('#ajaxScheduleModel').html("Add Schedule");
    $('#ajax-schedule-model').modal('show');
});

$('body').on('click', '.edit-schedule', function () {
    var id = $(this).data('id');
    
    // ajax
    $.ajax({
        type:"POST",
        url: "{{ url('edit-schedule') }}",
        data: { id: id },
        dataType: 'json',
        success: function(res){
            $('#ajaxScheduleModel').html("Edit Schedule");
            $('#ajax-schedule-model').modal('show');
            $('#id').val(res.id);
            $('#method_id').val(res.method_id);
            $('#title').val(res.name);
            $('#date_start').val(res.date_start);
            $('#date_end').val(res.date_end);
        }
    });
});

$('body').on('click', '.delete-schedule', function () {
    if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');
            
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-schedule') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              showMethods();
              $('#ajax-schedule-model').modal('hide');
            }
        });
    }
});

$('body').on('click', '#btn-save', function (event) {
    var id = $("#id").val();
    var method_id = $("#method_id").val();
    var name = $("#title").val();
    var date_start = $("#date_start").val();
    var date_end = $("#date_end").val();
    $("#btn-save").html('Please Wait...');
    $("#btn-save"). attr("disabled", true);
        
    // ajax
    $.ajax({
        type:"POST",
        url: "{{ url('add-update-schedule') }}",
        data: {
            id:id,
            method_id:method_id,
            name:name,
            date_start:date_start,
            date_end:date_end,
        },
        dataType: 'json',
        success: function(res){
            showMethods();
            $('#ajax-schedule-model').modal('hide');
            $("#btn-save").html('Submit');
            $("#btn-save"). attr("disabled", false);
        }
    });
});

$('#addNewMonth').click(function () {
    if (confirm("Add Month?") == true) {
        var id = $(this).data('id');
            
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('add-update-month') }}",
            data: {
                id:id,
            },
            dataType: 'json',
            success: function(res){
                showMethods();
            }
        });
    }
});

$('body').on('click', '.delete-month', function () {
    if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');
            
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-month') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              showMethods();
            }
        });
    }
});
</script>

</body>
</html>