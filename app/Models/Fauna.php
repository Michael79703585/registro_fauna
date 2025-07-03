<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Imagen;

class Fauna extends Model
{
    use HasFactory;

    protected $fillable = [

        'institucion_id',  
        'user_id',
        'codigo',
        'fecha_ingreso',
        'fecha_recepcion',
        'ciudad',
        'departamento',
        'coordenadas',
        'tipo_elemento',
        'motivo_ingreso',
        'lugar',
        'institucion_remitente',
        'nombre_persona_recibe',
        'especie',
        'nombre_comun',
        'tipo_animal',
        'edad_aparente',
        'estado_general',
        'sexo',
        'comportamiento',
        'sospecha_enfermedad',
        'descripcion_enfermedad',
        'alteraciones_evidentes',
        'otras_observaciones',
        'tiempo_cautiverio',
        'tipo_alojamiento',
        'contacto_con_animales',
        'descripcion_contacto',
        'padecio_enfermedad',
        'descripcion_padecimiento',
        'tipo_alimentacion',
        'derivacion_ccfs',
        'descripcion_derivacion',
        'foto',

    ];

     public static function getInstitutionInitials(string $name): string
    {
        // Palabras a ignorar
        $stopwords = ['de','del','la','las','el','los','y','a','en','para'];
        $parts = preg_split('/\s+/', mb_strtoupper($name));
        $letters = [];

        foreach ($parts as $word) {
            if (! in_array(mb_strtolower($word), $stopwords) && mb_strlen($word) > 0) {
                $letters[] = mb_substr($word, 0, 1);
            }
        }

        return implode('', $letters);
    }

    public function historialesClinicos()
{
    return $this->hasMany(HistorialClinico::class);
}

public function documentos()
{
    return $this->hasMany(Documento::class);
}

public function transferencias()
{
    return $this->hasMany(\App\Models\Transferencia::class, 'fauna_id');
}

public function user()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}

public function institucion()
{
    return $this->belongsTo(Institucion::class, 'institucion_id');
}

   public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

  public function reporte()
{
    return $this->belongsTo(Reporte::class);
}

public function institucionOrigen()
{
    return $this->belongsTo(Institucion::class, 'institucion_origen_id');
}

public function ultimaTransferencia()
{
    return $this->hasOne(Transferencia::class)->latestOfMany();
}

public function usuario()
{
    return $this->belongsTo(User::class, 'usuario_id');
}
}

