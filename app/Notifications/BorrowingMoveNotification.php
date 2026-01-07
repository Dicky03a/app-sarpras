<?php

namespace App\Notifications;

use App\Models\BorrowingMove;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BorrowingMoveNotification extends Notification
{
    use Queueable;

    protected $borrowingMove;

    /**
     * Create a new notification instance.
     */
    public function __construct(BorrowingMove $borrowingMove)
    {
        $this->borrowingMove = $borrowingMove;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Using database notifications for now
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'borrowing_id' => $this->borrowingMove->borrowing_id,
            'old_asset_name' => $this->borrowingMove->oldAsset->name,
            'new_asset_name' => $this->borrowingMove->newAsset->name,
            'reason' => $this->borrowingMove->alasan_pemindahan,
            'admin_name' => $this->borrowingMove->admin->name ?? 'Admin',
            'message' => "Peminjaman Anda telah dipindahkan dari '{$this->borrowingMove->oldAsset->name}' ke '{$this->borrowingMove->newAsset->name}' oleh admin. Alasan: {$this->borrowingMove->alasan_pemindahan}",
        ];
    }
}
