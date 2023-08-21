@extends('dashboard.parent')

@section('title', 'Chalets')
@section('icon', '')
@section('page-large-name', 'Chalets')

@section('page-path')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Chalets</li>
@endsection

@section('styles')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example1"
                                            class="table table-bordered table-striped dataTable dtr-inline"
                                            aria-describedby="example1_info">
                                            <thead>
                                                <tr>
                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="Rendering engine: activate to sort column descending">
                                                        #
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        Logo
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        Name
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        Location
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        Coordinates
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        Country
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        City
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        Description
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        Space
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        Created At
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        Updated At
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        Settings
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($chalets as $chalet)
                                                    <tr>
                                                        <td style="vertical-align: middle;">
                                                            {{ $chalet->id }}</td>
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            <img class="img-circle img-bordered-sm" height="50"
                                                                width="50"
                                                                src="{{ Storage::url('chalets/logos/' . $chalet->logo) }}"
                                                                alt="Logo">
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $chalet->name }}</td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $chalet->location }}</td>
                                                        <td style="vertical-align: middle;font-size: 14px;">
                                                            <a target="_blank"
                                                                href="https://www.google.com/maps/search/?api=1&query={{ $chalet->latitude . ',' . $chalet->longitude }}">{{ $chalet->latitude }},<br>{{ $chalet->longitude }}
                                                            </a>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $chalet->country }}</td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $chalet->city }}</td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $chalet->description }}</td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $chalet->space }}</td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $chalet->created_at->format('d/m/Y h:i:s a') }}
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $chalet->updated_at->format('d/m/Y h:i:s a') }}
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <div class="btn-group">
                                                                <a href="{{ route('chalets.edit', $chalet->id) }}"
                                                                    class="btn btn-info">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <a onclick="performDelete({{ $chalet->id }}, this)"
                                                                    class="btn btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th rowspan="1" colspan="1">#</th>
                                                    <th rowspan="1" colspan="1">Logo</th>
                                                    <th rowspan="1" colspan="1">Name</th>
                                                    <th rowspan="1" colspan="1">Location</th>
                                                    <th rowspan="1" colspan="1">Coordinates</th>
                                                    <th rowspan="1" colspan="1">Country</th>
                                                    <th rowspan="1" colspan="1">City</th>
                                                    <th rowspan="1" colspan="1">Description</th>
                                                    <th rowspan="1" colspan="1">Space</th>
                                                    <th rowspan="1" colspan="1">Created At</th>
                                                    <th rowspan="1" colspan="1">Updated At</th>
                                                    <th rowspan="1" colspan="1">Settings</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class="row">
                                            <div class="col-sm-4">
                                            </div>
                                            <div class="col-sm-6">
                                                {{ $chalets->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')

    <script src="{{ asset('dashboard/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "paging": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>

    <script>
        function performDelete(id, reference) {
            confirmDestroy('/dashboard/chalets', id, reference)
        }
    </script>
@endsection
