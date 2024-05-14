<?php

namespace App\Livewire;

use App\Models\Evento;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

class DashboardIndex extends Component
{
    #[Title('Dashboard')]
    public function render()
    {
        return view('livewire.dashboard-index',[
            'nextEvets' => $this->nextEvets(),
            'previousEvets' => $this->previousEvets(),
        ]);
    }

    public function nextEvets()
    {
/*         $dados = Evento::query()
            ->latest('start_date')
            ->limit(20)
            ->get();
        //dd($dados);
        $anchor = Carbon::today()->subDay(7); */
        
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(7);
        $dados = Evento::query()
            ->withAggregate('toGrupo', 'nome')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->get();
        //dd($invoices);
        return $dados;
    }
    public function previousEvets()
    {
        $startDate = Carbon::today()->subDay(7);
        $endDate = Carbon::today();
        $dados = Evento::query()
            ->withAggregate('toGrupo', 'nome')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->orderBy('start_date')
            ->get();
        return $dados;

        //dd($invoices->toArray());
    }
}
