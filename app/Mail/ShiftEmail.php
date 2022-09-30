<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShiftEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($output)
    {
        $this->output = $output;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $detailsShift = $this->output['detailShift'];
        return $this->subject('Assign Shift Roaster')->view('shift.email', compact('detailsShift'));
    }
}
