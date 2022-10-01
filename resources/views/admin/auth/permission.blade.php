@extends('admin.layout.app')
@section('content')
@php

$user = Auth::user();
@endphp

<div class="main-content">
   <div class="content-overlay"></div>
   <div class="content-wrapper">
      <div class="row">
         <div class="">
            <div class="content-header">{{ __('G&G') }}</div>
         </div>
      </div>
      <section id="basic-hidden-label-form-layouts">
         <div class="row match-height">
            <div class="col-lg-12 ">
               <div class="card" >
                  <div class="card-header">
                     <h4 class="card-title">
                        <a href="{{route('admin.list')}}" class="btn btn-primary float-right">
                            Back
                        </a>
                     </h4>
                  </div>
                  <div class="card-content">
                     <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                           @csrf
                           @if(count($errors) > 0 )
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <ul class="p-0 m-0" style="list-style: none;">
                                        @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                              @endif

                              <div class="col-md-6 ">
                                 <div class="form-group mb-2">
                                    <label for="name">Name</label>
                                    <input type="text" disabled id="name" class="form-control"  value="{{ old('name',$admin->name) }}"  name="name">
                                 </div>
                              </div>
                              <table class="table table-striped table-bordered">
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Key</th>
                                        <th>Permission</th>
                                    </tr>
                                @php
                                    $key = 0;
                                @endphp
                                @foreach ($permissions as $permission =>  $subPermissions)
                                    <tr>
                                        <th>{{ ++$key }}</th>
                                        <td>{{ $permission }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($subPermissions as $subPermission)
                                                    @php
                                                        $permission_string = $permission.$seprator.$subPermission;
                                                    @endphp
                                                    <li>
                                                        <label for="{{ $permission_string }}"> {{ $subPermission }} </label> <input  id="{{ $permission_string }}" type="checkbox" name="permission[{{ $permission_string }}]" {{ $allPermissions->contains($permission_string) == true ?  "checked='checked'" : ''}}>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                              </table>
                              <button type="submit" class="btn btn-primary mr-2"><i class="ft-check-square mr-1"></i>Save</button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            </form>
         </div>
   </div>
</div>
</div>
</div>
</section>
</div>
</div>
@endsection
