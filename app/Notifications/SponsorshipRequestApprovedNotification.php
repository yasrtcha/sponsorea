<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SponsorshipRequest;

class SponsorshipRequestApprovedNotification extends Notification
{
    use Queueable;

    protected $sponsorshipRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(SponsorshipRequest $sponsorshipRequest)
    {
        $this->sponsorshipRequest = $sponsorshipRequest;
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
        // Tentukan notifier dan URL berdasarkan siapa yang melakukan approval
        if ($this->sponsorshipRequest->initiator === 'event') {
            // Event mengajukan, Company menyetujui
            $notifierName = $this->sponsorshipRequest->sponsorOffer->user->name;
            $action = 'menyetujui pengajuan Anda untuk';
            $url = route('event.requests');
        } else {
            // Company offering, Event menyetujui
            $notifierName = $this->sponsorshipRequest->event->user->name;
            $action = 'menyetujui penawaran Anda untuk';
            $url = route('company.requests');
        }

        return [
            'name' => $notifierName,
            'action' => $action,
            'message' => 'Selamat! Pengajuan Anda untuk "' . $this->sponsorshipRequest->sponsorOffer->title . '" telah disetujui.',
            'url' => $url,
        ];
    }
}
