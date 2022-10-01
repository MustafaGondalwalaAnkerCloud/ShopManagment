<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{ $header }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            @isset($subPage)
            <li class="breadcrumb-item"><a href="{{ $subPageUrl }}">{{$subPage}}</a></li>
            @endisset()
            <li class="breadcrumb-item active">{{ $currenct_page }}</li>
          </ol>
        </div>
      </div>
  </section>
