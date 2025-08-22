<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
        'images',
        'description',
        'price',
        'capacity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'images' => 'array', // automatically converts JSON to array and back
        'price'  => 'decimal:2',
    ];

    /**
     * Get all bookings associated with this listing.\
     * 
     * 
     *     public function bookings()
     *   {
     *     return $this->hasMany(Booking::class);
     * }
     */
}
