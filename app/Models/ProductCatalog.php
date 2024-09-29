<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCatalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'product_name',
        'description',
        'price',
    ];

    // Define the relationship to the Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id'); // Assuming 'vendor_id' is the foreign key in the product_catalogs table
    }
}
