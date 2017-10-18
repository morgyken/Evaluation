<?php

namespace Ignite\Evaluation\Widgets;

use Carbon\Carbon;
use Ignite\Core\Library\BaseDashboardWidgets;
use Ignite\Evaluation\Entities\VisitDestinations;
use Ignite\Evaluation\Entities\Visit;

class QueueWidget extends BaseDashboardWidgets
{

    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'QueueWidget';
    }

    /**
     * Get the widget options
     * Possible options:
     *  x, y, width, height
     * @return array
     */
    protected function options()
    {
        return [
            'width' => '6',
            'height' => '2',
            'x' => '0',
            'y' => '3',
        ];
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'evaluation::widgets.queue';
    }

    /**
     * Get the widget data to send to the view
     */
    protected function data()
    {
        $today = Carbon::now()->startOfDay()->toDateTimeString();
        $seen = Visit::where('created_at', '>=', $today)->get();
        return ['seen' => $seen];
    }

}
