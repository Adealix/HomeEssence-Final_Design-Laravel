<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use DB;
use Illuminate\Support\Facades\Request;

class SalesBarChart extends Chart
{
    public function __construct()
    {
        parent::__construct();

        // Retrieve date range from request parameters if provided.
        $dateFrom = Request::get('date_from');
        $dateTo   = Request::get('date_to');

        // Build the query with an optional date range filter.
        $query = DB::table('orderline AS ol')
            ->join('orderinfo AS o', 'ol.orderinfo_id', '=', 'o.orderinfo_id')
            ->join('item AS i', 'ol.item_id', '=', 'i.item_id');

        if ($dateFrom) {
            $query->whereDate('o.date_placed', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('o.date_placed', '<=', $dateTo);
        }

        $sales = $query->select(DB::raw('DATE(o.date_placed) as date'), DB::raw('sum(ol.quantity * i.sell_price) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('total', 'date')
            ->toArray();

        $dates = array_keys($sales);
        $data = array_values($sales);

        $this->labels($dates);
        $this->dataset('Sales', 'bar', $data)
             ->options([
                 'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                 'borderColor' => 'rgba(54, 162, 235, 1)',
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