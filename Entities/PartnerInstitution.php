<?php

namespace Ignite\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Evaluation\Entities\PartnerInstitution
 *
 * @property int $id
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
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereBuilding($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution wherePostCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereTelephone($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereTown($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Evaluation\Entities\PartnerInstitution whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PartnerInstitution extends Model {

    protected $guarded = [];
    public $table = 'evaluation_lab_partner_institutions';

}
