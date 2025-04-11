<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use DB;

class ItemChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Get the number of items sold per month
        $items = DB::table('orderline')
            ->join('orderinfo', 'orderline.orderinfo_id', '=', 'orderinfo.orderinfo_id')
            ->select(DB::raw('MONTH(orderinfo.date_placed) as month'), DB::raw('sum(orderline.quantity) as total'))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->pluck('total', 'month')
            ->toArray();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data = [];
        foreach ($months as $index => $month) {
            $data[] = $items[$index + 1] ?? 0;
        }

        $this->labels($months);
        $this->dataset('Items Sold', 'bar', $data)
             ->options([
                 'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                 'borderColor' => 'rgba(153, 102, 255, 1)',
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