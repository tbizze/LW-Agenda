<?php

namespace App\Livewire\Evento;

use App\Livewire\Forms\Evento\EventoForm;
use App\Models\Evento;
use App\Models\EventoArea;
use App\Models\EventoGrupo;
use App\Models\EventoLocal;
//use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;
use Ramsey\Uuid\Type\Integer;

class CalendarIndex extends Component
{
    use Toast;

    // Modelo.
    public ?Evento $evento = null;

    // Propriedades (campos) do modelo.
    public $nome = '';
    public $notas = '';
    public $start_date = '';
    public $end_date = '';
    public $start_time = '';
    public $end_time = '';
    public $all_day = false;
    public $evento_grupo_id = '';
    public $evento_local_id = '';
    public array $evento_areas_selected = [];

    // Regras de validação.
    #[Validate([
        'nome' => ['required', 'string', 'min:3', 'max:50'],
        'notas' => ['nullable', 'string', 'max:100'],
        'start_date' => ['required', 'date'],
        'end_date' => ['nullable', 'date'],
        'start_time' => ['nullable', 'date_format:H:i'],
        'end_time' => ['nullable', 'date_format:H:i'],
        'evento_grupo_id' => ['required', 'numeric'],
    ])]

    // Atributos diversos.
    public bool $modalRegistro = false;
    public int $registroEditMode = 1;
    public $date_config = [
        'altFormat' => 'd/m/Y',
        'locale' => 'pt',
    ];

    /* Renderiza componente */
    #[Title('Calendário eventos')]
    public function render()
    {
        return view('livewire.evento.calendar-index', [
            'events' => $this->eventos(),
            'evento_locals' => EventoLocal::orderBy('nome')->get(['id', 'nome as name']),
            'evento_grupos' => EventoGrupo::orderBy('nome')->get(['id', 'nome as name']),
            'evento_areas' => EventoArea::get(['id', 'nome as name']),
        ]);
    }

    public function newEvent($startDate, $endDate)
    {
        $this->start_date = $startDate;
        $this->end_date = $endDate;
        $this->modalRegistro = true;

        //dd($startDate, $endDate);
        /* $validated = [
            'start_date' => '$startDate',
            'end_date' => $endDate,
        ]; */
        //dd($validated);
        //$this->$start_date = 1;
        //$this->form->store();
        $id = 1541;
        return $id;
    }

    public function eventEdit2($event)
    {
        //dd($event);
        $this->modalRegistro = true;
    }

    // Método p/ carregar inputs do form.
    public function eventEdit($id)
    {
        $registro = Evento::find($id);
        $this->form->setRegistro($registro);
        $this->registroEditMode = 2;
        $this->modalRegistro = true;
    }
    public function save()
    {
        //dd('xx', $this->registroEditMode);
        //editMode: 1=createEvent, 2=allUpdate, 3=dropUpdate,
        if ($this->registroEditMode == 2) {
            //dd('allUpdate');
            $this->form->update();
            $this->registroEditMode = 1;
            $this->success('Registro salvo com sucesso!');
            //$this->eventos();
            $this->dispatch('post-created');
        } elseif ($this->registroEditMode == 3) {
            // dd('dropUpdate');
            // $this->form->dropUpdate();
            // $this->registroEditMode = 1;
            // $this->success('Registro salvo com sucesso!');
        } else {
            // $this->form->store();
            // $this->success('Registro incluído com sucesso!');
        }
        $this->modalRegistro = false;
    }

    public function eventDrop($event, $oldEvent)
    {
        //dump($oldEvent['start'], $event['start']);

        // Busca o evento no BD.
        $evento = Evento::findOrFail($event['id']);

        // Persiste no BD a alteração no evento escolhido.
        $evento->update([
            'start_date' => $event['start'],
            //'end_date' => $this->end_date,
        ]);
        // Emite aviso.
        $this->success('Registro salvo com sucesso!');

        // Verifica se o evento é do usuário logado.
        // if ($dh_event->user_id != auth()->id() || $dh_event->created_by != auth()->id()) {
        //     abort(403);
        // }

        // $validated = Validator::make(
        //     [
        //         'start_date' => $event['start'],
        //     ],
        //     [
        //         'start_date' => 'required|date',
        //     ]
        // ); 
        // Métodos que podem ser chamados: ->validate() ->fails());

        // $this->clearCache();
        // $this->emit('refreshCalendar');
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
                    case 3:
                        $color_event = '#3480eb'; // matriz
                        break;
                    case 4:
                        $color_event = '#f52fb6'; // NSA
                        break;
                    case 5:
                        $color_event = '#eaf36a'; // SST
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

        // $eventos_all_day_id = Evento::query()
        //     ->where('start_time', null)
        //     ->where('all_day', false)
        //     ->get()
        //     ->pluck('id');

        // Conta o array, se tiver algum ID, atualiza os registros.
        // if (count($eventos_all_day_id) != 0) {
        //     // Atualiza 'all_day' para 'TRUE'.
        //     Evento::whereIn('id', $eventos_all_day_id)->update([
        //         'all_day' => true,
        //     ]);
        // }

        //dd($events);
        return $events;
    }
}
