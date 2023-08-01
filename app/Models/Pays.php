<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pays extends Model
{
    use HasFactory, softDeletes;

    /**
     * The attributes that are mass assignable
     *
     * @var string[]
     */
    protected $fillable = [
        'nom',
        'code',
        'drapeau'
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
    protected $table = 'pays';

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
        'code' => 'wd',
        'drapeau' => '',
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
     * Retourne toutes les ligues associées à l'id du pays
     *
     * @return HasMany
     */
    public function ligues(): HasMany
    {
        return $this->hasMany(Ligue::class);
    }

    /**
     * Retourne toutes les équipes associées à l'id du pays
     *
     * @return HasMany
     */
    public  function equipes(): HasMany
    {
        return $this->hasMany(Equipe::class);
    }

    /**
     * Retourne tous les joueurs associés à l'id du pays
     *
     * @return HasMany
     */
    public function joueurs(): HasMany
    {
        return $this->hasMany(Joueur::class);
    }


}
