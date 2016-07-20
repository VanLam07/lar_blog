<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    protected $table = 'taxs';
    
    protected $fillable = ['image_id', 'type', 'parent_id', 'order', 'cout', 'count', 'status'];
    
    public function parent_name(){
        $parent = current_lang()->cats()->find($this->parent_id);
        if($parent){
            return $parent->pivot->name;
        }
        return 0;
    }
    
     public function langs($locale=null){
        if(is_null($locale)){
            $locale = current_locale();
        }
        return $this->belongsToMany('\App\Models\Lang', 'tax_desc', 'tax_id', 'lang_id')
                ->withPivot('name')->where('code', $locale)->first([]);
    }
    
    public function current_locale(){
        return current_lang()->cats()->find($this->id, [])->pivot;
    }
    
//    public function current_lang(){
//        $item = $this->langs()->where('code', current_locale())->first(['id']);
//        if($item){
//            return $item->pivot;
//        }
//        return null;
//    }
    
    public function relations(){
        return $this->belongsToMany('\App\Models\Cat', 'tax_relations', 'tax_id', 'parent_id');
    }
    
    public function status(){
        switch ($this->status){
            case 0:
                return 'Disable';
            case 1:
                return 'Active';
        }
    }
    
}