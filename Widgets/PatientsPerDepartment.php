<?php

namespace Ignite\Evaluation\Widgets;

use Carbon\Carbon;
use Ignite\Core\Library\BaseDashboardWidgets;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Entities\VisitDestinations;

class PatientsPerDepartment extends BaseDashboardWidgets
{

    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'Patients Per Department';
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
            'x' => '6',
            'y' => '2',
        ];
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'evaluation::widgets.patients_pd';
    }

    /**
     * Get the widget data to send to the view
     * @return array
     */
    protected function data()
    {
        $raw_count = \DB::raw('count(*) as count');
        $visits = VisitDestinations::select('department', $raw_count);
        if (request('ppd_from')) {
            $d1 = Carbon::parse(request('ppd_from'))->startOfDay()->toDateTimeString();
            $visits = $visits->where('created_at', '>=', $d1);
        }
        if (request('ppd_to')) {
            $d1 = Carbon::parse(request('ppd_to'))->endOfDay()->toDateTimeString();
            $visits = $visits->where('created_at', '<=', $d1);
        }
        $visits = $visits->groupBy('department')
            ->get()
            ->reject(function ($value) {
                return empty($value->department);
            });

        $chart = \Charts::create('bar', 'highcharts')
            ->title('Patients Per Department')
            ->elementLabel('Patients')
            ->labels($visits->pluck('department'))
            ->values($visits->pluck('count'))
            ->template('material')
            ->container('patients_pd')
            ->width(0)
            ->height(0);
        return ['patients_pd_chart' => $chart];
    }
}