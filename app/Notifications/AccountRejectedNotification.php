<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class AccountRejectedNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, $reason)
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'name' => 'Admin',
            'action' => 'menolak akun Anda',
            'message' => 'Maaf, akun Anda ditolak. Alasan: ' . $this->reason,
            'url' => route('profile.edit'),
        ];
    }
}
