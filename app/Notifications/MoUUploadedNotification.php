<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SponsorshipRequest;
use App\Models\User;

class MoUUploadedNotification extends Notification
{
    use Queueable;

    protected $sponsorshipRequest;
    protected $uploader;

    /**
     * Create a new notification instance.
     */
    public function __construct(SponsorshipRequest $sponsorshipRequest, User $uploader)
    {
        $this->sponsorshipRequest = $sponsorshipRequest;
        $this->uploader = $uploader;
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
        $url = '';
        if ($notifiable->role === 'event') {
            $url = route('event.requests');
        } elseif ($notifiable->role === 'company') {
            $url = route('company.requests');
        }

        return [
            'name' => $this->uploader->name,
            'action' => 'mengunggah MoU',
            'message' => 'MoU telah diunggah untuk kerjasama "' . $this->sponsorshipRequest->event->title . '" dan "' . $this->sponsorshipRequest->sponsorOffer->title . '".',
            'url' => $url,
        ];
    }
}
