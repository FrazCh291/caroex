<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyProductReportChart
{
    protected $chart;
    protected $data;

    public function __construct(LarapexChart $chart, $data)
    {

        dd($this->data);
        $this->chart = $chart;
    }

    public function build($data): \Illuminate\Http\JsonResponse
    {
        return $this->chart->lineChart()
            ->setTitle('Sales during 2021.')
            ->setSubtitle('Physical sales vs Digital sales.')
            ->addData('Physical sales', [40, 93, 35, 42, 18, 82])

            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June'])
            ->toJson();
    }
}
