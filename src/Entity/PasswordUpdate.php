<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PasswordUpdate
{

    private ?string $oldPassword = null;

    #[Assert\NotEqualTo(propertyPath: 'oldPassword', message: 'You must choose another password than your current one')]
    #[Assert\Length(min: 6, minMessage: "You password must be at least 6 characters long")]
    private ?string $newPassword = null;

    #[Assert\EqualTo(propertyPath: 'newPassword', message: "The password must be identical")]
    private ?string $confirmPassword = null;

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
