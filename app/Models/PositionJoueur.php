<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PositionJoueur extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var string[]
     */
    protected $fillable = [
        'numero',
        'position',
        'joueur_id',
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
    protected $table = 'joueur_position';

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
        'numero' => 0,
    ];

    /**
     * The attributes that should be cast
     *
     * @var string[]
     */
    protected  $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    /**
     * Retourne le joueur
     *
     * @return BelongsTo
     */
    public function joueur(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
