const baseUrl = 'http://127.0.0.1:8000';
// function for show posts without refresh
showMethods();
// table row with ajax
function table_post_row(res){
    let htmlView = '';
    if(res.posts.length <= 0){
        htmlView+= `
            <tr>
            <td colspan="4">Empty.</td>
            </tr>`;
    }
    for(let i = 0; i < res.posts.length; i++){
        htmlView += `
            <tr>
                <td>`+ (i+1) +`</td>
                <td>`+res.posts[i].name+`</td>
                <td>
                    <button id="editModal" data-action="`+baseUrl+`/post/`+res.posts[i].id+`/update" data-id="`+res.posts[i].id+`" class="btn btn-warning btn-sm">Edit</button>
    <button id="btn-delete" data-id="`+res.posts[i].id+`" class="btn btn-danger btn-sm">Delete</button>
    </td>
    </tr>
    `;
    }
    $('#tbody').html(htmlView);
}
function showMethods(){
    $.ajax({
        type : 'GET',
        dataType: "json",
        url  : baseUrl+'/schedules',
        success : function (res) {
            table_post_row(res);
        },error : function(error){
            console.log(error);
        }
    })
}

$('button#openModal').click(function() {
    let url = $(this).data('action');
    $('#exampleModal').modal('show');
    $('#formData').trigger("reset");
    $('#formData').attr('action',url);
})
// Event for created and updated posts
$('#formData').submit(function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
            type: 'POST',
            data : formData,
            contentType: false,
            processData: false,
            url: $(this).attr('action'),
            beforeSend:function(){
                $('#btn-create').addClass("disabled").html("Processing...").attr('disabled',true);
                $(document).find('span.error-text').text('');
            },
            complete: function(){
                $('#btn-create').removeClass("disabled").html("Save   Change").attr('disabled',false);
            },
            success: function(res){
                console.log(res);
                if(res.success == true){
                    $('#formData').trigger("reset");
                    $('#exampleModal').modal('hide');
                    showMethods(); // call function show Posts
                    Swal.fire(
                        'Success!',
                        res.message,
                        'success'
                    )
                }
            },
            error(err){
                $.each(err.responseJSON,function(prefix,val) {
                    $('.'+prefix+'_error').text(val[0]);
                })
                console.log(err);
            }
    })
})

//open edit modal
$(document).on('click','button#editModal',function() {
    let id = $(this).data('id');
    let dataAction = $(this).data('action');
    $('#formData').attr('action',dataAction);
    $.ajax({
            type: 'GET',
            url : baseUrl+`/post/${id}/edit`,
            dataType: "json",
            success: function(res) {
                $('input[name=title]').val(res.post.title);
                $('textarea[name=post_content]').val(res.post.post_content);
                $('#exampleModal').modal('show');
                console.log(res);
            },
            error:function(error) {
                console.log(error)
            }
    })
})

$(document).on('click','button#btn-delete',function(e) {
    e.preventDefault();
    let dataDelete = $(this).data('id');
    // console.log(dataDelete);
    Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this! ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type:'DELETE',
                dataType: 'JSON',
                url: baseUrl+`/delete-method`,
                data:{
                    '_token':$('meta[name="csrf-token"]').attr('content'),
                },
                success:function(response){
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    showMethods();
                },
                error:function(err){
                    console.log(err);
                }
            });
        }
    })
});