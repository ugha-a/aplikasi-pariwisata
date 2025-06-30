@extends('layouts.app')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 d-flex justify-content-between">
                    <h1 class="m-0">{{ __('Form Create') }}</h1>
                    <a href="{{ route('admin.locations.index') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card p-3">
                        <form method="post" action="{{ route('admin.locations.update', $location) }}">

                            @csrf
                            @method('PUT')
                        
                            <div class="form-group row border-bottom pb-4">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name', $location->name) }}" placeholder="Enter location name">
                                </div>
                            </div>
                        
                            <div class="form-group row border-bottom pb-4">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="description" id="description" rows="5">{{ old('description', $location->description) }}</textarea>
                                </div>
                            </div>
                        
                            <div class="form-group row border-bottom pb-4">
                                <label for="lat" class="col-sm-2 col-form-label">Latitude</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="lat" id="lat"
                                        value="{{ old('lat', $location->lat) }}" placeholder="e.g., -6.200000">
                                </div>
                            </div>
                        
                            <div class="form-group row border-bottom pb-4">
                                <label for="lag" class="col-sm-2 col-form-label">Longitude</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="lag" id="lag"
                                        value="{{ old('lag', $location->lag) }}" placeholder="e.g., 106.816666">
                                </div>
                            </div>
                        
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .ck-editor__editable_inline {
        min-height: 200px;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection