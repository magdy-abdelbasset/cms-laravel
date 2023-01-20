<?php

namespace App\Utils;

use App\Models\File;
use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Storage;

class Files 
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
    private $class;
    private $get;
    const IMAGE_PATH = 'web_images/logo.jpg';

    public function __construct($class = "App/Models/File",$get = "get")
    {
        $this->class = $class;
        $this->get   = $get;
    }
    public function get($id,$type=null)
    {
        try {
            $get = $this->get;
            $files = File::where('model_id', $id)->where("model_type", $this->class);
            if(empty($type)){
                $files = $files->$get();
            }else{
                $files = $files->where("type",$type)->$get();
            }
            return $files;
        } catch (Exception $e) {
            return null;
        }
    }
}
