<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class TrelloColumn extends Model
{
    use HasFactory;
    protected $table = 'trello_column';

    protected $fillable = ["title","is_active", 'created_by', 'updated_by'];

    protected $appends = ['encId', 'listCard'];

    public function getEncIdAttribute(){
        return Crypt::encryptString($this->id);
    }

    public function getListCardAttribute(){
        return TrelloCard::where('column_id', $this->id)->orderBy('position')->get();
    }
}
