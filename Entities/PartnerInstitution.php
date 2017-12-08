<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;


/**
 * Ignite\Evaluation\Entities\PartnerInstitution
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string|null $post_code
 * @property string $town
 * @property string $street
 * @property string $building
 * @property string|null $telephone
 * @property string $mobile
 * @property string|null $fax
 * @property string $email
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereTown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PartnerInstitution extends Model {

    protected $guarded = [];
    public $table = 'evaluation_lab_partner_institutions';

}
