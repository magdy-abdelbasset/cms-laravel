<?php
 
namespace App\Utils;

use App\Models\Setting;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use Intervention\Image\Facades\Image;
// all function with images and with package intervention/image
class FileHandler 
{
    const ROOT = "storage/uploads/";
    // which image is saved
    private  $directory ;
    private $file;
    private  $newName =null;
    private $originalName;
    private $originalExtension;
    private $originalSize;
    private $extensions;
    private $size;
    private $img;// object Image 
    
    // target 
    function __construct($directory ='',$file=null)
    {
        // inizile directory
        $this->directory = $directory;
        $this->file = $file;
        $this->initial();
        if($this->file)
        {
            $this->setDetailsFile();
        }
        return $this;
    }
    private function createPath(){
        $path = storage_path('app/public/uploads/').$this->directory;
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
    }
    // save photo with ne size
    public function resizeSave()
    {

        // 1px * 1px = 0.125 bytes;
        // try {
            $this->img = Image::make($this->file->getRealPath());
        // }catch(Exception $e){
        //     return new Exception("Image Intervention Can't Read A file" .$e);
        // }
        // $space = $img->width() * $img->height();
        // $width = ($img->width()/($img->height())) /( $this->size *8 );
        if($this->size < $this->originalSize){
            $this->resize();
        }
        $this->save();
        return $this;

    }
    private function save()
    {
        $this->img->save(storage_path('app/public/uploads/').$this->directory .$this->newName);
        return $this;
    }
    private function resize()
    {
        $aspect_ratio = ($this->size  / $this->originalSize );
        // $area_ratio =$img->width() / $img->height() ;
        $height = $this->img->height() * sqrt($aspect_ratio) ;
        $width = $this->img->width() * sqrt($aspect_ratio);
        $this->img->resize($width, $height);
        return $this;

    }
 
    // get  size from setting
    // Or return default if there no size setting
    private function size()
    {
        $this->size = 0.06 /2 * 1024 * 1024;

    }
    
    // get  extension from setting
    // Or return default if there no extension setting
    private function extension()
    {

            $this->extensions = ['png','jpeg','jpg'];
    }
    private function checkSize()
    {
        
    }
    private function checkExtension()
    {
        
    }
    private function initial()
    {
        $this->createPath();
        $this->size();
        $this->extension();

    }
    private function setDetailsFile()
    {


        /** Get Filename With Extension **/
        $fileNameWithExtension = $this->file->getClientOriginalName();

        /** Get Filename Without Extension **/
        $this->originalName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);

        /** Set File Extension **/

        $this->originalExtension = $this->file->getClientOriginalExtension();
        $fileNameHash = time() . '_' . $this->originalName . '_' . Str::random(10);

        /** Filename To Store **/
        $this->newName = $fileNameHash . '.' . $this->originalExtension;

        // $uploadedFile->storeAs('public/uploads/banners/images', $this->newName);

        // $data['banner'] = 'storage/uploads/banners/images/' . $fileNameToStore;

        $this->originalSize = $this->file->getSize(); // in bytes
    }
    public function getFullPath()
    {
        if($this->newName){
            return self::ROOT.$this->directory.$this->newName;
        }
        return new Exception("NO File Saved ,What You Want ? .....");
    }
    // upload any type of file
    public function upload()
    {
        /** Store Video In File. **/
        $this->file->storeAs('public/uploads/'. $this->directory, $this->newName);
        return $this;
    }
}