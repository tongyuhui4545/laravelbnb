<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Query\Builder;

class Bookable extends Model
{
    public function bookings()
    {
       return $this->hasMany(Booking::class);
    }

   public function availableFor($from, $to): bool
   {
     return 0 === $this->bookings()->betweenDates($from, $to)->count();
   }
}
