@php
    $subCategories = getSubCategories($categoryId);
@endphp

<select name="sub_category_id" class="form-control" id="sub_category_id">
    <option value="">None</option>
    @if($subCategories)
        @foreach($subCategories as $subCategory)
        <option {{$subCategory->id == @$subCategoryId ? "selected='selected'" : ""}} value="{{$subCategory->id}}">{{$subCategory->name}}</option>
        @endforeach
    @endif
</select>
@section('subCategorySection')
<script>
    $("#category_id").change(function(e){
        e.preventDefault();

        const category_id = $(this).val();
        $.ajax({
            url:`{{ route('category.all') }}/${category_id}`,
            method:'get',
            success : function(response){
                if(response.success == true){
                    const { data } = response;
                    
                    $("#sub_category_id").html("<option>None</option>");

                    data.map(function(d){
                    $("#sub_category_id").append(`<option value="${d.id}">
                                       ${d.name}
                                  </option>`);
                    })
                }
            }   
        })

    })
</script>
@endsection