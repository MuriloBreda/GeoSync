<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    // Nome da tabela exatamente como está no seu SQL
    protected $table = 'pagamentos';

    // Campos que permitimos salvar
    protected $fillable = [
        'user_id',
        'valor',
        'status'
    ];

    // Relacionamento: Um pagamento pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}