<?php

namespace App\Mail;

use App\Models\PerfilInvitacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitacionPerfilMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PerfilInvitacion $inv,
        public string $link
    ) {}

    public function build()
    {
        return $this->subject('Has sido invitado a un perfil en MedicApp')
            ->view('emails.invitacion_perfil');
        // Si quieres fijar el remitente:
        // ->from('no-reply@medicapp.test', 'MedicApp')
    }
}
