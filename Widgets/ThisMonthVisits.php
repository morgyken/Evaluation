<?php

namespace Ignite\Evaluation\Widgets;

use Ignite\Core\Library\BaseDashboardWidgets;
use Ignite\Evaluation\Entities\Visit;

class ThisMonthVisits extends BaseDashboardWidgets {

    /**
     * Get the widget name
     * @return string
     */
    protected function name() {
        return 'ThisMonthVisits';
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view() {
        return 'evaluation::widgets.month_visits';
    }

    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data() {
        return ['visitCount' => Visit::where(\DB::raw('MONTH(created_at)'), '=', date('n'))->count()];
    }

    /**
     * Get the widget type
     * @return string
     */
    protected function options() {
        return [
            'width' => '2',
            'height' => '2',
            'x' => '2',
            'y' => '0',
        ];
    }

}
