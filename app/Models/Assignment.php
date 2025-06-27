<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $table= "assignments";
    protected $fillable = [
    'title',
    'description',
    'duedate',
    'status',
    'course_id',
    'instructor_id',
];

    public function course()
{
    return $this->belongsTo(Course::class);
}

public function instructor()
{
    return $this->belongsTo(User::class, 'instructor_id');
}

public function submissions()
{
    return $this->hasMany(Submission::class);

}
}