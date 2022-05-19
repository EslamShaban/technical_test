<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_desc',
        'user_id'
    ];

        
    protected $appends = ['image_path'];

    public function getImagePathAttribute(){
         $images = [];
         foreach($this->file as $file){
            $images[] = asset(($file->full_path ?? 'assets/images/default.png'));
         }
        return $images;
        
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    
}
