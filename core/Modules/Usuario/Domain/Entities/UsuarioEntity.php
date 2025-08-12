<?php

namespace Core\Modules\Usuario\Domain\Entities;

class UsuarioEntity
{
    public ?int $id = null;
    public ?string $name= null;
    public ?string $lastName = null;
    public string $email;
    public string $password;

    /**
     * @param ?int $id
     * @param ?string $name
     * @param ?string $lastName
     * @param string $email
     * @param string $password
     */
    public function __construct(?int $id, ?string $name, ?string $lastName, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }
}
