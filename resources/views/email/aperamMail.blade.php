<style>
    .button-link {
        display: flex;
        justify-content: center;
        align-items: center
    }
    .button-link a {
        margin-top:  15px;
        background-color: #2d3748;
        border-bottom: 8px solid #2d3748;
        border-left: 18px solid #2d3748;
        border-right: 18px solid #2d3748;
        border-top: 8px solid #2d3748;
        text-decoration: none;
        border-radius: 4px;
        color: #FFFFFF;
    }

</style>


@component('mail::message')

<h1>Olá {{ ucfirst($name) }},</h1>

<p>Recebemos uma solicitação para cadastrar uma nova senha associada a este e-mail.</p>

<p>Se você fez essa solicitação, por favor, clique no botão abaixo:</p>

<div class="button-link">
    <a href="https://aperam.vercel.app/nova-senha/{{ $token }}" target="_blank">Cadastrar Nova Senha</a>
</div>

@endcomponent



