<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $addressable_type
 * @property int $addressable_id
 * @property string|null $block_lot_phase
 * @property string|null $street
 * @property string|null $subdivision
 * @property int|null $barangay_id
 * @property string|null $city
 * @property string|null $province
 * @property string|null $postal_code
 * @property bool $is_primary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $addressable
 * @property-read \App\Models\Barangay|null $barangay
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAddressableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAddressableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereBlockLotPhase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereSubdivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $suffix
 * @property string $role_type
 * @property int|null $barangay_id
 * @property int|null $facility_id
 * @property string|null $contact_number
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $address
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereFacilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereRoleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereUserId($value)
 * @mixin \Eloquent
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile_number
 * @property string|null $alt_mobile_number
 * @property string $blk_lot_ph
 * @property string $street
 * @property string $barangay
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string|null $occupation
 * @property string $company
 * @property string|null $social_media
 * @property string $adopted_before
 * @property string $status
 * @property string|null $alternate_contact
 * @property array<array-key, mixed>|null $questionnaire
 * @property string|null $valid_id_path
 * @property string|null $zoom_interview
 * @property \Illuminate\Support\Carbon|null $zoom_date
 * @property string|null $zoom_time
 * @property string|null $zoom_time_ampm
 * @property string|null $shelter_visit
 * @property int|null $selected_pet_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pet|null $pet
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereAdoptedBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereAltMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereAlternateContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereBlkLotPh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereQuestionnaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereSelectedPetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereShelterVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereSocialMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereValidIdPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereZoomDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereZoomInterview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereZoomTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereZoomTimeAmpm($value)
 * @mixin \Eloquent
 */
	class AdoptionApplication extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\ImpoundRecord|null $impound
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdoptionStatusHistory> $statusHistory
 * @property-read int|null $status_history_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionRequest query()
 * @mixin \Eloquent
 */
	class AdoptionRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\AdoptionRequest|null $adoptionRequest
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionStatusHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionStatusHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionStatusHistory query()
 * @mixin \Eloquent
 */
	class AdoptionStatusHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pet> $pets
 * @property-read int|null $pets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AdoptionTrait extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $attachment_path
 * @property string|null $photo_path
 * @property string $category
 * @property bool $is_active
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $event_date
 * @property string|null $event_time
 * @property string|null $location
 * @property string|null $contact_number
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnnouncementRead> $reads
 * @property-read int|null $reads_count
 * @property-read \App\Models\User|null $usersRead
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement campaigns()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement events()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereAttachmentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereEventTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement wherePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Announcement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $announcement_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $read_at
 * @property-read \App\Models\Announcement $announcement
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead whereAnnouncementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead whereUserId($value)
 * @mixin \Eloquent
 */
	class AnnouncementRead extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon $appointment_date
 * @property mixed $appointment_time
 * @property string $service_type
 * @property int $service_id
 * @property string $status
 * @property int $total_weight
 * @property array<array-key, mixed>|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $service
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereAppointmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereAppointmentTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereServiceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereTotalWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Appointment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $barangay_id
 * @property string $barangay_name
 * @property string $city
 * @property string $province
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $contact_number
 * @property string|null $office_email
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BiteRabiesReport> $biteRabiesReports
 * @property-read int|null $bite_rabies_reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClinicalAction> $clinicalActions
 * @property-read int|null $clinical_actions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Establishment> $establishments
 * @property-read int|null $establishments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Livestock> $livestock
 * @property-read int|null $livestock_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LivestockCensus> $livestockCensuses
 * @property-read int|null $livestock_censuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StrayReport> $strayReports
 * @property-read int|null $stray_reports_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereBarangayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereOfficeEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Barangay extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $status
 * @property string $report_number
 * @property string $patient_name
 * @property string|null $patient_first_name
 * @property string|null $patient_middle_name
 * @property string|null $patient_suffix
 * @property int $age
 * @property string $gender
 * @property string|null $patient_address
 * @property string|null $patient_contact
 * @property string|null $patient_barangay
 * @property int|null $barangay_id
 * @property string|null $incident_barangay
 * @property string|null $exact_location
 * @property \Illuminate\Support\Carbon $incident_date
 * @property string $exposure_type
 * @property string|null $bite_site
 * @property string $category
 * @property string $animal_type
 * @property string $animal_status
 * @property string $vaccination_status
 * @property string|null $animal_owner_name
 * @property string|null $animal_owner_contact
 * @property int|null $reported_by
 * @property string|null $reporting_facility
 * @property string|null $date_reported
 * @property array<array-key, mixed>|null $wound_management
 * @property string|null $post_exposure_prophylaxis
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Barangay|null $patientBarangay
 * @property-read \App\Models\User|null $reportedBy
 * @method static Builder<static>|BiteRabiesReport byAnimalType(string $type)
 * @method static Builder<static>|BiteRabiesReport byBarangay(int $barangayId)
 * @method static Builder<static>|BiteRabiesReport byCategory(string $category)
 * @method static Builder<static>|BiteRabiesReport byDateRange(string $from, string $to)
 * @method static Builder<static>|BiteRabiesReport newModelQuery()
 * @method static Builder<static>|BiteRabiesReport newQuery()
 * @method static Builder<static>|BiteRabiesReport query()
 * @method static Builder<static>|BiteRabiesReport whereAge($value)
 * @method static Builder<static>|BiteRabiesReport whereAnimalOwnerContact($value)
 * @method static Builder<static>|BiteRabiesReport whereAnimalOwnerName($value)
 * @method static Builder<static>|BiteRabiesReport whereAnimalStatus($value)
 * @method static Builder<static>|BiteRabiesReport whereAnimalType($value)
 * @method static Builder<static>|BiteRabiesReport whereBarangayId($value)
 * @method static Builder<static>|BiteRabiesReport whereBiteSite($value)
 * @method static Builder<static>|BiteRabiesReport whereCategory($value)
 * @method static Builder<static>|BiteRabiesReport whereCreatedAt($value)
 * @method static Builder<static>|BiteRabiesReport whereDateReported($value)
 * @method static Builder<static>|BiteRabiesReport whereExactLocation($value)
 * @method static Builder<static>|BiteRabiesReport whereExposureType($value)
 * @method static Builder<static>|BiteRabiesReport whereGender($value)
 * @method static Builder<static>|BiteRabiesReport whereId($value)
 * @method static Builder<static>|BiteRabiesReport whereIncidentBarangay($value)
 * @method static Builder<static>|BiteRabiesReport whereIncidentDate($value)
 * @method static Builder<static>|BiteRabiesReport whereNotes($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientAddress($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientBarangay($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientContact($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientFirstName($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientMiddleName($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientName($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientSuffix($value)
 * @method static Builder<static>|BiteRabiesReport wherePostExposureProphylaxis($value)
 * @method static Builder<static>|BiteRabiesReport whereReportNumber($value)
 * @method static Builder<static>|BiteRabiesReport whereReportedBy($value)
 * @method static Builder<static>|BiteRabiesReport whereReportingFacility($value)
 * @method static Builder<static>|BiteRabiesReport whereStatus($value)
 * @method static Builder<static>|BiteRabiesReport whereUpdatedAt($value)
 * @method static Builder<static>|BiteRabiesReport whereUserId($value)
 * @method static Builder<static>|BiteRabiesReport whereVaccinationStatus($value)
 * @method static Builder<static>|BiteRabiesReport whereWoundManagement($value)
 * @mixin \Eloquent
 */
	class BiteRabiesReport extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $series_id
 * @property string $series_name
 * @property int $year
 * @property int $last_number
 * @property string $prefix
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries whereLastNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries whereSeriesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries whereSeriesName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries whereYear($value)
 * @mixin \Eloquent
 */
	class CertificateSeries extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $case_title
 * @property string|null $action_type
 * @property int|null $pet_id
 * @property string|null $animal_name
 * @property string|null $species
 * @property string|null $owner_name
 * @property string|null $owner_contact
 * @property \Illuminate\Support\Carbon|null $action_date
 * @property string $description
 * @property string|null $diagnosis
 * @property string|null $treatment_given
 * @property string|null $medication
 * @property \Illuminate\Support\Carbon|null $follow_up_date
 * @property string|null $outcome
 * @property int|null $veterinarian_id
 * @property int|null $barangay_id
 * @property int|null $assigned_to
 * @property string $status
 * @property string|null $remarks
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\Pet|null $pet
 * @property-read \App\Models\User|null $veterinarian
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereActionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereActionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereAnimalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereCaseTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereFollowUpDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereMedication($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereOutcome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereOwnerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereTreatmentGiven($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereVeterinarianId($value)
 * @mixin \Eloquent
 */
	class ClinicalAction extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string|null $device_type
 * @property string|null $device_name
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $last_used_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken mobile()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken web()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken whereDeviceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken whereDeviceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceToken whereUserId($value)
 * @mixin \Eloquent
 */
	class DeviceToken extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $barangay_id
 * @property int|null $user_id
 * @property string $name
 * @property string $type
 * @property string|null $permit_no
 * @property string|null $address
 * @property string|null $contact_number
 * @property string|null $owner_name
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment byBarangay($barangayId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment byStatus($status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment byType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment wherePermitNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereUserId($value)
 * @mixin \Eloquent
 */
	class Establishment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\BiteRabiesReport|null $originalReport
 * @property-read \App\Models\Barangay|null $patientBarangay
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExposureCase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExposureCase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExposureCase query()
 * @mixin \Eloquent
 */
	class ExposureCase extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int|null $barangay_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facility query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facility whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facility whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facility whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facility whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Facility whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Facility extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $submission_id
 * @property int $form_id
 * @property int|null $submitted_by_user_id
 * @property string|null $citizen_name
 * @property string|null $citizen_contact
 * @property string|null $citizen_address
 * @property array<array-key, mixed>|null $payload_json
 * @property string $status
 * @property int|null $reviewed_by
 * @property \Illuminate\Support\Carbon|null $reviewed_at
 * @property string|null $review_notes
 * @property \Illuminate\Support\Carbon|null $submitted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ServiceForm $form
 * @property-read mixed $status_badge
 * @property-read \App\Models\User|null $reviewer
 * @property-read \App\Models\User|null $submitter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission approved()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission rejected()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereCitizenAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereCitizenContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereCitizenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission wherePayloadJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereReviewNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereReviewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereReviewedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereSubmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereSubmittedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class FormSubmission extends \Eloquent {}
}

namespace App\Models{
/**
 * @deprecated Scheduled for deletion 2026-05-24
 * @property-read \App\Models\User|null $capturedBy
 * @property-read \App\Models\Pet|null $pet
 * @property-read \App\Models\StrayReport|null $strayReport
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impound newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impound newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Impound query()
 * @mixin \Eloquent
 */
	class Impound extends \Eloquent {}
}

namespace App\Models{
/**
 * @deprecated Scheduled for deletion 2026-05-24
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdoptionRequest> $adoptionRequests
 * @property-read int|null $adoption_requests_count
 * @property-read \App\Models\User|null $approvedBy
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\User|null $recordedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ImpoundStatusHistory> $statusHistory
 * @property-read int|null $status_history_count
 * @property-read \App\Models\StrayReport|null $strayReport
 * @method static Builder<static>|ImpoundRecord approved()
 * @method static Builder<static>|ImpoundRecord closed()
 * @method static Builder<static>|ImpoundRecord impounded()
 * @method static Builder<static>|ImpoundRecord newModelQuery()
 * @method static Builder<static>|ImpoundRecord newQuery()
 * @method static Builder<static>|ImpoundRecord pending()
 * @method static Builder<static>|ImpoundRecord query()
 * @mixin \Eloquent
 */
	class ImpoundRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * @deprecated Scheduled for deletion 2026-05-24
 * @property-read \App\Models\ImpoundRecord|null $impound
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImpoundStatusHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImpoundStatusHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ImpoundStatusHistory query()
 * @mixin \Eloquent
 */
	class ImpoundStatusHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $item_name
 * @property string $category
 * @property string|null $unit
 * @property int $quantity
 * @property int $minimum_stock
 * @property numeric|null $unit_price
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $expiry_date
 * @property int|null $barangay_id
 * @property string $status
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StockMovement> $movements
 * @property-read int|null $movements_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereMinimumStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class InventoryControl extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $item_name
 * @property string|null $item_code
 * @property string $category
 * @property string|null $description
 * @property string $unit
 * @property int $quantity
 * @property int $min_stock_level
 * @property \Illuminate\Support\Carbon|null $expiry_date
 * @property string|null $supplier
 * @property numeric|null $cost_per_unit
 * @property string|null $location
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $stock_status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StockMovement> $stockMovements
 * @property-read int|null $stock_movements_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem byCategory($category)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem expired()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem expiringSoon($days = 30)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem lowStock()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereCostPerUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereItemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereMinStockLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryItem whereUserId($value)
 * @mixin \Eloquent
 */
	class InventoryItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $inventory_control_id
 * @property string $movement_type
 * @property int $quantity
 * @property string|null $reason
 * @property int|null $performed_by
 * @property int|null $barangay_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\InventoryControl $inventoryControl
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereInventoryControlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereMovementType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement wherePerformedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class InventoryMovement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $livestock_id
 * @property int|null $owner_id
 * @property string|null $farm_name
 * @property string|null $animal_type
 * @property int $quantity
 * @property int|null $barangay_id
 * @property string $species
 * @property string|null $breed
 * @property string|null $color
 * @property string $gender
 * @property int|null $age
 * @property string $age_unit
 * @property string|null $tag_number
 * @property string|null $owner_name
 * @property string|null $owner_contact
 * @property string|null $address
 * @property string $status
 * @property string|null $notes
 * @property int|null $recorded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\PetOwner|null $owner
 * @property-read \App\Models\User|null $recordedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereAgeUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereAnimalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereFarmName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereLivestockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereOwnerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereRecordedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereTagNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Livestock extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $barangay_id
 * @property int|null $encoded_by_user_id
 * @property string $species
 * @property int $no_of_heads
 * @property int $no_of_farmers
 * @property string $report_year
 * @property int $report_month
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read mixed $species_badge
 * @property-read mixed $species_name
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereEncodedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereNoOfFarmers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereNoOfHeads($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereReportMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereReportYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class LivestockCensus extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $establishment_id
 * @property string $establishment_name
 * @property string|null $establishment_type
 * @property string|null $owner_name
 * @property string|null $contact_person
 * @property string|null $contact_number
 * @property string|null $email
 * @property string $address_text
 * @property string|null $landmark
 * @property string|null $permit_no
 * @property string|null $inspection_date
 * @property int|null $barangay_id
 * @property int $registered_by_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Barangay|null $barangay
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereAddressText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereEstablishmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereEstablishmentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereEstablishmentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereInspectionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereLandmark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment wherePermitNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereRegisteredByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class MeatEstablishment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $inspection_id
 * @property int|null $establishment_id
 * @property int|null $inspector_user_id
 * @property string|null $inspector_name
 * @property string|null $inspection_type
 * @property \Illuminate\Support\Carbon $inspection_date
 * @property string $status
 * @property string|null $compliance_status
 * @property string|null $findings
 * @property string|null $observations
 * @property string|null $recommendations
 * @property string|null $overall_rating
 * @property string|null $remarks
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $approvedBy
 * @property-read \App\Models\MeatEstablishment|null $establishment
 * @property-read \App\Models\User|null $inspector
 * @method static Builder<static>|MeatInspection approved()
 * @method static Builder<static>|MeatInspection closed()
 * @method static Builder<static>|MeatInspection failed()
 * @method static Builder<static>|MeatInspection newModelQuery()
 * @method static Builder<static>|MeatInspection newQuery()
 * @method static Builder<static>|MeatInspection passed()
 * @method static Builder<static>|MeatInspection pending()
 * @method static Builder<static>|MeatInspection query()
 * @method static Builder<static>|MeatInspection whereApprovedAt($value)
 * @method static Builder<static>|MeatInspection whereApprovedBy($value)
 * @method static Builder<static>|MeatInspection whereComplianceStatus($value)
 * @method static Builder<static>|MeatInspection whereCreatedAt($value)
 * @method static Builder<static>|MeatInspection whereEstablishmentId($value)
 * @method static Builder<static>|MeatInspection whereFindings($value)
 * @method static Builder<static>|MeatInspection whereInspectionDate($value)
 * @method static Builder<static>|MeatInspection whereInspectionId($value)
 * @method static Builder<static>|MeatInspection whereInspectionType($value)
 * @method static Builder<static>|MeatInspection whereInspectorName($value)
 * @method static Builder<static>|MeatInspection whereInspectorUserId($value)
 * @method static Builder<static>|MeatInspection whereObservations($value)
 * @method static Builder<static>|MeatInspection whereOverallRating($value)
 * @method static Builder<static>|MeatInspection whereRecommendations($value)
 * @method static Builder<static>|MeatInspection whereRemarks($value)
 * @method static Builder<static>|MeatInspection whereStatus($value)
 * @method static Builder<static>|MeatInspection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class MeatInspection extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $inspection_id
 * @property int|null $establishment_id
 * @property int|null $inspector_user_id
 * @property string|null $inspector_name
 * @property string|null $inspection_type
 * @property \Illuminate\Support\Carbon $inspection_date
 * @property string $status
 * @property string|null $compliance_status
 * @property string|null $findings
 * @property string|null $observations
 * @property string|null $recommendations
 * @property string|null $overall_rating
 * @property string|null $remarks
 * @property int|null $approved_by
 * @property string|null $approved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $inspection_time
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport compliant()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport nonCompliant()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereComplianceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereEstablishmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereFindings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereInspectionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereInspectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereInspectionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereInspectorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereInspectorUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereObservations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereOverallRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereRecommendations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class MeatInspectionReport extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $meat_shop_id
 * @property string|null $address
 * @property \Illuminate\Support\Carbon $inspection_date
 * @property string|null $ticket_number
 * @property string|null $licensing
 * @property string|null $storage
 * @property string|null $meat_quality
 * @property string|null $sanitation
 * @property string|null $lighting
 * @property string|null $personal_hygiene
 * @property string|null $equipment
 * @property string $apprehension_status
 * @property int|null $apprehended_by_user_id
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $inspector
 * @property-read \App\Models\MeatEstablishment|null $meatShop
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection byDate($date)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection byShop($shopId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereApprehendedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereApprehensionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereEquipment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereInspectionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereLicensing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereLighting($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereMeatQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereMeatShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection wherePersonalHygiene($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereSanitation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereStorage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereTicketNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class MeatShopInspection extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $owner_id
 * @property string $type
 * @property string|null $appointment_date
 * @property string $status
 * @property string|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\Pet|null $pet
 * @property-read \App\Models\User|null $veterinarian
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereAppointmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereUserId($value)
 * @mixin \Eloquent
 */
	class MedicalRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $missing_id
 * @property string $pet_name
 * @property string $species
 * @property string|null $breed
 * @property int|null $age
 * @property numeric|null $weight
 * @property string|null $color
 * @property string $gender
 * @property \Illuminate\Support\Carbon $last_seen_at
 * @property string|null $description
 * @property string $location
 * @property string $status
 * @property string|null $photo_img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereLastSeenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereMissingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet wherePetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet wherePhotoImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereWeight($value)
 * @mixin \Eloquent
 */
	class MissingPet extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $report_id
 * @property int $user_id
 * @property int $pet_id
 * @property string|null $body_marks
 * @property string $eye_color
 * @property string|null $collar_harness
 * @property \Illuminate\Support\Carbon $last_seen_at
 * @property string $location_barangay
 * @property string|null $location_description
 * @property string|null $emergency_contact
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pet $pet
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereBodyMarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereCollarHarness($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereEmergencyContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereEyeColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereLastSeenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereLocationBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereLocationDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereUserId($value)
 * @mixin \Eloquent
 */
	class MissingPetsReport extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $notification_id
 * @property int $user_id
 * @property string $title
 * @property string $message
 * @property string $related_module
 * @property int|null $related_record_id
 * @property bool $is_read
 * @property string|null $priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereRelatedModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereRelatedRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 * @mixin \Eloquent
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property string $name
 * @property int|null $contact_user_id
 * @property string|null $contact_number
 * @property string|null $official_email
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $address
 * @property-read \App\Models\User|null $contactUser
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereContactUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereOfficialEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Organization extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Livestock> $livestock
 * @property-read int|null $livestock_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RabiesCase> $rabiesCases
 * @property-read int|null $rabies_cases_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner inBarangay($barangayId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner query()
 * @mixin \Eloquent
 */
	class Owner extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $pet_id
 * @property int|null $owner_id
 * @property string $pet_name
 * @property string $species
 * @property string $breed
 * @property string $gender
 * @property \Illuminate\Support\Carbon|null $birthdate
 * @property string|null $pet_image
 * @property string $vaccination_status
 * @property string|null $vaccination_date
 * @property string|null $next_vaccination_date
 * @property string|null $is_neutered
 * @property string|null $is_crossbreed
 * @property string|null $estimated_age
 * @property string|null $pet_weight
 * @property string|null $body_mark_image
 * @property string|null $body_mark_details
 * @property string|null $training
 * @property string|null $insurance
 * @property string|null $behavior
 * @property string|null $likes
 * @property string|null $dislikes
 * @property string|null $diet
 * @property string|null $allergy
 * @property string|null $source_module
 * @property int|null $source_module_id
 * @property bool $is_approved
 * @property \Illuminate\Support\Carbon|null $consolidated_at
 * @property string $pet_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read mixed $age
 * @property-read mixed $date_of_birth
 * @property-read mixed $description
 * @property-read mixed $image
 * @property-read mixed $is_age_estimated
 * @property-read mixed $weight
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicalRecord> $medicalRecords
 * @property-read int|null $medical_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MissingPetsReport> $missingReport
 * @property-read int|null $missing_report_count
 * @property-read \App\Models\PetOwner|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdoptionTrait> $traits
 * @property-read int|null $traits_count
 * @property-read \App\Models\User|null $userOwner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vaccination> $vaccinations
 * @property-read int|null $vaccinations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet availableForAdoption()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereAllergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBehavior($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBodyMarkDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBodyMarkImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereConsolidatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereDiet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereDislikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereEstimatedAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereIsCrossbreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereIsNeutered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereNextVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereSourceModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereSourceModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereVaccinationStatus($value)
 * @mixin \Eloquent
 */
	class Pet extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $owner_id
 * @property int|null $address_id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $middle_name
 * @property string|null $suffix
 * @property string $phone_number
 * @property string|null $alternate_phone_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date_of_birth
 * @property-read \App\Models\Address|null $address
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pet> $pets
 * @property-read int|null $pets_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereAlternatePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereUserId($value)
 * @mixin \Eloquent
 */
	class PetOwner extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $status
 * @property string $report_number
 * @property string $patient_name
 * @property string|null $patient_first_name
 * @property string|null $patient_middle_name
 * @property string|null $patient_suffix
 * @property int $age
 * @property string $gender
 * @property string|null $patient_address
 * @property string|null $patient_contact
 * @property string|null $patient_barangay
 * @property int|null $barangay_id
 * @property string|null $incident_barangay
 * @property string|null $exact_location
 * @property \Illuminate\Support\Carbon $incident_date
 * @property string $exposure_type
 * @property string|null $bite_site
 * @property string $category
 * @property string $animal_type
 * @property string $animal_status
 * @property string $vaccination_status
 * @property string|null $animal_owner_name
 * @property string|null $animal_owner_contact
 * @property int|null $reported_by
 * @property string|null $reporting_facility
 * @property string|null $date_reported
 * @property string|null $wound_management
 * @property string|null $post_exposure_prophylaxis
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\Owner|null $owner
 * @property-read \App\Models\BiteRabiesReport|null $rabiesReport
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereAnimalOwnerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereAnimalOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereAnimalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereAnimalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereBiteSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereDateReported($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereExactLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereExposureType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereIncidentBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereIncidentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePostExposureProphylaxis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereReportNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereReportedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereReportingFacility($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereVaccinationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereWoundManagement($value)
 * @mixin \Eloquent
 */
	class RabiesCase extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $clinic_name
 * @property string $patient_name
 * @property string $patient_contact
 * @property string $patient_address
 * @property string|null $pet_name
 * @property string $pet_species
 * @property string|null $pet_breed
 * @property int|null $pet_age
 * @property string|null $pet_gender
 * @property string|null $pet_color
 * @property string $vaccine_brand
 * @property string|null $vaccine_batch_number
 * @property \Illuminate\Support\Carbon $vaccination_date
 * @property mixed $vaccination_time
 * @property \Illuminate\Support\Carbon|null $next_vaccination_date
 * @property numeric|null $weight
 * @property string $vaccination_type
 * @property string|null $observations
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport completed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereClinicName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereNextVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereObservations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePatientAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePatientContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePatientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePetAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePetBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePetColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePetGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePetSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereVaccinationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereVaccinationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereVaccineBatchNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereVaccineBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereWeight($value)
 * @mixin \Eloquent
 */
	class RabiesVaccinationReport extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $report_type
 * @property array<array-key, mixed>|null $parameters
 * @property string|null $file_path
 * @property int|null $exported_by_user_id
 * @property \Illuminate\Support\Carbon $exported_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereExportedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereExportedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereReportType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ReportExport extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $form_id
 * @property string $form_type
 * @property string $title
 * @property string|null $description
 * @property bool $is_active
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Announcement> $announcements
 * @property-read int|null $announcements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FormSubmission> $approvedSubmissions
 * @property-read int|null $approved_submissions_count
 * @property-read \App\Models\User|null $creator
 * @property-read mixed $type_label
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FormSubmission> $pendingSubmissions
 * @property-read int|null $pending_submissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FormSubmission> $submissions
 * @property-read int|null $submissions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereFormType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ServiceForm extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string|null $pet_name
 * @property string|null $pet_breed
 * @property string|null $pet_age
 * @property string $owner_name
 * @property string|null $owner_contact
 * @property string|null $owner_address
 * @property string $procedure_type
 * @property string|null $veterinarian
 * @property string|null $clinic_name
 * @property numeric|null $weight
 * @property string $status
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon $report_date
 * @property string|null $barangay
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $gender
 * @property string|null $species
 * @property \Illuminate\Support\Carbon|null $scheduled_at
 * @property-read mixed $status_badge
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport byPetType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport byProcedureType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport dateRange($startDate, $endDate)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereClinicName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereOwnerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereOwnerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport wherePetAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport wherePetBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport wherePetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereProcedureType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereReportDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereVeterinarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereWeight($value)
 * @mixin \Eloquent
 */
	class SpayNeuterReport extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $inventory_item_id
 * @property int $user_id
 * @property string $movement_type
 * @property int $quantity
 * @property int $previous_quantity
 * @property int $new_quantity
 * @property string|null $reference_number
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon $movement_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $formatted_type
 * @property-read mixed $type_badge
 * @property-read \App\Models\InventoryItem $inventoryItem
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement adjustment()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement dateRange($startDate, $endDate)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement stockIn()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement stockOut()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereInventoryItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereMovementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereMovementType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereNewQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement wherePreviousQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereUserId($value)
 * @mixin \Eloquent
 */
	class StockMovement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $stray_report_id
 * @property int $barangay_id
 * @property int|null $reported_by_user_id
 * @property string $report_type
 * @property string $species
 * @property string|null $description
 * @property string|null $location_text
 * @property string|null $street_address
 * @property string|null $landmark
 * @property string|null $photo_path
 * @property string $urgency_level
 * @property string $report_status
 * @property \Illuminate\Support\Carbon $reported_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay $barangay
 * @property-read \App\Models\ImpoundRecord|null $impoundRecord
 * @property-read \App\Models\User|null $reporter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereLandmark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereLocationText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport wherePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereReportStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereReportType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereReportedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereReportedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereStrayReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereStreetAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereUrgencyLevel($value)
 * @mixin \Eloquent
 */
	class StrayReport extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $log_name
 * @property string|null $description
 * @property string|null $subject_type
 * @property int|null $subject_id
 * @property string|null $event
 * @property string|null $properties
 * @property int|null $causer_id
 * @property string|null $causer_type
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $module
 * @property string|null $action
 * @property string|null $status
 * @property int|null $record_id
 * @property string|null $ip_address
 * @property int|null $user_id
 * @property string|null $role
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog byAction($action)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog byModule($module)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog byStatus($status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog byUser($userId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog dateRange($startDate, $endDate)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereCauserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereCauserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereLogName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereUserId($value)
 * @mixin \Eloquent
 */
	class SystemLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $role
 * @property string $email
 * @property string|null $otp_code
 * @property \Illuminate\Support\Carbon|null $otp_expires_at
 * @property int $is_verified
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $status
 * @property int|null $organization_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Admin|null $adminProfile
 * @property-read Collection<int, AnnouncementRead> $announcementReads
 * @property-read int|null $announcement_reads_count
 * @property-read Collection<int, Announcement> $announcements
 * @property-read int|null $announcements_count
 * @property-read Barangay|null $barangay
 * @property-read Collection<int, BiteRabiesReport> $biteRabiesReportsApproved
 * @property-read int|null $bite_rabies_reports_approved_count
 * @property-read Collection<int, BiteRabiesReport> $biteRabiesReportsReported
 * @property-read int|null $bite_rabies_reports_reported_count
 * @property-read Collection<int, DeviceToken> $deviceTokens
 * @property-read int|null $device_tokens_count
 * @property-read Facility|null $facility
 * @property-read mixed $contact_number
 * @property-read mixed $first_name
 * @property-read mixed $last_name
 * @property-read mixed $middle_name
 * @property string $name
 * @property-read mixed $profile
 * @property-read Collection<int, Livestock> $livestockRecorded
 * @property-read int|null $livestock_recorded_count
 * @property-read Collection<int, Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Organization|null $organizationProfile
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read PetOwner|null $petOwner
 * @property-read PetOwner|null $petOwnerProfile
 * @property-read Collection<int, Pet> $pets
 * @property-read int|null $pets_count
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read Collection<int, SystemLog> $systemLogs
 * @property-read int|null $system_logs_count
 * @mixin HasRoles
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOtpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOtpExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\Authenticatable, \Illuminate\Contracts\Auth\Access\Authorizable {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole query()
 * @mixin \Eloquent
 */
	class UserRole extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $pet_id
 * @property int $vaccinated_by
 * @property string $vaccine_type
 * @property \Illuminate\Support\Carbon $vaccination_date
 * @property \Illuminate\Support\Carbon|null $next_vaccination_date
 * @property string|null $batch_number
 * @property \App\Models\User|null $veterinarian
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pet $pet
 * @property-read \App\Models\User|null $vaccinatedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereBatchNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereNextVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereVaccinatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereVaccineType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereVeterinarian($value)
 * @mixin \Eloquent
 */
	class Vaccination extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int|null $appointment_id
 * @property string $owner_first_name
 * @property string $owner_last_name
 * @property string $owner_email
 * @property string $owner_contact
 * @property string|null $alt_mobile_number
 * @property string $blk_lot_ph
 * @property string $street
 * @property string $barangay
 * @property \Illuminate\Support\Carbon $scheduled_at
 * @property \Illuminate\Support\Carbon|null $last_anti_rabies_date
 * @property bool $recent_surgery
 * @property string $status
 * @property array<array-key, mixed>|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $selected_pets
 * @property-read string $status_badge
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereAltMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereBlkLotPh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereLastAntiRabiesDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereRecentSurgery($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereUserId($value)
 * @mixin \Eloquent
 */
	class VaccinationReport extends \Eloquent {}
}

