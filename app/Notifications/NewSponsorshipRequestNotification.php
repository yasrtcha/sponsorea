<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SponsorshipRequest;

class NewSponsorshipRequestNotification extends Notification
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
        return [
            'name' => $this->sponsorshipRequest->event->user->name,
            'action' => 'mengajukan proposal untuk',
            'message' => 'Proposal baru masuk untuk penawaran "' . $this->sponsorshipRequest->sponsorOffer->title . '".',
            'url' => route('company.incoming_requests'),
        ];
    }
}
