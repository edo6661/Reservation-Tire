<?php
namespace App\Models;

use App\Enums\ContactSituation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'reception_id',
        'title',
        'text',
        'sender',
        'answer_title',
        'answer_text',
        'situation',
    ];

    protected $casts = [
        'situation' => ContactSituation::class,
    ];

    public function reception(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reception_id');
    }

    public function isAnswered(): bool
    {
        return $this->situation === ContactSituation::ANSWERED;
    }

    public function scopeUnanswered($query)
    {
        return $query->where('situation', ContactSituation::UNANSWERED);
    }

    public function scopeAnswered($query)
    {
        return $query->where('situation', ContactSituation::ANSWERED);
    }
}