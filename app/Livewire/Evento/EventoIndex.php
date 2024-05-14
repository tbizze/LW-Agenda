<?php

namespace App\Livewire\Evento;

use App\Livewire\Forms\Evento\EventoForm;
use App\Models\Evento;
use App\Models\EventoArea;
use App\Models\EventoGrupo;
use App\Models\EventoLocal;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class EventoIndex extends Component
{
    use Toast;
    use WithPagination;

    public array $sortBy = ['column' => 'start_date', 'direction' => 'asc'];
    public string $search = '';

    public bool $modalRegistro = false;
    public bool $modalConfirmDelete = false;
    public bool $registroEditMode = false;
    public bool $showDrawer = false;

    public EventoForm $form;
    public $registro_id = '';
    public $qdeFilter = 0;
    public $page_title = 'Eventos';
    public $date_config = ['altFormat' => 'd/m/Y'];
    /* Campos de filtros */
    public $date_init = '';
    public $date_end = '';
    public $fil_grupo = '';
    public $fil_local = '';
    public $fil_mes = '';
    public $fil_area_ids = [];

    /* Renderiza componente */
    #[Title('Eventos')]
    public function render()
    {
        return view('livewire.evento.evento-index', [
            'headers' => $this->headers(),
            'eventos' => $this->eventos(),
            'evento_locals' => EventoLocal::orderBy('nome')->get(['id', 'nome as name']),
            'evento_grupos' => EventoGrupo::orderBy('nome')->get(['id', 'nome as name']),
            //'evento_areas' => EventoArea::orderBy('nome')->get(['id', 'nome as name']),
            'evento_areas' => EventoArea::get(['id', 'nome as name']),
            'meses' => $this->getMeses(),
        ]);
    }

    // Método p/ obter dados da tabela
    public function eventos()
    {
        //dd($this->fil_area_ids);

        return Evento::query()
            ->withAggregate('toGrupo', 'nome')
            ->withAggregate('toLocal', 'nome')
            ->withAggregate('areas', 'nome')
            ->when($this->search, function ($query, $val) {
                $query->where('nome', 'like', '%' . $val . '%');
                $query->orWhere('notas', 'like', '%' . $val . '%');
                return $query;
            })
            ->when($this->fil_grupo, function ($query, $val) {
                $query->where('evento_grupo_id', $val);
                return $query;
            })
            ->when($this->fil_local, function ($query, $val) {
                $query->where('evento_local_id', $val);
                return $query;
            })
            ->when($this->fil_area_ids, function ($query, $val) {
                $query->whereHas('areas', function ($q) use ($val) {
                    $q->whereIn('evento_area_id', $val);
                });
                return $query;
            })
            ->when($this->fil_mes, function ($query, $val) {
                $query->whereMonth('start_date', $val);
                return $query;
            })
            /* ->when($this->date_init, function ($query, $val) {
                $query->whereBetween('start_date', [$this->date_init, $this->date_end]);
                return $query;
            }) */
            ->orderBy(...array_values($this->sortBy))
            ->paginate(25);
    }

    //* Método p/ Cabeçalho da tabela
    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-base-200 w-1'],
            ['key' => 'start_date', 'label' => 'Data início'],
            ['key' => 'start_time', 'label' => 'Hora início'],
            ['key' => 'dia_semana', 'label' => 'Semana'],
            ['key' => 'nome', 'label' => 'Nome'],
            ['key' => 'to_grupo_nome', 'label' => 'Grupo'],
            ['key' => 'to_local_nome', 'label' => 'Local'],
            ['key' => 'areas_nome', 'label' => 'Area'],
            ['key' => 'notas', 'label' => 'Notas', 'sortable' => false],
        ];
    }

    // Método p/ habilitar modal Edit/Create.
    public function showModalRegistro()
    {
        $this->form->reset();
        $this->modalRegistro = true;
    }

    // Método p/ carregar inputs do form.
    public function edit($id)
    {
        $registro = Evento::find($id);
        $this->form->setRegistro($registro);
        $this->registroEditMode = true;
        $this->modalRegistro = true;
    }

    // Método p/ salvar: STORE ou UPDATE
    public function save()
    {
        if ($this->registroEditMode) {
            $this->form->update();
            $this->registroEditMode = false;
            $this->success('Registro salvo com sucesso!');
        } else {
            $this->form->store();
            $this->success('Registro incluído com sucesso!');
        }
        $this->modalRegistro = false;
    }

    // Método p/ confirmar delete.
    public function confirmDelete($id)
    {
        $this->registro_id = $id;
        $this->modalConfirmDelete = true;
    }

    // Método para deletar.
    public function delete($id)
    {
        $evento = Evento::find($id);
        DB::transaction(function () use ($evento) {
            // Exclui possíveis registros na tabela pivot relacionada a este usuário.
            $evento->areas()->detach();

            // Exclui do DB o registro.
            $evento->delete();
        });

        $this->modalConfirmDelete = false;
        $this->success('Registro excluído com sucesso!');
    }

    public function filtrar()
    {
        $this->qdeFilter = 0;
        if ($this->fil_grupo) {
            $this->qdeFilter++;
        }
        if ($this->fil_local) {
            $this->qdeFilter++;
        }
        if ($this->fil_mes) {
            $this->qdeFilter++;
        }
        if ($this->fil_area_ids) {
            $this->qdeFilter++;
        }
        if ($this->date_init) {
            $this->qdeFilter++;
        }
        if ($this->search) {
            $this->qdeFilter++;
        }

        $this->eventos();
        $this->showDrawer = false;
    }

    public function limpaFiltros()
    {
        $this->search = '';
        $this->fil_grupo = '';
        $this->fil_local = '';
        $this->fil_mes = '';
        $this->date_init = '';
        $this->date_end = '';
        $this->showDrawer = false;
        $this->qdeFilter = 0;
    }
    public function getMeses()
    {
        $meses = [
            [
                'id' => 1,
                'name' => 'Janeiro',
            ],
            [
                'id' => 2,
                'name' => 'Fevereiro',
            ],
            [
                'id' => 3,
                'name' => 'Março',
            ],
            [
                'id' => 4,
                'name' => 'Abril',
            ],
            [
                'id' => 5,
                'name' => 'Maio',
            ],
            [
                'id' => 6,
                'name' => 'Junho',
            ],
            [
                'id' => 7,
                'name' => 'Julho',
            ],
            [
                'id' => 8,
                'name' => 'Agosto',
            ],
            [
                'id' => 9,
                'name' => 'Setembro',
            ],
            [
                'id' => 10,
                'name' => 'Outubro',
            ],
            [
                'id' => 11,
                'name' => 'Novembro',
            ],
            [
                'id' => 12,
                'name' => 'Dezembro',
            ]
        ];
        return $meses;
    }

    public function openCalendar()
    {
        $this->redirectRoute('evento.calendar', ['mes' => $this->fil_mes, 'local' => $this->fil_local, 'grupo' => $this->fil_grupo]);
    }
    public function openPdf()
    {
        $dados = Evento::query()
            ->withAggregate('toGrupo', 'nome')
            ->withAggregate('toLocal', 'nome')
            ->withAggregate('areas', 'nome')
            ->when($this->search, function ($query, $val) {
                $query->where('nome', 'like', '%' . $val . '%');
                $query->orWhere('notas', 'like', '%' . $val . '%');
                return $query;
            })
            ->when($this->fil_grupo, function ($query, $val) {
                $query->where('evento_grupo_id', $val);
                return $query;
            })
            ->when($this->fil_local, function ($query, $val) {
                $query->where('evento_local_id', $val);
                return $query;
            })
            ->when($this->fil_area_ids, function ($query, $val) {
                $query->whereHas('areas', function ($q) use ($val) {
                    $q->whereIn('evento_area_id', $val);
                });
                return $query;
            })
            ->when($this->fil_mes, function ($query, $val) {
                $query->whereMonth('start_date', $val);
                return $query;
            })
            ->get();
        //dd($dados);
        $pdf = Pdf::loadView('pdfs.eventos', [
            'titulo' => 'Eventos',
            'dados' => $dados,
            //'filters' => $request,
        ]);

        //return $pdf->download('recibo.pdf');
        return $pdf->stream('Eventos.pdf');
    }
}
