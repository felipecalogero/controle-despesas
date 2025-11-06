<?php

namespace Core\Modules\Usuario\Domain\Entities;

class UsuarioEntity
{
    public ?int $id;
    public ?string $name;
    public ?string $lastName;
    public string $email;
    public ?string $password;
    public ?string $avatar;
    public ?string $providerName;
    public ?string $providerId;

    /**
     * @param ?int $id
     * @param ?string $name
     * @param ?string $lastName
     * @param string $email
     * @param ?string $password
     * @param ?string $avatar
     * @param ?string $providerName
     * @param ?string $providerId
     */
    public function __construct(?int $id, ?string $name, ?string $lastName, string $email, ?string $password, ?string $avatar, ?string $providerName, ?string $providerId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->avatar = $avatar;
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
