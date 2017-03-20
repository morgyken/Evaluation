<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\PartnerInstitution
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $post_code
 * @property string $town
 * @property string $street
 * @property string $building
 * @property string $telephone
 * @property string $mobile
 * @property string $fax
 * @property string $email
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class PartnerInstitution extends Model {

    protected $guarded = [];
    public $table = 'evaluation_lab_partner_institutions';

}
