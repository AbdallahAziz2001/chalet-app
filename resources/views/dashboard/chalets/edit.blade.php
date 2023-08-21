@extends('dashboard.parent')

@section('title', 'Edit Chalet')
@section('icon', '')
@section('page-large-name', 'Edit Chalet')

@section('page-path')
    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('chalets.index') }}">Chalets</a></li>
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
                            <h3 class="card-title">Edit Chalet</h3>
                        </div>

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="create-form">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="hh"><img id="picturePreview" class="img-circle img-bordered-sm"
                                            height="50" width="50"
                                            src="{{ Storage::url('chalets/logos/' . $chalet->logo) }}" alt="Logo"> &nbsp;
                                        Logo</label>
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="logo">{{ $chalet->logo }}</label>
                                        <input type="file" class="custom-file-input" name="logo"
                                            value="{{ $chalet->logo }}" id="logo" onchange="previewImage();" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $chalet->name }}"
                                        id="name" placeholder="Enter Name" required>
                                </div>

                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" name="location"
                                        value="{{ $chalet->location }}" id="location" placeholder="Enter Location"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="number" class="form-control" name="latitude"
                                        value="{{ $chalet->latitude }}" id="latitude" placeholder="Enter Latitude"
                                        min="-90" max="90" step="0.00000001" required>
                                </div>

                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="number" class="form-control" name="longitude"
                                        value="{{ $chalet->longitude }}" id="longitude" placeholder="Enter Longitude"
                                        min="-180" max="180" step="0.00000001" required>
                                </div>

                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="country" class="form-control" name="country"
                                        value="{{ $chalet->country }}" id="country" placeholder="Enter Country" required>
                                </div>

                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="city" class="form-control" name="city" value="{{ $chalet->city }}"
                                        id="city" placeholder="Enter City" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="description" class="form-control" name="description"
                                        value="{{ $chalet->description }}" id="description" placeholder="Enter Description"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="space">Space</label>
                                    <input type="number" class="form-control" name="space"
                                        value="{{ $chalet->space }}" id="space" placeholder="Enter Space"
                                        min="0.0" max="9999.99" step="0.01" required>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="performUpdate('{{ $chalet->id }}')"
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
            fileReader.readAsDataURL(document.getElementById("logo").files[0]);

            fileReader.onload = function(fileReaderEvent) {
                document.getElementById("picturePreview").src = fileReaderEvent.target.result;
            };
        };

        function performUpdate(id) {
            let formData = new FormData();
            formData.append('_method', 'put');
            if (document.getElementById('logo').files[0] != undefined) {
                formData.append('logo', document.getElementById('logo').files[0]);
            }
            formData.append('name', document.getElementById('name').value);
            formData.append('location', document.getElementById('location').value);
            formData.append('latitude', document.getElementById('latitude').value);
            formData.append('longitude', document.getElementById('longitude').value);
            formData.append('country', document.getElementById('country').value);
            formData.append('city', document.getElementById('city').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('space', document.getElementById('space').value);

            updateWithFormData('/dashboard/chalets/' + id, formData, '/dashboard/chalets');
        }
    </script>
@endsection
