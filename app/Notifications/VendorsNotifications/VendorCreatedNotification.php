<?php

namespace App\Notifications;

use App\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VendorCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $password;

    public $company;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(String $password, Company $company)
    {
        $this->password = $password;
        $this->company  = $company;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $greeting = sprintf('Dear Valued Vendor %s,', $notifiable->name);
        $username = sprintf('Username: %s', $notifiable->email);
        $password = sprintf('Password: %s', $this->password);
        $contents = sprintf('Your vendor user account has been created by %s on Ogéo platform.', $this->company->name);

        return (new MailMessage)
                    ->subject('Ogéo Vendor User Account Created.')
                    ->greeting($greeting)
                    ->salutation('Kind Regards,')
                    ->line($contents)
                    ->line($username)
                    ->line($password)
                    ->action('Login To Ogéo Platform', url('/vendors/login'))
                    ->line('Thank you for using Ogéo platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
