<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoArea;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function openEventPdf(Request $request){
        $dados = Evento::query()
            ->when($request->mes, function ($query, $val) {
                $query->whereMonth('start_date', $val);
                return $query;
            })
            ->when($request->grupo, function ($query, $val) {
                $query->where('evento_grupo_id', $val);
                return $query;
            })
            ->when($request->local, function ($query, $val) {
                $query->where('evento_local_id', $val);
                return $query;
            })
            ->when($request->area_ids, function ($query, $val) {
                $query->whereHas('areas', function ($q) use ($val) {
                    $q->whereIn('evento_area_id', [$val]);
                    //dd($val,$q);
                });
                return $query;
            })

            ->withAggregate('toGrupo', 'nome')
            ->withAggregate('toLocal', 'nome')
            //->withAggregate('areas', 'nome')
            ->with('areas:id,nome')

            ->orderByRaw('MONTH(start_date) asc')
            ->orderByRaw('DAY(start_date) asc')
            ->orderBy('start_time')
            //->limit(10)
            ->get();

        //dd($dados->toArray());
        









        $pdf = Pdf::loadView('pdfs.eventos', [
            'titulo' => 'Eventos',
            'dados' => $dados,
        ]);
        return $pdf->stream('eventos.pdf');
    }
    public function pdf() {
        $data = [
            [
                'quantity' => 1,
                'description' => '1 Year Subscription',
                'price' => '129.00'
            ],
            [
                'quantity' => 1,
                'description' => 'Licença vitalícia Elementor',
                'price' => '75.59'
            ],
            [
                'quantity' => 3,
                'description' => 'Pen Drive 1T',
                'price' => '35.59'
            ],
        ];
        
        $pdf = Pdf::loadView('pdfs.exemplo', ['data' => $data]);
        //dd($pdf);

        //$pdf = Pdf::loadView('pdfs.exemplo');
     
        //return $pdf->download('recibo.pdf');
        return $pdf->stream('recibo.pdf');
    }
}
