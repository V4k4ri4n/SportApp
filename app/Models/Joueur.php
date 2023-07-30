<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Joueur extends Model
{
    use HasFactory, softDeletes;

    /**
     * The attributes that are mass assignable
     *
     * @var string[]
     */
    protected $fillable = [
        'joueur_id',
        'nom_complet',
        'prenom',
        'nom',
        'age',
        'date_naissance',
        'ville_naissance',
        'pays_naissance',
        'nationalite',
        'taille',
        'poids',
        'blesse',
        'photo',
        'equipe_id',
        'ligue_id',
        'pays_id',
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
    protected $table = 'joueurs';

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
        'date_naissance'  => '0000-00-00',
        'ville_naissance' => '',
        'pays_naissance'  => '',
        'taille'          => '',
        'poids'           => '',
        'blesse'          => false,
        'photo'           => ''
    ];

    /**
     * The attributes that should be cast
     *
     * @var string[]
     */
    protected  $casts = [
        'date_naissance' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at'  => 'datetime:Y-m-d',
    ];

    /**
     * Reourne le pays du joueur associé
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Pays::class);
    }

    /**
     * Retourne la ligue du joueur associé
     *
     * @return BelongsTo
     */
    public function league(): BelongsTo
    {
        return $this->belongsTo(Ligue::class);
    }

    /**
     * Retourne l'équipe du joueur associé
     *
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Equipe::class);
    }

    /**
     * Retourne la postion du joueur associé
     * @return HasOne
     */
    public function position(): HasOne
    {
        return $this->hasOne(PositionJoueur::class);
    }
}
