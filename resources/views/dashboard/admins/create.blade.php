@extends('dashboard.parent')

@section('title', 'Create Admin')
@section('icon', '')
@section('page-large-name', 'Create Admin')

@section('page-path')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('admins.index') }}">Admins</a></li>
    <li class="breadcrumb-item active">Create</li>
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
                            <h3 class="card-title">Create Admin</h3>
                        </div>

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="create-form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                        placeholder="Enter First Name">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                        placeholder="Enter Last Name">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username" id="username"
                                        placeholder="Enter Username">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Enter Password">
                                </div>

                                <div class="form-group">
                                    <label for="hh">Account Picture</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="account_picture">Choose Accout Picture</label>
                                        <input type="file" class="custom-file-input" name="account_picture"
                                            id="account_picture">
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="performStore()" class="btn btn-primary">Submit</button>
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
    <script>
        $('.roles').select2({
            theme: 'bootstrap4'
        });

        function performStore() {
            let data = new FormData();
            data.append('first_name', document.getElementById('first_name').value);
            data.append('last_name', document.getElementById('last_name').value);
            data.append('username', document.getElementById('username').value);
            data.append('password', document.getElementById('password').value);
            data.append('account_picture', document.getElementById('account_picture').files[0]);
            store('/dashboard/admins', data);
        }
    </script>
@endsection
