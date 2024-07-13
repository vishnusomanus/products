@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Product</h1>
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
        <form id="product-form" enctype="multipart/form-data" action="{{ route('products.update', $product) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $product->title }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required>{{ $product->description }}</textarea>
            </div>

            <div class="image_area">
                <button type="button" class="btn btn-primary mt-2 mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Upload / Choose image
                </button>
                <input type="hidden" name="main_image" id="main_image" value="{{ $product->main_image }}" >
                <div class="img_thump"><img src="{{ $product->main_image }}" width="75px" class=""></div>
            </div>

            <input type="hidden" value="" name="variants" id="variants_hidden">
            <div id="variants-container">
                <div class="form-group " id="variant-items">
                    <label for="variants">Variants:</label>
                    @if($product->variants)
                        @foreach($product->variants as $key => $variant)
                            <div class="row variant-item mt-2 mb-2">
                                <div class="col-md-4">
                                    <input type="text" class="form-control variant-name" name="variant[{{ $key }}][name]" value="{{ $variant['name'] }}" placeholder="Variant Name" required>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control variant-values" name="variant[{{ $key }}][values]" value="{{ implode(', ', $variant['values']) }}" placeholder="Variant Values (comma-separated)" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-remove-variant">Remove</button>
                                </div>
                            </div>
                        @endforeach
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
