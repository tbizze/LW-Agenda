<?php

namespace App\Livewire\Evento;

use App\Models\Evento;
use Livewire\Attributes\Title;
use Livewire\Component;

class CalendarIndex extends Component
{
    /* Renderiza componente */
    #[Title('Calendário eventos')]
    public function render()
    {
        return view('livewire.evento.calendar-index', [
            'events' => $this->eventos(),
        ]);
    }
    public function eventos()
    {
        $events = [];

        $data = Evento::query()
            ->when(request()->mes, function ($query, $val) {
                $query->whereMonth('start_date', $val);
                return $query;
            })
            ->when(request()->grupo, function ($query, $val) {
                $query->where('evento_grupo_id', $val);
                return $query;
            })
            ->when(request()->local, function ($query, $val) {
                $query->where('evento_local_id', $val);
                return $query;
            })
            ->get();

        foreach ($data as $event) {
            // Se 'end_date' é passado
            /* if (isset($event->end_date)) {
                // Se 'end_time' é passado, define '$end_date' como junção de 'end_date' + 'end_time'
                if (isset($event->end_time)) {
                    $end_date = $event->end_date->format('Y-m-d') . ' ' . $event->end_time->format('H:i:s');
                
                // Se 'end_time' é nulo, define '$end_date' como 'end_date' somente.
                }else{
                    $end_date = $event->end_date->format('Y-m-d');
                }
            // Se 'end_date' é nulo, define '$end_date' como null.
            } else {
                $end_date = null;
            } */

            $color_event = '#3480eb';
            foreach ($event->areas as $area) {
                //dd($event->areas);
                switch ($area->id) {
                    case 1:
                        $color_event = '#b434eb'; // diocesano
                        break;
                    case 2:
                        $color_event = '#099c5a'; // paroquial
                        break;
                    case 6:
                        $color_event = '#eba834'; // CDP
                        break;
                    case 7:
                        $color_event = '#d93830'; // padre 
                        break;
                    default:
                        $color_event = '#3480eb'; // paroquial
                        break;
                }
            }

            $events[] =  [
                'id' => $event->id,
                'title' => $event->nome,
                //'start' => $start,
                //'end' => $end,
                'start' => $event->startDateFull,
                'end' => $event->endDateFull,
                //'end_full' => $event->endDateFull,
                'allDay' => $event->all_day,
                'color' => $color_event,
            ];
        }

        
        /**
         * Rotina p/ atualizar e corrigir coluna ALL_DAY.
         * Obtêm eventos em que 'start_time' é nulo, e que ainda não tenha sido alterado.
         * Seleciona somente 'id'.
         */

        $eventos_all_day_id = Evento::query()
            ->where('start_time', null)
            ->where('all_day', false)
            ->get()
            ->pluck('id');

        // Conta o array, se tiver algum ID, atualiza os registros.
        if (count($eventos_all_day_id) != 0){
            // Atualiza 'all_day' para 'TRUE'.
            Evento::whereIn('id', $eventos_all_day_id)->update([
                'all_day' => true,
            ]);
        } 

        return $events;
    }
}
