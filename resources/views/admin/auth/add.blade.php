@extends('admin.layout.app')
@section('content')
@include('admin.layout.content_header', ['header' => 'Admin', 'currenct_page' => 'Add'])

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-lg-12">
                <div class="card card-primary">


                    <form method="post" action="{{ route('admin.store', ['admin' => $admin]) }}"
                        enctype="multipart/form-data">
                        @csrf



                        <div class="card-body">
                            @include('admin.utils.show_error')
                            @include('admin.utils.show_success')
                            <input type="hidden" name="id" value="{{ $admin->encrypted_id }}"/>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" class="form-control" value="{{ old('name',$admin->name) }}"
                                    name="name">
                            </div>

                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="text" id="email" class="form-control"
                                    value="{{ old('email',$admin->email) }}" name="email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="" disabled>Select</option>
                                    <option value="1" <?php if($admin->exists() != null && $admin->status=='1'){ echo
                                        'selected'; }?>>Active</option>
                                    <option value="0" <?php if($admin->exists() != null && $admin->status=='0'){ echo
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
