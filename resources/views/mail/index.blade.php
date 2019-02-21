@extends('welcome')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card text-white bg-info" >
                <div class="card-header">Email Form</div>
                    <div class="card-body ">
                        <form id="myform" action="{{ action('MailController@sendMail') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="subject" class="col-sm-2 col-form-label">To:</label>
                                <div class="col-sm-12">
                                    <input class="form-control"  type="email" id="email" name="email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-sm-2 col-form-label">CC:</label>
                                <div class="col-sm-12">
                                    <input class="form-control"  type="text" id="cc" name="cc">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-sm-2 col-form-label">BCC:</label>
                                <div class="col-sm-12">
                                    <input class="form-control"  type="text" id="bcc" name="bcc">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-sm-2 col-form-label">Subject:</label>
                                <div class="col-sm-12">
                                    <input class="form-control"  type="text" id="subject" name="subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <textarea name="description" id="description" cols="30" rows="10">
                                        @include('mail.templates')
                                    </textarea>
                                </div>     
                            </div>
                            <button class="sendmailBtn" type="button">Send Email</button>
                        </form>
                    </div>
                </div>
            </div>
        <div class="col md-2"></div>
    </div>
</div>

@endsection

@section('js')
    <script>
        CKEDITOR.replace('description',{
            height: '350'
        });
        CKEDITOR.config.allowedContent = true;  
        CKEDITOR.config.extraPlugins = 'sourcedialog';
        CKEDITOR.config.removePlugins = 'sourcearea';
        CKEDITOR.config.fullPage = true;
       
       $(document).ready(function(){
            $('.sendmailBtn').click(function(e) {
                
                var html = CKEDITOR.instances.description.getData();
                /*----Initialize TextBox----*/
                var email = $('#email').val();
                var cc = $('#cc').val();
                var bcc = $('#bcc').val();
                var subject = $('#subject').val();
                var description = $('#description').val();

                /*----Validation Email----*/
                var isValid = true;
                $('#email').each(function () {
                    if ($.trim($(this).val()) == '') {
                        isValid = false;
                        $(this).css({
                            "border": "1px solid red",
                            "background": "#FFCECE"
                        });
                    }
                    else {
                        $(this).css({
                            "border": "",
                            "background": ""
                        });
                    }
                });
                if (isValid == false)
                    e.preventDefault();

                /*---Send Email----*/
                $.ajax({
                    type: 'POST',
                    url: '/sendMail',
                    data: {
                        email: email,
                        cc:cc,
                        bcc:bcc,
                        subject:subject,
                        description:description,
                        _token: '{{csrf_token()}}'
                    },
                    success: function () {
                        alert('Successed...!');
                        $('#email').val('');
                        $('#cc').val('');
                        $('#bcc').val('');
                        $('#subject').val('');
                        $('#description').val('');
                    },
                    error: function ()
                    {	
                        alert('Failed...!');					
                    }
                });
            });
       });
       
    </script>
   
@endsection

