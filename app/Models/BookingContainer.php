<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookingContainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',

        'container_id',
        'container_json', // TODO: handle when those are added

        'branch_id',
        'container_no',
        'sail_of_number',
        'arrival_date',
        'status',
        
        'yard_id',
        'yard_json', // TODO: handle when those are added

        'departure_id',
        'departure_json', // TODO: handle when those are added
        'loading_id',
        'loading_json', // TODO: handle when those are added
        'aging_id',
        'aging_json', // TODO: handle when those are added
        'price',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function yard()
    {
        return $this->belongsTo(Yard::class);
    }

    public function agents(): BelongsToMany
    {
        return $this->belongsToMany(Agent::class, "booking_container_agents")->withPivot('booking_container_status')->withTimestamps();
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, "attached_id")->where("attached_type", 'App\Models\BookingContainer');
    }

    public function departure()
    {
        return $this->belongsTo(CitiesAndRegions::class);
    }

    public function aging()
    {
        return $this->belongsTo(CitiesAndRegions::class);
    }

    public function loading()
    {
        return $this->belongsTo(CitiesAndRegions::class);
    }

    public function getContainerTypeAttribute()
    {
        return $this->container->type;
    }

    public function last_movement()
    {
        return $this->hasMany(BookingMovement::class, 'container_id');
    }
}
