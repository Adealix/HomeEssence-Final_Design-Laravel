<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use DB;

class CustomerChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Get the number of customers per month
        $customers = DB::table('users')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->pluck('total', 'month')
            ->toArray();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data = [];
        foreach ($months as $index => $month) {
            $data[] = $customers[$index + 1] ?? 0;
        }

        $this->labels($months);
        $this->dataset('Customers', 'bar', $data)
             ->options([
                 'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                 'borderColor' => 'rgba(75, 192, 192, 1)',
                 'borderWidth' => 1,
             ]);

        $this->options([
            'responsive' => true,
            'legend' => ['display' => false],
            'tooltips' => ['enabled' => true],
            'scales' => [
                'yAxes' => [[
                    'ticks' => ['beginAtZero' => true]
                ]]
            ]
        ]);
    }
}