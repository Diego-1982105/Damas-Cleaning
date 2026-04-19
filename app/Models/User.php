<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'permissions', 'active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'permissions'       => 'array',
            'active'            => 'boolean',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function roleLabels(): array
    {
        return [
            'owner' => 'Owner (team & access)',
            'staff' => 'Staff (panel access)',
        ];
    }

    /**
     * Granular panel permissions available for staff users.
     * Owners always have all of these implicitly.
     *
     * @return array<string, string>
     */
    public static function permissionLabels(): array
    {
        return [
            'manage_clients'       => 'Clients — view & manage client records',
            'manage_invoices'      => 'Invoices — create, edit & send invoices',
            'manage_leads'         => 'Leads — view & respond to quote requests',
            'manage_services'      => 'Services & Pricing — edit the service catalog',
            'manage_site_sections' => 'Site Sections — toggle public page visibility',
        ];
    }

    public function roleLabel(): string
    {
        return self::roleLabels()[$this->role] ?? ($this->role ?? 'No access');
    }

    public function hasAdminPanelAccess(): bool
    {
        return ($this->active !== false) && in_array($this->role, ['owner', 'staff'], true);
    }

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Owners have every permission. Staff only have what was explicitly granted.
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isOwner()) {
            return true;
        }

        return in_array($permission, $this->permissions ?? [], true);
    }
}
