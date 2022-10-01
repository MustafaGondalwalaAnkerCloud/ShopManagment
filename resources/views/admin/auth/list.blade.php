@extends('admin.layout.app')
@section('content')
@include('admin.layout.content_header', ['header' => 'Admin', 'currenct_page' => 'List'])

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <a href="{{route('admin.add')}}" class="btn btn-primary float-right">
                                Add
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-sm-6">
                                <label>Email</label>
                                <input type="text" class="form-control" id="email" />
                            </div>
                            <div class="col-md-3 col-sm-12 col-sm-6">
                                <label>Name</label>
                                <input type="text" class="form-control" id="name" />
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12 col-sm-6">
                                <label>
                                    <button class="btn find btn-primary">Find</button>
                                    <button class="btn reset btn-warning">Reset</button>
                                </label>
                            </div>
                        </div>
                        <table class="adminTable table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer')
<script>
    $('.find').click(function(){
        $('.adminTable').DataTable().draw(true);
    });
    $('.reset').click(function(){

        $("#email").val("");
        $("#name").val("");
         $('.adminTable').DataTable().draw(true);
    });

    $('.adminTable').DataTable({
    "serverSide": true,
    "searching": false,
    "columns": [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name',orderable: false},
            {data: 'email', name: 'email',orderable: false},
            {data: 'status', name: 'status',orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
    ],
    "ajax": {
        url: "{{route('admin.list',['ajax'=>'true'])}}",
        type: 'GET',
        data: function (d) {
           d.email = $("#email").val().trim();
           d.name = $("#name").val().trim();;
        }
      },
  });
</script>
@endsection
