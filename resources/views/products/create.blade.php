@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Product</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="product-form" method="post" enctype="multipart/form-data" action="{{ route('products.store') }}">
            @csrf
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
            </div>
            
            <div class="image_area">
                <button type="button" class="btn btn-primary mt-2 mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Upload / Choose image
                </button>
                <input type="hidden" name="main_image" id="main_image" value="{{ old('main_image') }}" >
                <div class="img_thump">
                    @if(old('variants'))
                        <img src="{{ old('main_image') }}" width="75px" class="">
                    @endif
                </div>
            </div>
            
            <div id="variants-container">
                <input type="hidden" value="" name="variants" value="{{ old('variants') }}" id="variants_hidden">
                <div class="form-group mt-2 mb-2" id="variant-items">
                    <label for="variants">Variants</label>
                    @if(old('variants'))
                        @php
                            $variants = json_decode(old('variants'), true);
                        @endphp
                        @foreach($variants as $index => $variant)
                            <div class="row variant-item">
                                <div class="col-md-4">
                                    <input type="text" class="form-control variant-name" name="variant[{{ $index }}][name]" value="{{ $variant['name'] }}" placeholder="Variant Name" required>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control variant-values" name="variant[{{ $index }}][values]" value="{{ implode(', ', $variant['values']) }}" placeholder="Variant Values (comma-separated)" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-remove-variant">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="form-group variant-item mt-2 mb-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control variant-name" placeholder="Variant Name" required>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control variant-values" placeholder="Variant Values (comma-separated)" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-remove-variant">Remove</button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="add-variant">Add Variant</button>
            <hr>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>

    
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-l">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Gallery</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="imageUploadForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="uploadMainImage">Choose an image</label>
                        <input type="file" class="form-control" id="uploadMainImage" >
                    </div>
                </form>
                <div class="image_grid mt-4">
                    @foreach($images as $image)
                        <img src="{{ $image->image_path }}" width="75px" class="sel_img"/>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

@endsection