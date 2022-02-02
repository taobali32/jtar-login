<?php

namespace App\Model;

use HyperfExt\Auth\Contracts\AuthenticatableInterface;
use HyperfExt\Jwt\Contracts\JwtSubjectInterface;

/**
 * Class User
 * @package App\Model
 */
class UserModel extends Model implements AuthenticatableInterface,JwtSubjectInterface
{
    protected $guarded = [];

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    public function getJwtIdentifier()
    {
        // TODO: Implement getJwtIdentifier() method.

        return $this->getKey();
    }

    public function getJwtCustomClaims(): array
    {
        // TODO: Implement getJwtCustomClaims() method.
        return [];
    }

    public function getAuthIdentifierName(): string
    {
        return $this->getKey();
    }

    public function getAuthIdentifier(): string
    {
        return $this->getKey();
    }

    public function getAuthPassword(): ?string
    {
        return $this->attributes['password'];
        // TODO: Implement getAuthPassword() method.
    }

    public function getRememberToken(): ?string
    {
        // TODO: Implement getRememberToken() method.
    }

    public function setRememberToken(string $value)
    {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName(): ?string
    {
        // TODO: Implement getRememberTokenName() method.
        return  'remember_token';
    }
}
