<select type="text" name="parent_id" class="form-control" id="parent_id">
    <option value="">None</option>
    @if($allParentCategories)
        @foreach($allParentCategories as $parentCategory)
        <option {{$parentCategory->id == @$parentId ? "selected='selected'" : ""}} value="{{$parentCategory->id}}">{{$parentCategory->name}}</option>
        @endforeach
    @endif
</select>

