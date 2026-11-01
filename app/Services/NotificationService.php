<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public static function create(User $user, string $title, string $message, ?string $module = null, ?int $recordId = null, string $priority = 'normal'): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'related_module' => $module,
            'related_record_id' => $recordId,
            'priority' => $priority,
        ]);
    }

    public static function notifyRole(string $role, string $title, string $message, ?string $module = null, ?int $recordId = null, string $priority = 'normal'): void
    {
        $users = User::where('role', $role)->get();
        
        foreach ($users as $user) {
            self::create($user, $title, $message, $module, $recordId, $priority);
        }
    }

    public static function notifyMultipleRoles(array $roles, string $title, string $message, ?string $module = null, ?int $recordId = null, string $priority = 'normal'): void
    {
        $users = User::whereIn('role', $roles)->get();
        
        foreach ($users as $user) {
            self::create($user, $title, $message, $module, $recordId, $priority);
        }
    }

    public static function notifyAboveLevel(int $level, string $title, string $message, ?string $module = null, ?int $recordId = null, string $priority = 'normal'): void
    {
        $users = User::whereRaw('(SELECT hierarchy_level FROM role_hierarchy WHERE role = users.role) >= ?', [$level])->get();
        
        foreach ($users as $user) {
            self::create($user, $title, $message, $module, $recordId, $priority);
        }
    }

    public static function userCreated(User $createdUser): void
    {
        $message = "New user created: {$createdUser->name} ({$createdUser->getRoleDisplayName()})";
        
        self::notifyMultipleRoles(
            [User::ROLE_SUPER_ADMIN, User::ROLE_CITY_VET],
            'New User Created',
            $message,
            'user_management',
            $createdUser->id,
            'normal'
        );
    }

    public static function biteReportCreated(?int $reportId = null): void
    {
        self::notifyMultipleRoles(
            [User::ROLE_CITY_VET, User::ROLE_ASSISTANT_VET, User::ROLE_ADMIN_ASST],
            'New Bite/Rabies Report',
            'A new bite/rabies report has been submitted and requires attention.',
            'bite_rabies_report',
            $reportId,
            'high'
        );
    }

    public static function strayReportCreated(?int $reportId = null): void
    {
        self::notifyMultipleRoles(
            [User::ROLE_CITY_VET, User::ROLE_ADMIN_ASST],
            'New Stray Animal Report',
            'A new stray animal report has been submitted.',
            'stray_report',
            $reportId,
            'normal'
        );
    }

    public static function petRegistrationCreated(?int $petId = null): void
    {
        self::notifyMultipleRoles(
            [User::ROLE_CITY_VET, User::ROLE_ADMIN_ASST, User::ROLE_ASSISTANT_VET],
            'New Pet Registration',
            'A new pet has been registered in the system.',
            'pet_registration',
            $petId,
            'normal'
        );
    }

    public static function spayNeuterCreated(?int $reportId = null): void
    {
        self::notifyMultipleRoles(
            [User::ROLE_CITY_VET, User::ROLE_ASSISTANT_VET],
            'New Spay/Neuter Request',
            'A new spay/neuter report has been submitted.',
            'spay_neuter',
            $reportId,
            'normal'
        );
    }

    public static function livestockCreated(?int $id = null): void
    {
        self::notifyMultipleRoles(
            [User::ROLE_CITY_VET, User::ROLE_ASSISTANT_VET],
            'New Livestock Record',
            'A new livestock census record has been added.',
            'livestock',
            $id,
            'normal'
        );
    }

    public static function meatInspectionCreated(?int $id = null): void
    {
        self::notifyMultipleRoles(
            [User::ROLE_CITY_VET, User::ROLE_MEAT_INSPECTOR],
            'New Meat Inspection',
            'A new meat inspection record has been created.',
            'meat_inspection',
            $id,
            'high'
        );
    }

    public static function inventoryLow(string $itemName, int $currentStock): void
    {
        self::notifyMultipleRoles(
            [User::ROLE_CITY_VET, User::ROLE_ASSISTANT_VET],
            'Low Inventory Alert',
            "Item '{$itemName}' is running low (Current stock: {$currentStock})",
            'inventory',
            null,
            'high'
        );
    }

    public static function inventoryExpiring(array $items): void
    {
        $count = count($items);
        $names = collect($items)->map(fn ($item) => "{$item->item_name} (expires {$item->expiry_date})")->implode(', ');

        self::notifyMultipleRoles(
            [User::ROLE_CITY_VET, User::ROLE_ASSISTANT_VET],
            'Inventory Expiry Alert',
            "{$count} item(s) expiring soon: {$names}",
            'inventory',
            null,
            'high'
        );
    }

    public static function impoundCreated(?int $impoundId = null): void
    {
        self::notifyMultipleRoles(
            [User::ROLE_CITY_VET, User::ROLE_ADMIN_ASST],
            'New Impound Record',
            'A new animal has been impounded.',
            'impound',
            $impoundId,
            'normal'
        );
    }

    public static function adoptionCreated(?int $adoptionId = null): void
    {
        self::notifyMultipleRoles(
            [User::ROLE_CITY_VET, User::ROLE_ADMIN_ASST],
            'New Adoption Request',
            'A new adoption request has been submitted.',
            'adoption',
            $adoptionId,
            'normal'
        );
    }

    public static function rabiesCaseCreated(?int $caseId = null): void
    {
        self::notifyMultipleRoles(
            [User::ROLE_CITY_VET, User::ROLE_ASSISTANT_VET],
            'New Rabies Case',
            'A new rabies case has been reported.',
            'rabies_case',
            $caseId,
            'high'
        );
    }

    public static function announcementCreated(int $announcementId): void
    {
        self::notifyMultipleRoles(
            [User::ROLE_SUPER_ADMIN, User::ROLE_CITY_VET, User::ROLE_ADMIN_ASST],
            'New Announcement',
            'A new announcement has been published.',
            'announcement',
            $announcementId,
            'normal'
        );
    }

    /**
     * Notify a client that their record's status changed.
     * Hard rule: never trigger if $oldStatus === $newStatus (idempotency guard).
     */
    public static function statusChanged(
        int $clientUserId,
        string $recordType,
        int $recordId,
        string $oldStatus,
        string $newStatus,
        ?string $reason = null
    ): ?Notification {
        if ($oldStatus === $newStatus) {
            return null;
        }

        $user = User::find($clientUserId);
        if (! $user) {
            return null;
        }

        $title = ucfirst($recordType) . ' Status Updated';
        $message = "Your {$recordType} #{$recordId} status changed from \"{$oldStatus}\" to \"{$newStatus}\".";
        if ($reason) {
            $message .= " Reason: {$reason}";
        }

        return self::create($user, $title, $message, $recordType, $recordId, 'normal');
    }

    /**
     * Notify all users assigned a given Spatie role.
     */
    public static function toRole(
        string $role,
        string $title,
        string $message,
        ?string $module = null,
        ?int $recordId = null,
        string $priority = 'normal'
    ): void {
        $users = User::role($role)->get();

        foreach ($users as $user) {
            self::create($user, $title, $message, $module, $recordId, $priority);
        }
    }
}