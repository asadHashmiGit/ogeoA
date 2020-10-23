<?php

namespace App\Notifications;

use App\PurchaseOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PurchaseOrderApprovalRequiredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $PurchaseOrder;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PurchaseOrder $PurchaseOrder)
    {
        $this->PurchaseOrder = $PurchaseOrder;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $greeting = sprintf('Hello %s,', $notifiable->name);

        return (new MailMessage)
                    ->subject('Purchase Order Required Approval.')
                    ->greeting($greeting)
                    ->salutation('Kind Regards,')
                    ->line('A pending purchase order requiring your approval.')
                    ->action('Take Action', url('/app/login'))
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
            'purchase_order_id' => $this->PurchaseOrder->id,
            'class_name' => 'PurchaseOrder',
            'notification_name' => 'Purchase Order Approved',
        ];
    }
}
