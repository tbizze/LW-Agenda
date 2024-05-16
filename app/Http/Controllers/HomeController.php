<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoArea;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function prepare_events($dados)
    {
        //$dados_new = [];
        $dados_new = $dados->groupBy(['mes_nome', 'dia_numero'])->toArray();
        //$dados->groupBy(['date_y_m', 'numero_dia']);
        //dump($dados->groupBy(['date_y_m', 'dia_numero'])->toArray());
        // $dados->groupBy(['date_y_m', 'dia_numero'])
        //     ->each(function ($event) use (&$dados_new) {
        //         // Meses na collection.
        //         foreach ($event as $events_no_mes){
        //             // Dias no mês.
        //             foreach ($events_no_mes as $events_no_dia){
        //                 // Eventos no dia.
        //                 $dados_new[$events_no_dia->date_y_m][$events_no_dia->dia_numero][] = [                
        //                     'id' => $events_no_dia['id'],
        //                     "nome" => $events_no_dia->nome,
        //                     "start_date" => $events_no_dia->start_date,
        //                     "start_time" => $events_no_dia->start_time,
        //                     "all_day" => $events_no_dia->all_day,
        //                     "diaNumero" => $events_no_dia->dia_numero,
        //                     "diaNome" => $events_no_dia->dia_nome,
        //                     "mesNome" => $events_no_dia->mes_nome,
        //                     "to_grupo_nome" => $events_no_dia->to_grupo_nome,
        //                     "to_local_nome" => $events_no_dia->to_local_nome,
        //                 ];
        //             }
        //         }            
        // });
        //dump('test',$dados_new);
        return $dados_new;
    }
    public function openEventPdf(Request $request)
    {
        $dados = Evento::query()
            // ->select([
            //     'id','nome','start_date','start_time','evento_grupo_id','evento_local_id','dia_numero',
            //     \DB::raw("DATE_FORMAT(start_date, '%Y-%m') AS date_y_m")
            //     ])
            ->select('*')
            ->selectRaw("DATE_FORMAT(start_date, '%Y-%m') AS date_y_m")
            ->with('areas:id,nome')
            ->withAggregate('toGrupo', 'nome')
            ->withAggregate('toLocal', 'nome')
            
            // Condições Data:
            ->when($request->mes, function ($query, $val) {
                $query->whereMonth('start_date', $val);
                return $query;
            })
            ->when($request->ano, function ($query, $val) {
                $query->whereYear('start_date', $val);
                return $query;
            })

            // Condições Grupo/Local/Área:
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
                });
                return $query;
            })

            // Ordem dos dados:
            ->orderByRaw('MONTH(start_date) asc')
            ->orderByRaw('DAY(start_date) asc')
            ->orderBy('start_time')
            //->limit(10)
            ->get();
        
        // Prepara os dados: agrupa por mês e por dia.
        //$eventos = $this->prepare_events($dados);
        $eventos = $dados->groupBy(['mes_nome', 'dia_numero'])->toArray();

        // Prepara o PDF com os dados passados para a view.
        $pdf = Pdf::loadView('pdfs.calendar1', [
            'titulo' => 'Calendário de Atividades',
            'dados' => $eventos,
        ]);
        // Carrega o PDF na tela.
        return $pdf->stream('eventos.pdf');
    }
    public function pdf()
    {
        $data = [
            [
                'quantity' => 1,
                'description' => '1 Year Subscription',
                'price' => '129.00'
            ],
            [
                'quantity' => 1,
                'description' => 'Licença vitalícia Word',
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
