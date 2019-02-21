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
                                        {{-- <i class="material-icons">close</i> --}}
                                    <input class="form-control"  type="email" id="email" name="email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-sm-2 col-form-label">CC:</label>
                                <div class="col-sm-12">
                                    {{-- <i class="material-icons">close</i> --}}
                                    <input class="form-control"  type="text" id="cc" name="cc">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-sm-2 col-form-label">BCC:</label>
                                <div class="col-sm-12">
                                        {{-- <i class="material-icons">close</i> --}}
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

                /*----Validation----*/
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
                    },
                    error: function ()
                    {	
                        alert('Failed...!');					
                    }
                });
            });

            /*---HTML Tage---*/
            const tagContainer = document.querySelector('.tag-container');
            const input = document.querySelector('.tag-container input');

            let tags = [];

            function createTag(label) {
                const div = document.createElement('div');
                div.setAttribute('class', 'tag');
                const span = document.createElement('span');
                span.innerHTML = label;
                const closeIcon = document.createElement('i');
                closeIcon.innerHTML = 'close';
                closeIcon.setAttribute('class', 'material-icons');
                closeIcon.setAttribute('data-item', label);
                div.appendChild(span);
                div.appendChild(closeIcon);

                return div;
            }

            function clearTags() {
                document.querySelectorAll('.tag').forEach(tag => {
                    tag.parentElement.removeChild(tag);
                });
            }

            function addTags() {
                clearTags();
                tags.slice().reverse().forEach(tag => {
                    tagContainer.prepend(createTag(tag));
                });
            }

            input.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') {
                e.target.value.split(',').forEach(tag => {
                tags.push(tag);  
                });
                
                addTags();
                input.value = '';
            }
            });
            document.addEventListener('click', (e) => {
                console.log(e.target.tagName);
                if (e.target.tagName === 'I') {
                    const tagLabel = e.target.getAttribute('data-item');
                    const index = tags.indexOf(tagLabel);
                    tags = [...tags.slice(0, index), ...tags.slice(index+1)];
                    addTags();    
                }
            })
       });
       
    </script>
   
@endsection
@section('css')
<style>
        @import url('https://fonts.googleapis.com/icon?family=Material+Icons');
        body {
            background: #fafafa;
        }
        .tag-container {
            // border: 2px solid #ccc;
            // border-radius: 3px;
            background: #FFFFFF;
            display: flex;
            // flex-wrap: wrap;
            // align-content: flex-start;
            // padding: 6px;
            // overflow-x: scroll;
            }
            .tag-container .tag {
                // height: 30px;
                margin: 5px;
                padding: 5px 6px;
                // border: 1px solid #ccc;
                border-radius: 3px;
                background: #eee;
                // display: flex;
                align-items: center;
                color: #333;
                // box-shadow: 0 0 4px rgba(0, 0, 0, 0.2), inset 0 1px 1px #fff;
                cursor: default;
            }
            .tag i {
                font-size: 16px;
                color: #666;
                margin-left: 5px;
            }
            .tag-container input {
                // padding: 5px;
                // font-size: 16px;
                // border: 0;
                // outline: none;
                // font-family: 'Rubik';
                // color: #333;
                // flex: 1;
            }

    </style>
@endsection

