<?php

namespace App\WebPage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Metadata extends Model
{
    /**
     * Get the webpage associated with the Metadata.
     */
    public function webpage(): HasOne
    {
        return $this->hasOne(Webpage::class, "webpageId");
    }

}
