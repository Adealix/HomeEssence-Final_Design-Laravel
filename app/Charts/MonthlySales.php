<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use DB;

class MonthlySales extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Get the total sales per month
        $sales = DB::table('orderline')
            ->join('orderinfo', 'orderline.orderinfo_id', '=', 'orderinfo.orderinfo_id')
            ->join('item', 'orderline.item_id', '=', 'item.item_id')
            ->select(DB::raw('MONTH(orderinfo.date_placed) as month'), DB::raw('sum(orderline.quantity * item.sell_price) as total'))
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->pluck('total', 'month')
            ->toArray();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data = [];
        foreach ($months as $index => $month) {
            $data[] = $sales[$index + 1] ?? 0;
        }

        $this->labels($months);
        $this->dataset('Monthly Sales', 'line', $data)
             ->options([
                 'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                 'borderColor' => 'rgba(255, 99, 132, 1)',
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