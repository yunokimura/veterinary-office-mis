<?php

namespace App\Services;

use App\Exceptions\AppointmentSlotTakenException;
use App\Models\Appointment;
use App\Models\SpayNeuterReport;
use App\Models\VaccinationReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentBookingService
{
    public function checkAndBookKaponSlot(string $date, string $time, array $selectedPets): void
    {
        DB::transaction(function () use ($date, $time, $selectedPets) {
            $scheduledAt = Carbon::parse("{$date} {$time}");

            foreach ($selectedPets as $petId) {
                $existingKapon = SpayNeuterReport::where('pet_name', $petId)
                    ->whereDate('scheduled_at', $date)
                    ->whereIn('status', ['pending', 'scheduled'])
                    ->whereNotNull('scheduled_at')
                    ->lockForUpdate()
                    ->exists();

                if ($existingKapon) {
                    throw new AppointmentSlotTakenException(
                        'One of your pets already has a kapon appointment scheduled for this date. Please choose a different date or pet.'
                    );
                }
            }

            $hourStart = Carbon::parse($time);
            $hourEnd = $hourStart->copy()->addHour();

            $kaponsInHour = SpayNeuterReport::whereDate('scheduled_at', $date)
                ->whereTime('scheduled_at', '>=', $hourStart)
                ->whereTime('scheduled_at', '<', $hourEnd)
                ->whereIn('status', ['pending', 'scheduled'])
                ->whereNotNull('scheduled_at')
                ->lockForUpdate()
                ->count();

            if ($kaponsInHour >= 2) {
                throw new AppointmentSlotTakenException(
                    'This kapon appointment slot was just taken by another user. Please select a different time.'
                );
            }
        });
    }

    public function checkAndBookVaccinationSlot(string $date, string $time): void
    {
        DB::transaction(function () use ($date, $time) {
            $scheduledAt = Carbon::parse("{$date} {$time}");

            $existingVaccination = VaccinationReport::whereDate('scheduled_at', $date)
                ->whereTime('scheduled_at', '>=', $scheduledAt)
                ->whereTime('scheduled_at', '<', $scheduledAt->copy()->addHour())
                ->whereIn('status', ['pending', 'scheduled'])
                ->whereNotNull('scheduled_at')
                ->lockForUpdate()
                ->first();

            if ($existingVaccination) {
                throw new AppointmentSlotTakenException(
                    'This vaccination slot was just taken by another user. Please select a different time.'
                );
            }

            $hourStart = Carbon::parse($time);
            $hourEnd = $hourStart->copy()->addHour();

            $vaccinationsInHour = VaccinationReport::whereDate('scheduled_at', $date)
                ->whereTime('scheduled_at', '>=', $hourStart)
                ->whereTime('scheduled_at', '<', $hourEnd)
                ->whereIn('status', ['pending', 'scheduled'])
                ->whereNotNull('scheduled_at')
                ->lockForUpdate()
                ->count();

            if ($vaccinationsInHour >= 3) {
                throw new AppointmentSlotTakenException(
                    'This vaccination slot was just taken by another user. Please select a different time.'
                );
            }
        });
    }

    public function checkAndBookAdoptionSlot(string $date, string $time): void
    {
        DB::transaction(function () use ($date, $time) {
            $timeWithSeconds = $time.':00';

            $existingAppointment = Appointment::where('appointment_date', $date)
                ->where('appointment_time', $timeWithSeconds)
                ->where('service_type', 'adoption_interview')
                ->whereIn('status', ['pending', 'scheduled'])
                ->lockForUpdate()
                ->first();

            if ($existingAppointment) {
                throw new AppointmentSlotTakenException(
                    'This interview slot was just taken by another user. Please select a different time.'
                );
            }

            $hourStart = Carbon::parse($time);
            $hourEnd = $hourStart->copy()->addHour();

            $appointmentsInHour = Appointment::where('appointment_date', $date)
                ->whereTime('appointment_time', '>=', $hourStart)
                ->whereTime('appointment_time', '<', $hourEnd)
                ->where('service_type', 'adoption_interview')
                ->whereIn('status', ['pending', 'scheduled'])
                ->lockForUpdate()
                ->count();

            if ($appointmentsInHour >= 2) {
                throw new AppointmentSlotTakenException(
                    'This interview slot was just taken by another user. Please select a different time.'
                );
            }
        });
    }
}
