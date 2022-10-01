<?php
function getCategories(){
    return cache()->rememberForever('all_parent_categories', function(){
        return \App\Models\Category::where(['parent_id' => null, 'status' => true])->get();
    });
}
function getSubCategories($categoryId){
    $key = 'all_sub_categories_'.$categoryId;
    return cache()->rememberForever($key, function() use($categoryId){
        return \App\Models\Category::where(['parent_id' => $categoryId, 'status' => true])->get();
    });
}