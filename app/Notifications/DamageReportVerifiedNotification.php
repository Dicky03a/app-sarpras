<?php

namespace App\Notifications;

use App\Models\ReportDamage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DamageReportVerifiedNotification extends Notification
{
    use Queueable;

    protected $reportDamage;

    /**
     * Create a new notification instance.
     */
    public function __construct(ReportDamage $reportDamage)
    {
        $this->reportDamage = $reportDamage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Using database notifications
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'report_damage_id' => $this->reportDamage->id,
            'asset_name' => $this->reportDamage->asset->name,
            'condition' => $this->reportDamage->kondisi_setelah_verifikasi,
            'message' => $this->reportDamage->pesan_tindak_lanjut,
            'admin_name' => $this->reportDamage->admin->name ?? 'Admin',
            'status' => $this->reportDamage->status,
            'notification_type' => 'damage_report_verified',
            'title' => 'Laporan Kerusakan Diverifikasi',
            'description' => "Laporan kerusakan untuk aset {$this->reportDamage->asset->name} telah diverifikasi oleh admin.",
        ];
    }
}
