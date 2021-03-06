@extends('layouts.app')

@section('content')

{{-- AddStudentModal --}}

<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Estudantes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>            

            <div class="modal-body">
            
            <ul id="saveform_errList"></ul>

                <div class="form-group mb-3">
                    <label for="">Nome</label>
                    <input type="text" class="name form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Email</label>
                    <input type="text" class="email form-control">                    
                </div>
                <div class="form-group mb-3">
                    <label for="">Telefone</label>
                    <input type="text" class="phone form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Curso</label>
                    <input type="text" class="course form-control">
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary add_student">Salvar</button>
            </div>
        </div>
    </div>
</div>

{{-- End AddStudentModal --}}

{{-- EditStudentModal--}}
<div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar e Atualizar Estudante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>            

            <div class="modal-body">
            
            <ul id="updateform_errList"></ul>

                <input type="hidden" id="edit_stud_id">
                <div class="form-group mb-3">
                    <label for="">Nome</label>
                    <input type="text" id="edit_name" class="name form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Email</label>
                    <input type="text" id="edit_email" class="email form-control">                    
                </div>
                <div class="form-group mb-3">
                    <label for="">Telefone</label>
                    <input type="text" id="edit_phone" class="phone form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Curso</label>
                    <input type="text" id="edit_course" class="course form-control">
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary update_student">Atualizar</button>
            </div>
        </div>
    </div>
</div>
{{--End EditStudentModal--}}

{{-- DeletetudentModal--}}
<div class="modal fade" id="DeleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Estudante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>            

            <div class="modal-body">
            
                <input type="hidden" id="delete_stud_id">
                
                <h4>Processo de exclus??o. Deseja prosseguir?</h4>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary delete_student_btn">Sim Excluir</button>
            </div>
        </div>
    </div>
</div>
{{--End DeleteStudentModal--}}


 <div class="container py-5">
     <div class="row">
         <div class="col-md-12">

            <div id="success_message"></div>

             <div class="card">
                 <div class="card-header">
                     <h4>Dados dos Estudantes
                     <a href="#" data-bs-toggle="modal" data-bs-target="#AddStudentModal" class="btn btn-primary float-end btn-sm">Adicionar</a>
                     </h4>
                 </div>
                 <div class="card-body">
                     <Table class="table table-bordered table-striped">
                         <thead>
                             <tr>
                                 <th>ID</th>
                                 <th>Nome</th>
                                 <th>Email</th>
                                 <th>Telefone</th>
                                 <th>Curso</th>
                                 <th>Editar</th>
                                 <th>Deletar</th>
                             </tr>
                         </thead>
                         <tbody>
                         </tbody>
                       </Table>
                 </div>
             </div>
         </div>
     </div>
 </div>


@endsection

@section('scripts')

<script>



    $(document).ready(function(){

        fetchStudent();

        function fetchStudent(){
            $.ajax({
                type:"GET",
                url:"/fetch-students",                
                datatype:"json",
                success:function(response){ 
                    //console.log(response.students);
                    $('tbody').html("");
                    $.each(response.students,function(key, item){
                        $('tbody').append('<tr>\
                                 <td>'+item.id+'</td>\
                                 <td>'+item.name+'</td>\
                                 <td>'+item.email+'</td>\
                                 <td>'+item.phone+'</td>\
                                 <td>'+item.course+'</td>\
                                 <td><button type="button" value="'+item.id+'" class="edit_student btn btn-primary btn-sm">Edit</button></td>\
                                 <td><button type="button" value="'+item.id+'" class="delete_student btn-danger btn-sm">Delete</button></td>\
                        </tr>');
                    });
                }
            });
        }

        $(document).on('click','.delete_student',function(e){
            e.preventDefault();

            var stud_id = $(this).val();
            //alert(stud_id);

            $('#delete_stud_id').val(stud_id);
            $('#DeleteStudentModal').modal('show');

        });

        $(document).on('click','.delete_student_btn',function(e){
            e.preventDefault();

            $(this).text("Excluindo");

            var stud_id = $('#delete_stud_id').val();

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });             

            $.ajax({
                type: "DELETE",
                url: "/delete-student/"+stud_id,                
                success: function(response){
                    //console.log(response);

                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('#DeleteStudentModal').modal('hide');
                    $('.delete_stud_id').text("Sim Excluir");  
                    fetchStudent();
                }
            });
        });

        $(document).on('click','.edit_student',function(e){
            e.preventDefault();
            var stud_id = $(this).val();
            //console.log(stud_id);
            $('#EditStudentModal').modal('show');

            $.ajax({
                type:"GET",
                url:"/edit-student/"+stud_id,                                
                success:function (response){
                    //console.log(response);
                    if(response.status == 404){
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(response.message);
                    }else{
                        $('#edit_name').val(response.student.name);
                        $('#edit_email').val(response.student.email);
                        $('#edit_phone').val(response.student.phone);
                        $('#edit_course').val(response.student.course);
                        $('#edit_stud_id').val(stud_id);

                    }
                }
            });
        });

        $(document).on('click','.update_student',function(e){
            e.preventDefault(e);

            $(this).text("Atualizando");

            var stud_id = $('#edit_stud_id').val();
            var data = {
                'name' : $('#edit_name').val(),
                'email' : $('#edit_email').val(),
                'phone' : $('#edit_phone').val(),
                'course' : $('#edit_course').val(),
            }

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "PUT",
                url: "/update-student/"+stud_id,
                data: data,
                datatype: "json",
                success: function (response){
                    //console.log(response);
                    if(response.status == 400){
                        //errors
                        $('#updateform_errList').html("");
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');                                                
                        });
                        
                        $('.update_student').text("Atualizado");

                    }else if(response.status == 404){
                        $('#updateform_errList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message); 

                        $('.update_student').text("Atualizado");

                    }else{
                        $('#updateform_errList').html("");
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message); 

                        $('#EditStudentModal').modal('hide');
                        $('.update_student').text("Atualizado");
                        fetchStudent();

                    }
                }
            });
            
        });



        $(document).on('click','.add_student',function(e){
            e.preventDefault();            

            var data = {
                'name': $('.name').val(),
                'email': $('.email').val(),
                'phone': $('.phone').val(),
                'course': $('.course').val(),
            }

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:"POST",
                url:"/students",
                data: data,
                datatype:"json",
                success: function(response){
                    //console.log(response);                    
                    if(response.status == 400){
                        $('#saveform_errList').html("");
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                        $('#saveform_errList').append('<li>'+err_values+'</li>');
                    });
                    } else {
                        $('#saveform_errList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#AddStudentModal').modal('hide');
                        $('#AddStudentModal').find('input').val("");
                        fetchStudent();
                    }

                }
            });


        });

    });
        
</script>

@endsection