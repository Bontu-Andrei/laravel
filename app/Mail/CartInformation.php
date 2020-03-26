<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CartInformation extends Mailable
{
    use Queueable, SerializesModels;

    protected $productsInCart;
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($productsInCart, $data)
    {
        $this->productsInCart = $productsInCart;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.content-mail')->with([
            'data' => $this->data,
            'products' => $this->productsInCart
        ]);
    }
}
