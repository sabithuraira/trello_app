<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrelloColumn extends Model
{
    use HasFactory;
    protected $table = 'trello_column';

    protected $fillable = ["title","is_active", 'created_by', 'updated_by'];

    protected $appends = ['encId'];

    public function getEncIdAttribute(){
        return Crypt::encryptString($this->id);
    }
}
