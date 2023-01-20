<?php
 
namespace App\Utils\Casts;

use App\Models\Image;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DateFormate implements CastsAttributes
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
    private $format;
    public function __construct($format = 'Y-m-d')
    {
        $this->format = $format;
    }
    public function get($model, $key, $value, $attributes)
    {
        return \Carbon\Carbon::parse($value)->format($this->format);
        // return date($this->format, strtotime($value));
    }

    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}