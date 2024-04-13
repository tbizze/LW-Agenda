<?php

namespace App\Livewire\Evento;

use App\Models\Evento;
use Livewire\Component;

class CalendarIndex extends Component
{
    public function render()
    {
        return view('livewire.evento.calendar-index',[
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
            if (isset($event->end_time)) {
                $end = $event->end_date->format('Y-m-d') . ' ' . $event->end_time->format('H:i:s');
            } else {
                $end = $event->end_date->format('Y-m-d'); //. ' ' . isset($event->end_time) ? $event->end_time->format('H:i:s') : null;
            }

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
                'start' => $event->startDateFull,
                'end' => $end,
                'allDay' => $event->all_day,
                'color' => $color_event,
                //'end' => $event->end_time->toIso8601String(),
            ];
        }
        return $events;
    }

    
}
