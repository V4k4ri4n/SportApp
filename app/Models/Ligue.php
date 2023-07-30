<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ligue extends Model
{
    use HasFactory,softDeletes;

    /**
     * The attributes that are mass assignable
     *
     * @var string[]
     */
    protected $fillable = ['ligue_id','nom','type','logo','pays_id'];

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
    protected $table = 'ligues';

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
        'type' => 'inconnu',
        'logo' => '',
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
     * Retourne le pays a laquelle la ligue est associé
     *
     * @return BelongsTo
     */public function country(): BelongsTo
{
    return $this->belongsTo(Pays::class);
}

    /**
     * Retourne toutes les équipes associées à l'id de la ligue
     *
     * @return HasMany
     */public function teams(): HasMany
{
    return $this->hasMany(Equipe::class);
}

    /**
     * Retourne tous les joueurs associés à l'id de la ligue
     *
     * @return HasMany
     */public function players(): HasMany
{
    return $this->hasMany(Joueur::class);
}
}
