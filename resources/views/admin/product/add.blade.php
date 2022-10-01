@extends('admin.layout.app')
@section('content')
@include('admin.layout.content_header', ['header' => 'Product', 'currenct_page' => 'Add','subPage' => "Product", 'subPageUrl' => route('admin.product.list')])

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card card-primary">


                    <form method="post" action="{{ route('admin.product.store', ['product' => $product]) }}"
                        enctype="multipart/form-data">
                        @csrf



                        <div class="card-body">
                            @include('admin.utils.show_error')
                            @include('admin.utils.show_success')
                            <input type="hidden" name="id" value="{{ $product->encrypted_id }}"/>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" class="form-control" value="{{ old('name',$product->name) }}"
                                    name="name">
                            </div>
                            <div class="form-group">
                                <label for="sku">Sku</label>
                                <input type="text" id="sku" class="form-control" value="{{ old('sku',$product->sku) }}"
                                    name="sku">
                            </div>
                            
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" id="model" class="form-control" value="{{ old('model',$product->model) }}"
                                    name="model">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" id="description" class="form-control" name="description">{{ old('description',$product->description) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                @include('admin.product.utils.allCategories', ['categoryId' => @$product->category_id])
                                
                            </div>
                            <div class="form-group">
                                <label for="sub_category_id">Sub Category</label>
                                @include('admin.product.utils.allSubCategories', ['categoryId' => @$product->category_id,'subCategoryId' => @$product->sub_category_id])
                            </div>

                            <div class="form-group">
                                <label for="model">Mrp</label>
                                <input type="number" id="mrp" class="form-control" value="{{ old('mrp',$product->mrp) }}"
                                    name="mrp">
                            </div>
                            <div class="form-group">
                                <label for="sale_price">Sale Price</label>
                                <input type="number" id="sale_price" class="form-control" value="{{ old('sale_price',$product->sale_price) }}"
                                    name="sale_price">
                            </div>
                            

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="" disabled>Select</option>
                                    <option value="1" <?php if($product->exists() != null && $product->status=='1'){ echo
                                        'selected'; }?>>Active</option>
                                    <option value="0" <?php if($product->exists() != null && $product->status=='0'){ echo
                                        'selected'; }?>>InActive</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
