@extends('dashboard.parent')

@section('title', 'Change Password')
@section('icon', '')
@section('page-large-name', 'Change Password')

@section('styles')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Change Password</h3>
                        </div>

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="change-password-form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="password">Current Password</label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Enter current password">
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" class="form-control" id="new_password"
                                        placeholder="Enter new password">
                                </div>
                                <div class="form-group">
                                    <label for="new_password_confirmation">New Password Confirmation</label>
                                    <input type="password" class="form-control" id="new_password_confirmation"
                                        placeholder="Confirm new password">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="chnagePassword()" class="btn btn-primary">Submit</button>
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
    <script>
        function chnagePassword() {
            axios.post('/dashboard/change-password', {
                    password: document.getElementById('password').value,
                    new_password: document.getElementById('new_password').value,
                    new_password_confirmation: document.getElementById('new_password_confirmation').value,
                }).then(function(response) {
                    console.log(response);
                    document.getElementById('change-password-form').reset();
                    toastr.success(response.data.message)
                })
                .catch(function(error) {
                    console.log(error);
                    toastr.error(error.response.data.message)
                });
        }
    </script>
@endsection
