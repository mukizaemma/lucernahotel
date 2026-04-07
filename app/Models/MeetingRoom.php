<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MeetingRoom extends Model
{
    public static function ensureDefaultsForEventpage(Eventpage $page): void
    {
        if ($page->meetingRooms()->exists()) {
            return;
        }
        $defaults = [
            ['title' => 'Salle Kibeho', 'max_persons' => 50, 'sort_order' => 1],
            ['title' => 'Salle Lourde', 'max_persons' => 250, 'sort_order' => 2],
            ['title' => 'Salle no 111', 'max_persons' => 15, 'sort_order' => 3],
        ];
        foreach ($defaults as $row) {
            $row['slug'] = static::uniqueSlugForEventpage((int) $page->id, $row['title']);
            $page->meetingRooms()->create($row);
        }
    }

    public static function uniqueSlugForEventpage(int $eventpageId, string $title, ?int $exceptId = null): string
    {
        $base = Str::slug($title) ?: 'room';
        $slug = $base;
        $n = 1;
        while (
            static::query()
                ->where('eventpage_id', $eventpageId)
                ->where('slug', $slug)
                ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $base.'-'.$n++;
        }

        return $slug;
    }

    /**
     * Short teaser for listing cards (plain text preferred).
     */
    public function excerpt(): string
    {
        $s = trim((string) ($this->summary ?? ''));
        if ($s !== '') {
            return $s;
        }
        $html = (string) ($this->description ?? '');

        return Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($html))), 180);
    }

    protected $fillable = [
        'eventpage_id',
        'title',
        'slug',
        'max_persons',
        'description',
        'summary',
        'image',
        'sort_order',
    ];

    protected $casts = [
        'max_persons' => 'integer',
        'sort_order' => 'integer',
    ];

    public function eventpage(): BelongsTo
    {
        return $this->belongsTo(Eventpage::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(MeetingRoomImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
