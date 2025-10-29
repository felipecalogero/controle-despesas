<?php

namespace Core\Modules\Usuario\Domain\Entities;

class UsuarioEntity
{
    public ?int $id = null;
    public ?string $name= null;
    public ?string $lastName = null;
    public string $email;
    public ?string $password;
    public ?string $providerName;
    public ?string $providerId;

    /**
     * @param ?int $id
     * @param ?string $name
     * @param ?string $lastName
     * @param string $email
     * @param ?string $password
     * @param ?string $providerName
     * @param ?string $providerId
     */
    public function __construct(?int $id, ?string $name, ?string $lastName, string $email, ?string $password, ?string $providerName, ?string $providerId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->providerName = $providerName;
        $this->providerId = $providerId;
    }

    public function temSenha(): bool
    {
        return !empty($this->senha);
    }

    public function isOAuth(): bool
    {
        return !empty($this->provider);
    }
}
