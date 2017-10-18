<?php

namespace Ignite\Evaluation\Widgets;


use Carbon\Carbon;
use Ignite\Core\Library\BaseDashboardWidgets;
use Ignite\Finance\Entities\EvaluationPaymentsDetails;

class RevenuePerDepartment extends BaseDashboardWidgets
{

    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'Revenue Per Department';
    }

    /**
     * Return an array of widget options
     * Possible options:
     *  x, y, width, height
     * @return array
     */
    protected function options()
    {
        return [
            'width' => '6',
            'height' => '8',
            'x' => '0',
            'y' => '0',
        ];
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'evaluation::widgets.revenue_pd';
    }

    /**
     * Get the widget data to send to the view
     * @return array
     */
    protected function data()
    {
        $raw_count = \DB::raw('sum(cost) as count');
        $build = EvaluationPaymentsDetails::query();//select('visit', $raw_count);
        if (request('rpd_from')) {
            $d1 = Carbon::parse(request('rpd_from'))->startOfDay()->toDateTimeString();
            $build = $build->where('created_at', '>=', $d1);
        }
        if (request('rpd_to')) {
            $d1 = Carbon::parse(request('rpd_to'))->endOfDay()->toDateTimeString();
            $build = $build->where('created_at', '<=', $d1);
        }
        /** @var EvaluationPaymentsDetails[] $found */
        $found = $build->get();
        $list = [];
        foreach ($found as $item) {
            if ($item->prescription_id) {
                @$list['Pharmacy'] += $item->cost;
            } else {
                if (!empty($item->investigations)) {
                    $type = ucfirst($item->investigations->type);
                    @$list[$type] += $item->cost;
                }
            }
        }
        $list = collect($list)->transform(function ($value, $key) {
            return ['name' => $key, 'amount' => $value];
        });
        $chart = \Charts::create('bar', 'highcharts')
            ->title('Revenue Per Department')
            ->elementLabel('Amount')
            ->labels($list->pluck('name'))
            ->values($list->pluck('amount'))
            ->template('material')
            ->container('revenue_pd')
            ->width(0)
            ->height(0);
        return ['revenue_pd_chart' => $chart];
    }
}