<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'instructor_id', 
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id'); // ✅ correct foreign key
    }

    public static function forInstructor($instructorId)
    {
        return self::where('instructor_id', $instructorId)->get(); // ✅ match foreign key
    }

    public function students()
{
    return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
}

}
