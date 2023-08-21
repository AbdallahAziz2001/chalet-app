@extends('dashboard.parent')

@section('title', 'Admins')
@section('icon', '')
@section('page-large-name', 'Admins')

@section('page-path')
<li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
<li class="breadcrumb-item active">Admins</li>
@endsection

@section('styles')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bordered Table</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 75px">Picture</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Settings</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                <tr>
                                    <td style="vertical-align: middle;">{{ $admin->id }}</td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <img class="img-circle img-bordered-sm" height="50" width="50" src="{{ Storage::url('admins/' . $admin->account_picture) }}" alt="Account Picture">
                                    </td>
                                    <td style="vertical-align: middle;">{{ $admin->first_name }}</td>
                                    <td style="vertical-align: middle;">{{ $admin->last_name }}</td>
                                    <td style="vertical-align: middle;"><span style="font-size: 18px; vertical-align:middle" class="badge bg-info">{{ $admin->username }}</span></td>
                                    <td style="vertical-align: middle;">
                                        {{ $admin->created_at->format('d/m/Y h:i:s a') }}
                                    </td>
                                    <td style="vertical-align: middle;">
                                        {{ $admin->updated_at->format('d/m/Y h:i:s a') }}
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <div class="btn-group">
                                            <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a onclick="performDelete({{ $admin->id }}, this)" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
@endsection

@section('scripts')

<script>
    function performDelete(id, reference) {
        confirmDestroy('/dashboard/admins', id, reference)
    }
</script>
@endsection

{{-- Swal.fire(
'Deleted!',
'Your file has been deleted.',
'success'
) --}}