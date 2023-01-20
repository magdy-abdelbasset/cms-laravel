<?php
 
namespace App\Utils\Casts;

use App\Models\Image;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class AsSet implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    private $folder_route = '';
    private $field_name;
    public function __construct($field_name = 'img',$folder_route='/uploads/')
    {
        $this->folder_route = $folder_route ;
        $this->field_name = $field_name ;
    }
    public function get($model, $key, $value, $attributes)
    {
        $img = Image::where('model_id',$model->id)->where("model_type",get_class($model))->first();
        if(!empty($img)){
            // return dd($model->image());
            return asset($img->url);
        }
        else {
            return '';
        }
    }

    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}