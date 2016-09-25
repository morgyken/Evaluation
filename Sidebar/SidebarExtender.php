<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Evaluation\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Ignite\Core\Contracts\Authentication;

/**
 * Description of SidebarExtender
 *
 * @author Samuel Dervis <samueldervis@gmail.com>
 */
class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender {

    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth) {
        $this->auth = $auth;
    }

    public function extendWith(\Maatwebsite\Sidebar\Menu $menu) {
        $menu->group('Dashboard', function (Group $group) {
            $group->item('Evaluation', function (Item $item) {
                $item->weight(2);
                $item->icon('fa fa-heartbeat');
                $item->item('Preliminary Examinations', function (Item $item) {
                    $item->icon('fa fa-wheelchair');
                    $item->route('evaluation.waiting_nurse');
                    $item->authorize($this->auth->hasAccess('Evaluation.Nurse'));
                });
                $item->item('Doctor\'s queue', function (Item $item) {
                    $item->icon('fa fa-wheelchair-alt');
                    $item->route('evaluation.waiting_doctor');
                    $item->authorize($this->auth->hasAccess('Evaluation.Doctor'));
                });
                $item->item('Radiology Queue', function (Item $item) {
                    $item->icon('fa fa-braille');
                    $item->route('evaluation.waiting_radiology');
                    $item->authorize($this->auth->hasAccess('Evaluation.Radiology'));
                });
                $item->item('Diagnostics Queue', function (Item $item) {
                    $item->icon('fa fa-hotel');
                    $item->route('evaluation.waiting_diagnostics');
                    $item->authorize($this->auth->hasAccess('Evaluation.Diagnostics'));
                });
                $item->item('Laboratory Queue', function (Item $item) {
                    $item->icon('fa fa-diamond');
                    $item->route('evaluation.waiting_laboratory');
                    $item->authorize($this->auth->hasAccess('Evaluation.Laboratory'));
                });
                $item->item('Theatre Queue', function (Item $item) {
                    $item->icon('fa fa-diamond');
                    $item->route('evaluation.waiting_theatre');
                    $item->authorize($this->auth->hasAccess('Evaluation.Theatre'));
                });
                $item->item('Review Visits', function (Item $item) {
                    $item->icon('fa fa-deaf');
                    $item->route('evaluation.review');
                    $item->authorize($this->auth->hasAccess('Evaluation.Review'));
                });
            });
        });
        return $menu;
    }

}
