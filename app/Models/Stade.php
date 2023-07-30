<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stade extends Model
{
    use HasFactory, softDeletes;

    /**
     * The attributes that are mass assignable
     *
     * @var string[]
     */
    protected $fillable = [
        'satde_id',
        'nom',
        'adresse',
        'ville',
        'capacite',
        'surface',
        'image',
        'equipe_id'
    ];

    /**
     * The primary key associated with the table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'stades';

    /**
     * The database connection that should be used by the model
     *
     * @var string
     */
    protected $connection = 'sqlite';

    /**
     * Indicates if the model's ID is auto-incrementing
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * the model's default values for attributes
     *
     * @var string[]
     */
    protected $attributes = [
        'capcite' => 0,
        'surface' => 'herbe',
        'image'   => ''
    ];

    /**
     * The attributes that should be cast
     *
     * @var string[]
     */
    protected  $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at'  => 'datetime:Y-m-d',
    ];

    /**
     *  Retourne l'equipe associée au stade
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Equipe::class);
    }
}
