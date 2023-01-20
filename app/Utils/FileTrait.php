<?php
namespace App\Utils;

use App\Models\File as ModelsFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileTrait{
    private function setImage($dir,$img,$model,$type="image",$desc="Image Index" ,$title = null){
        // $path = storage_path().$dir;
        // File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        if(!empty($img)){
            $image = ModelsFile::where('model_id',$model->id)->where("model_type",get_class($model))->where("description",$desc)->first();
            ModelsFile::where('model_id',$model->id)->where("model_type",get_class($model))->where("description",$desc)->delete();
            // Image
            $this->unSetImage($image);
            $path = (new FileHandler($dir,$img))->resizeSave()->getFullPath();            

            ModelsFile::create([
                "type"          => $type,
                "url"           => $path,
                "model_id"      => $model?$model->id:0,
                "model_type"    => $model ?get_class($model): 'App\\Models\\Setting',
                "description"   => $desc,
                "title"   => $title,
            ]);
            return $path;   
        }
        return null;
    }
 
    private function setFile($dir,$file,$model=null,$type="vedio",$desc ="vedio Index" ,$title=null){

        if(!empty($file)){
            $path = (new FileHandler($dir,$file))->upload()->getFullPath();            
            // $this->unSetFile($file);          
            // Image
            ModelsFile::create([
                "type"          => $type ,
                "url"           => $path,
                "model_id"      => $model->id ,
                "model_type"    => get_class($model) ,
                "description"   => $desc,
                "title"   => $title
            ]);
        }
    }
    private function unSetImage($image)
    {
        if(!empty($image)){
            File::delete($image->thump);
            File::delete($image->icon);
            File::delete($image->url);
            $image->delete();
        }   
    }
    private function removeImage($image)
    {
        if(!empty($image)){
            File::delete($image);
        }   
    }
    private function unSetFile($file)
    {
        if(!empty($file)){
            File::delete($file->url);
            Storage::disk('public')->delete(str_replace("storage/",'',$file->url));
            $file->delete();
        }
    }
}