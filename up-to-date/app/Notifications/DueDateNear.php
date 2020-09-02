<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DueDateNear extends Notification
{
    use Queueable;

    protected $user, $plan, $due_date;

    /**
     * Create a new notification instance.
     *
     * @return void
     */



    public function __construct($user, $category, $for, $due_date)
    {
        //
        $this->user=$user;
        $this->category=$category;
        $this->for=$for;
        $this->due_date=$due_date;
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
        return (new MailMessage)
                    ->subject('Due Date Near')
                    ->line('Hey,  '.$this->user)
                    ->line('Your due date for '.$this->category. ' namely ' . $this->for . ' is near. Less then 3 days remanining')
                    ->line('The Due date for '.$this->for .' '.$this->category. ' is '.$this->due_date)
                    ->line('Please complete your '.$this->category.' or reschedule')
                    ->action('Go to '.$this->category,url('/http://up-to-date.test/plans'))
                    ->line('Thank you!');
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
