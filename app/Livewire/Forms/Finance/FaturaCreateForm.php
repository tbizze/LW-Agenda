<?php

namespace App\Livewire\Forms\Finance;

use Livewire\Attributes\Validate;
use Livewire\Form;

class FaturaCreateForm extends Form
{
    //
    public $dt_venc;
    public $dt_pgto;
    public $valor_fatura;
    public $valor_pgto;
    public $codigo;
    public $notas;
    public $fatura_emissora_id;
    public $pgto_tipo_id;
    public $status_id;
}
