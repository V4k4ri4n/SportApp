<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipe extends Model
{
    use HasFactory, softDeletes;

    /**
     * The attributes that are mass assignable
     *
     * @var string[]
     */
    protected $fillable = [
        'equipe_id',
        'nom',
        'code',
        'pays',
        'foundation',
        'national',
        'logo',
        'equipe_id',
        'pays_id'
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
    protected $table = 'equipes';

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
        'foundation' => '0000',
        'national'   => false,
        'logo'       => ''
    ];

    /**
     * The attributes that should be cast
     *
     * @var string[]
     */
    protected  $casts = [
        'foundation' => 'datetime:Y',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d',
    ];

    /**
     * Retourne le pays à laquelle l'équipe est associé
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Pays::class);
    }

    /**
     * Retourne la ligue à laquelle l'équipe est associée
     *
     * @return BelongsTo
     */
    public function league(): BelongsTo
    {
        return $this->belongsTo(Ligue::class);
    }


    /**
     * Retourne le stade associé à l'id de l'équipe
     *
     * @return HasOne
     */
    public function venue(): HasOne
    {
        return $this->hasOne(Stade::class);
    }

    /**
     * Retourne tous les joueurs associés à l'id de l'équipe
     *
     * @return HasMany
     */
    public function players(): HasMany
    {
        return $this->hasMany(Joueur::class);
    }
}
