<?php

namespace App\WebPage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Webpage extends Model
{
    /**
     * Get the metadata associated with the WebPage.
     */
    public function metadata(): HasOne
    {
        return $this->hasOne(Metadata::class, "webpageId", "id");
    }
}
