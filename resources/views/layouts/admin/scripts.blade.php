<script type="text/javascript">

    function deleteItem(attr){
    swal({
        title: "{{ __('admin.sure')}}",
        //text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "{{ __('admin.yes')}}",
        cancelButtonText: "{{ __('admin.no')}}",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            swal("{{ __('admin.deleted')}}", "", "success");
        $(attr).submit();
        } else {
            swal("{{ __('admin.cancelled')}}", "", "error");
        }
    });
    }
        

    $('#add_user').on('submit', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
console.log(new FormData(this));
        $.ajax({
            type: 'POST',
            url: "{{route('admin.users.store')}}",
            data : new FormData(this),
            contentType: false,       
            cache: false,             
            processData:false, 
            success: function (data) {
                console.log(data.code);
                $('.alert').remove();
                if(data.code == 5001){
                    $('#name').after(`<div class="alert alert-danger">`+data.msg+`</div>`);
                }else if(data.code == 5002){
                    $('#email').after(`<div class="alert alert-danger">`+data.msg+`</div>`);
                }else if(data.code == 5003){
                    $('#phone').after(`<div class="alert alert-danger">`+data.msg+`</div>`);
                }else if(data.code == 5004){
                    $('#password').after(`<div class="alert alert-danger">`+data.msg+`</div>`);
                }else{
                    console.log(data);
                    $('#addUserModal').modal('hide');
                    $('.table tbody').append(
                        `<tr>
                            <td>1</td>
                            <td><img src="${data.image}" style="width: 50px;height:50px;border-radius:50%"></td>
                            <td>${data.name}</td>
                            <td>${data.email}</td>
                            <td>  
                            <a href="/admin/users/${data.id}/edit " class="btn btn-info"><i class="fa fa-edit"></i> </a>
                            <a href="#" class="btn btn-danger deleteNotify" id="deleteNotify" onclick="deleteItem('#delete_item_${data.id}')"><i class="fa fa-trash"></i> </a>
                            <form action="/admin/users/${data.id}" method="POST" id="delete_item_${data.id}">
                            @csrf
                            <input type="hidden" name="_method" value="delete"/>
                            </form>
                            </td>

                        </tr>`
                    )
                }
            }
            }
        );
    });


    function dragNdrop(event) {
        var fileName = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById("preview");
        var previewImg = document.createElement("img");
        previewImg.setAttribute("src", fileName);
        preview.innerHTML = "";
        preview.appendChild(previewImg);
    }
    function drag() {
        document.getElementById('uploadFile').parentNode.className = 'draging dragBox';
    }
    function drop() {
        document.getElementById('uploadFile').parentNode.className = 'dragBox';
    }
            

    
    $('.select_with_search').selectize({
        sortField: 'text'
    });

</script>