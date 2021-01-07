<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{

    protected $table = 'agency';
    protected $primaryKey = 'idAgency';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    const DELETED_AT = 'deletedAt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agencyName', 'agencyAdr', 'agencyPhone', 'agencyContact',
    ];

}
