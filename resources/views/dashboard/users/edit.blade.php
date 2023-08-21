@extends('dashboard.parent')

@section('title', 'Edit User')
@section('icon', '')
@section('page-large-name', 'Edit User')

@section('page-path')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit User</h3>
                        </div>

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="create-form">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" name="first_name"
                                        value="{{ $user->first_name }}" id="first_name" placeholder="Enter First Name"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ $user->last_name }}" id="last_name" placeholder="Enter Last Name"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username" value="{{ $user->username }}"
                                        id="username" placeholder="Enter Username" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        @if (!is_null($user->email)) value="{{ $user->email }}" @endif id="email"
                                        placeholder="Enter Email">
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Mobile Number</label>
                                    <input type="tel" class="form-control" name="mobile" value="{{ $user->mobile }}"
                                        id="mobile" placeholder="Enter Mobile Number" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Gender</label>
                                    <div class="col-sm-6">
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="gender_male" name="gender"
                                                    @if (!is_null($user->gender)) value="Male" @endif
                                                    @if ($user->gender == 'Male') checked @endif>
                                                <label for="gender_male">
                                                    Male
                                                </label>
                                            </div>
                                            &nbsp;&nbsp;&nbsp;
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="gender_female" name="gender"
                                                    @if (!is_null($user->gender)) value="Female" @endif
                                                    @if ($user->gender == 'Female') checked @endif>
                                                <label for="gender_female">
                                                    Female
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="balance">Birthday</label>
                                    <input type="date" class="form-control" name="birthday"
                                        @if (!is_null($user->birthday)) value="{{ $user->birthday->format('Y-m-d') }}" @endif
                                        id="birthday" placeholder="Enter Birthday" min="0.0" max="999999.99"
                                        step="0.01">
                                </div>

                                <div class="form-group">
                                    <label for="balance">Balance</label>
                                    <input type="number" class="form-control" name="balance" value="{{ $user->balance }}"
                                        id="balance" placeholder="Enter Balance" min="0.0" max="999999.99"
                                        step="0.01">
                                </div>

                                <div class="form-group">
                                    <label for="hh"><img id="picturePreview" class="img-circle img-bordered-sm"
                                            height="50" width="50"
                                            src="{{ Storage::url('users/' . $user->account_picture) }}"
                                            alt="Account Picture"> &nbsp; Account
                                        Picture</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label"
                                            for="account_picture">{{ $user->account_picture }}</label>
                                        <input type="file" class="custom-file-input" name="account_picture"
                                            value="{{ $user->account_picture }}" id="account_picture"
                                            onchange="previewImage();" required>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="performUpdate('{{ $user->id }}')"
                                    class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script src="{{ asset('dashboard/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $('.roles').select2({
            theme: 'bootstrap4'
        });

        $(function() {
            bsCustomFileInput.init();
        });

        function previewImage() {
            var fileReader = new FileReader();
            fileReader.readAsDataURL(document.getElementById("account_picture").files[0]);

            fileReader.onload = function(fileReaderEvent) {
                document.getElementById("picturePreview").src = fileReaderEvent.target.result;
            };
        };

        function performUpdate(id) {
            let formData = new FormData();
            formData.append('_method', 'put');
            formData.append('first_name', document.getElementById('first_name').value);
            formData.append('last_name', document.getElementById('last_name').value);
            formData.append('username', document.getElementById('username').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('mobile', document.getElementById('mobile').value);
            var radioValues = document.forms[0].elements['gender'];
            for (var i = 0; i < radioValues.length; i++) {
                if (radioValues[i].checked) {
                    formData.append('gender', radioValues[i].value);
                    console.log(radioValues.value);
                    break;
                }
            }
            formData.append('birthday', document.getElementById('birthday').value);
            formData.append('balance', document.getElementById('balance').value);
            if (document.getElementById('account_picture').files[0] != undefined) {
                formData.append('account_picture', document.getElementById('account_picture').files[0]);
            }
            updateWithFormData('/dashboard/users/' + id, formData, '/dashboard/users');
        }
    </script>
@endsection
