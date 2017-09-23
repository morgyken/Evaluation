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
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\SidebarExtender as Panda;

/**
 * Description of SidebarExtender
 *
 * @author Samuel Dervis <samueldervis@gmail.com>
 */
class SidebarExtender implements Panda {

    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     */
    public function __construct(Authentication $auth) {
        $this->auth = $auth;
    }

    public function extendWith(Menu $menu) {
        $menu->group('Dashboard', function (Group $group) {
            $group->item('OutPatient', function (Item $item) {
                $item->weight(2);
                $item->authorize($this->auth->hasAccess('evaluation.*'));
                $item->icon('fa fa-heartbeat');

                if(!m_setting('evaluation.no_nursing')) {
                    $item->item('Preliminary Examinations', function (Item $item) {
                        $item->icon('fa fa-wheelchair');
                        $item->route('evaluation.queues', 'nurse');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.preliminary'));
                    });
                }

                if(!m_setting('evaluation.no_doctor')){
                    $item->item('Doctor\'s queue', function (Item $item) {
                        $item->icon('fa fa-wheelchair-alt');
                        $item->route('evaluation.queues', 'doctor');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.doctor'));
                    });
                }

                $item->item('Nursing Queue', function (Item $item) {
                    $item->icon('fa fa-wheelchair');
                    $item->route('evaluation.queues', 'nurse');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.preliminary'));
                });

                $item->item('Doctor\'s queue', function (Item $item) {
                    $item->icon('fa fa-wheelchair-alt');
                    $item->route('evaluation.queues', 'doctor');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.doctor'));
                });
                $item->item('Radiology Queue', function (Item $item) {
                    $item->icon('fa fa-braille');
                    $item->route('evaluation.queues', 'radiology');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.radiology'));
                });
                $item->item('Diagnostics Queue', function (Item $item) {
                    $item->icon('fa fa-hotel');
                    $item->route('evaluation.queues', 'diagnostics');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.diagnostics'));
                });

                $item->item('Laboratory Queue', function (Item $item) {
                    $item->icon('fa fa-diamond');
                    $item->route('evaluation.queues', 'laboratory');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                });

                if(!m_setting('evaluation.no_pharmacy')) {
                    $item->item('Pharmacy Queue', function (Item $item) {
                        $item->icon('fa fa-tablet');
                        $item->route('evaluation.queues', 'pharmacy');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.pharmacy'));
                    });
                }


                  $item->item('Radiology Queue', function (Item $item) {
                  $item->icon('fa fa-braille');
                  $item->route('evaluation.queues', 'radiology');
                  $item->authorize($this->auth->hasAccess('evaluation.examination.radiology'));
                  });

                  $item->item('Ultrasound Queue', function (Item $item) {
                  $item->icon('fa fa-qrcode');
                  $item->route('evaluation.queues', 'ultrasound');
                  $item->authorize($this->auth->hasAccess('evaluation.examination.ultrasound'));
                  });

                  /*
                  $item->item('Diagnostics Queue', function (Item $item) {
                  $item->icon('fa fa-hotel');
                  $item->route('evaluation.queues', 'diagnostics');
                  $item->authorize($this->auth->hasAccess('evaluation.examination.diagnostics'));
                  });

                  $item->item('Theatre Queue', function (Item $item) {
                  $item->icon('fa fa-heartbeat');
                  $item->route('evaluation.queues', 'theatre');
                  $item->authorize($this->auth->hasAccess('evaluation.examination.theatre'));
                  });
                  $item->item('Pharmacy Queue', function (Item $item) {
                  $item->icon('fa fa-tablet');
                  $item->route('evaluation.queues', 'pharmacy');
                  $item->authorize($this->auth->hasAccess('evaluation.examination.pharmacy'));
                  });
                  $item->item('Physiotherapy Queue', function (Item $item) {
                  $item->icon('fa fa-openid');
                  $item->route('evaluation.queues', 'physio');
                  $item->authorize($this->auth->hasAccess('evaluation.examination.physio'));
                  });
                 *
                 */
                $item->item('Review Visits', function (Item $item) {
                    $item->icon('fa fa-deaf');
                    $item->route('evaluation.review');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.review'));
                });
            });
            try{
                if(\Auth::user()->ex){
//                $group->item('External Doctor', function (Item $item) {
//                    $item->weight(2);
//                    $item->authorize($this->auth->hasAccess('external.*'));
//                    $item->icon('fa fa-handshake-o');

                    $group->item('New Patient', function (Item $item) {
                        $item->icon('fa fa-plus');
                        $item->route('reception.add_patient');
                        // $item->authorize($this->auth->hasAccess('evaluation.external'));
                    });

                    $group->item('Manage Patients', function (Item $item) {
                        $item->icon('fa fa-id-badge');
                        $item->route('evaluation.exdoctor.patients');
                        // $item->authorize($this->auth->hasAccess('evaluation.external'));
                    });

                    $group->item('Order Tests', function (Item $item) {
                        $item->icon('fa fa-grav');
                        $item->route('evaluation.exdoctor.p_order');
                        //$item->authorize($this->auth->hasAccess('evaluation.external'));
                    });

                    $group->item('View Results', function (Item $item) {
                        $item->icon('fa fa-eye');
                        $item->route('evaluation.exdoctor.p_results');
                        //$item->authorize($this->auth->hasAccess('evaluation.external'));
                    });
//                });
                }
            }catch (\Exception $e){

            }

            // $group->item('In Patient Management', function(Item $item) {
            //     $item->icon('fa fa-hospital-o');
            //     //$item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
            //     $item->weight(4);
            //     //there should be a way of adding wards and listing them

            //     $item->item('Awaiting admission', function(Item $item) {
            //         $item->icon('fa fa-user-plus');
            //         $item->route('evaluation.inpatient.admit');
            //         //$item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
            //         $item->weight(4);
            //     });
            //     $item->item('Patient Management', function(Item $item) {
            //         $item->icon('fa fa-users');
            //         $item->url('/evaluation/inpatient/admissions');
            //         //$item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
            //         $item->weight(4);
            //     });
            //     //patients waiting admissions
            //     $item->item('Requested Discharge ', function(Item $item) {
            //         $item->icon('fa fa-exclamation-circle');
            //         $item->url('/evaluation/inpatient/request_discharge');
            //         //$item->authorize($this->auth->hasAccess('evaluation.settings.admit_patient'));
            //         $item->weight(4);
            //     });
            // });

            $group->item('Setup', function (Item $item) {
                $item->item('Procedure Categories', function(Item $item) {
                    $item->icon('fa fa-wpforms');
                    $item->route('evaluation.setup.procedure_cat', 'procedure_categories');
                    $item->authorize($this->auth->hasAccess('evaluation.settings.procedure_categories'));
                    $item->weight(4);
                });

                //Account topUp
                $item->item('Procedures', function(Item $item) {
                    $item->icon('fa fa-hourglass-1');
                    $item->route('evaluation.setup.procedures', 'procedures');
                    $item->authorize($this->auth->hasAccess('evaluation.settings.procedures'));
                    $item->weight(4);
                });
                $item->item('Partner Institutions', function(Item $item) {
                    $item->icon('fa fa-users');
                    $item->route('evaluation.setup.partners', 'partners');
                    $item->authorize($this->auth->hasAccess('evaluation.settings.partners'));
                    $item->weight(4);
                });

                $item->item('Laboratory', function(Item $item) {
                    $item->icon('fa fa-flask');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                    $item->weight(4);

                    $item->item('Test Categories', function(Item $item) {
                        $item->icon('fa fa-copyright');
                        $item->route('evaluation.setup.test.categories');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                        $item->weight(4);
                    });

                    $item->item('Reference Ranges', function(Item $item) {
                        $item->icon('fa fa-arrows-h');
                        $item->route('evaluation.setup.ranges');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                        $item->weight(4);
                    });

                    $item->item('Age Groups', function(Item $item) {
                        $item->icon('fa fa-user');
                        $item->route('evaluation.setup.ranges');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                        $item->weight(4);
                    });

                    $item->item('Age Groups', function(Item $item) {
                        $item->icon('fa fa-font');
                        $item->route('evaluation.setup.age_groups');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                        $item->weight(4);
                    });

                    $item->item('Range Type/Category', function(Item $item) {
                        $item->icon('fa fa-paperclip');
                        //$item->color('red');
                        $item->route('evaluation.setup.range_types');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                        $item->weight(4);
                    });

                    $item->item('Sample Types', function(Item $item) {
                        $item->icon('fa fa-eyedropper');
                        $item->route('evaluation.setup.samples.types');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                        $item->weight(4);
                    });

                    $item->item('Sample Collection Methods', function(Item $item) {
                        $item->icon('fa fa-hand-lizard-o');
                        $item->route('evaluation.setup.methods');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                        $item->weight(4);
                    });

                    $item->item('Test Units', function(Item $item) {
                        $item->icon('fa fa-bookmark-o');
                        $item->route('evaluation.setup.units');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                        $item->weight(4);
                    });

                    $item->item('Additives/Containers', function(Item $item) {
                        $item->icon('fa fa-flask');
                        $item->route('evaluation.setup.additives');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                        $item->weight(4);
                    });

                    $item->item('Test Titles', function(Item $item) {
                        $item->icon('fa fa-dedent');
                        $item->route('evaluation.setup.test.titles');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                        $item->weight(4);
                    });

                    $item->item('Formulae', function(Item $item) {
                        $item->icon('fa fa-calculator');
                        $item->route('evaluation.setup.formulae');
                        $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                        $item->weight(4);
                    });

                    /*
                      $item->item('Samples', function(Item $item) {
                      $item->icon('fa fa-bars');
                      $item->route('evaluation.setup.test.samples', 'partners');
                      $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                      $item->weight(4);
                      }); */
                });

                $item->item('Remarks Templates', function(Item $item) {
                    $item->icon('fa fa-bars');
                    $item->route('evaluation.setup.remarks');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                    $item->weight(4);
                });
                /*
                  $item->item('Laboratory', function(Item $item) {
                  $item->icon('fa fa-flask');
                  $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
               /*
                  $item->item('Sub-Procedures', function(Item $item) {
                  $item->icon('fa fa-tree');
                  $item->route('evaluation.setup.subprocedures', 'procedures');
                  $item->authorize($this->auth->hasAccess('evaluation.settings.procedures'));
                  $item->weight(4);

                  $item->item('Test Categories', function(Item $item) {
                  $item->icon('fa fa-copyright');
                  $item->route('evaluation.setup.test.categories', 'partners');
                  $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                  $item->weight(4);
                  });

                  $item->item('Test Titles', function(Item $item) {
                  $item->icon('fa fa-bars');
                  $item->route('evaluation.setup.test.titles', 'partners');
                  $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                  $item->weight(4);
                  });
                  });
                 *
                 */
            });
        });
        return $menu;
    }

}
