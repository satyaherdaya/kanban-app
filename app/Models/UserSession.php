<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function remove_session()
    {
        $sessions = UserSession::where('lifetime', '<', Carbon::now()->timezone('Asia/Phnom_Penh'))->get();
        foreach ($sessions as $session) {
            $session->delete();
        }
    }
}
