<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class TrelloCard extends Model
{
    use HasFactory;
    protected $table = 'trello_card';

    protected $fillable = ["title", "description", 
                "column_id", "is_active", 'created_by', 'updated_by'];

    protected $appends = ['encId'];

    public function getEncIdAttribute(){
        return Crypt::encryptString($this->id);
    }
}
