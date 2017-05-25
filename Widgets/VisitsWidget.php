<?php

namespace Ignite\Evaluation\Widgets;

use Ignite\Core\Library\BaseDashboardWidgets;
use Ignite\Evaluation\Entities\Visit;

class VisitsWidget extends BaseDashboardWidgets {

    /**
     * Get the widget name
     * @return string
     */
    protected function name() {
        return 'VisitsWidget';
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view() {
        return 'evaluation::widgets.visits';
    }

    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data() {
        return ['visitCount' => Visit::all()->count()];
    }

    /**
     * Get the widget type
     * @return string
     */
    protected function options() {
        return [
            'width' => '2',
            'height' => '2',
            'x' => '0',
            'y' => '0',
        ];
    }

}
