<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebAccessLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_access_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'access_uid',
        'access_mid',
        'access_url',
        'access_qstring',
        'access_ip',
        'method',
        'access_date',
        'leave_date'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'access_uid', 'email');
    }

    public function web_menu()
    {
        return $this->belongsTo(WebMenu::class, 'access_mid');
    }
}
