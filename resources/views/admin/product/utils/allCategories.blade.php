@php
    $categories = getCategories();
@endphp

<select type="text" name="category_id" class="form-control" id="category_id">
    <option value="">None</option>
    @if($categories)
        @foreach($categories as $parentCategory)
        <option {{$parentCategory->id == @$categoryId ? "selected='selected'" : ""}} value="{{$parentCategory->id}}">{{$parentCategory->name}}</option>
        @endforeach
    @endif
</select>