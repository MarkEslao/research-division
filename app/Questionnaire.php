<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Questionnaire extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];



    /**
     * Returns all questions for a given questionnaire
     */
    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    /**
     * Returns The associated ordinance
     */
    public function ordinance()
    {
        return $this->belongsTo('App\Ordinance');
    }

    /**
     * Returns the associated resolution
     */
    public function resolution()
    {
        return $this->belongsTo('App\Resolution');
    }

    /**
     * Returns true if a questionnaire with associated questions has answers
     */
    public function response()
    {
        return $this->hasMany('App\Response');
    }
    public function hasAnswers()
    {
        foreach($this->questions as $q){
           if ($q->answers->count() != 0){
            return true;
           }
        }
        return false;
    }

    /**
     * Returns the count of answers in this specific questionnaire
     * @return int
     */
    public function getResponseCount()
    {
        $count = 0;
        foreach($this->questions as $q){
            // Can be simplified using SQL queries
            if ($q->answers->count() > $count){
                $count = $q->answers->count();
            }
        }
        return $count;
    }
}
