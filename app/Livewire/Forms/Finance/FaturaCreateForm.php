<?php

namespace App\Livewire\Forms\Finance;

use App\Models\Fatura;
use App\Models\FaturaItem;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FaturaCreateForm extends Form
{
    //
    //#[Rule('required')]
    public $dt_venc;
    public $dt_pgto;
    public $valor_fatura;
    public $valor_pgto;
    public $codigo;
    public $notas;
    public $fatura_emissora_id;
    public $pgto_tipo_id;
    public $fatura_status_id;

    public $dt_compra;
    //#[Rule('required')]
    public $valor_compra;
    public $historico;
    public $parcela;
    //public $notas;
    public $fatura_id;
    public $fatura_grupo_id;

    public function rules()
    {
        return [
            // 'dt_venc' => 'required',
            // 'fatura_emissora_id' => 'required',
            'valor_fatura' => 'required|numeric',
            // 'codigo' => 'required|min:3',
            // 'fatura_status_id' => 'required',

            'valor_compra' => 'required|array|min:1',
            'valor_compra.*' => 'numeric',
            'historico' => 'required|array|min:1',
            'historico.*' => 'string|min:3',
        ];
    }

    public function store()
    {
        $this->validate();
        //dd($this->all());

        DB::beginTransaction();
        //try {
        // Executa operações no banco de dados
        $fatura = Fatura::create(
            $this->only('dt_venc', 'dt_pgto', 'valor_fatura', 'valor_pgto', 'codigo', 'notas', 'fatura_emissora_id', 'pgto_tipo_id', 'fatura_status_id')
        );

        foreach ($this->valor_compra as $key => $item) {
            FaturaItem::create(
                [
                    'dt_compra' => $this->dt_compra[$key],
                    'valor_compra' => $this->valor_compra[$key],
                    'historico' => $this->historico[$key],
                    'parcela' => $this->parcela[$key],
                    //'notas' => $this->notas[$key],
                    'fatura_grupo_id' => $this->fatura_grupo_id[$key],
                    'fatura_id' => $fatura->id,
                ]
            );
        }

        DB::commit();
        //} catch (\Exception $e) {
        // Lidar com falha de transação
        //DB::rollBack(); 
        //dd($e);
        //}





        //dd('fim');

        $this->reset();
    }
    public function update()
    {
    }
}
