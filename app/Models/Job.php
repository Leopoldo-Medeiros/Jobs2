<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Import the HasFactory trait
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory; // Use the HasFactory trait

    protected $table = 'job_listings'; // Specify the correct table name if necessary

    public function employer()
    {
        return $this->belongsTo(Employer::class); // Define the relationship with Employer
    }
}
