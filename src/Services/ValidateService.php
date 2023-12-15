<?php

namespace App\Services;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validation;

class ValidateService
{
    public function __construct(private readonly array $data = [])
    {
    }

    public function validate(): bool
    {
        $validator = Validation::createValidator();

        $violations = $validator->validate($this->data, $this->rules());

        if (0 !== count($violations)) {
            $_SESSION['error_message'] = $violations[0]->getMessage();
            $_SESSION['user_name'] = $this->data['name'];
            $_SESSION['user_email'] = $this->data['email'];
            return false;
        }

        return true;
    }

    private function rules(): Collection
    {
        return new Collection(
            [
                'name' => [
                    new NotBlank(),
                    new Type('string', 'Напишите, пожалуйста, текстом.'),
                ],
                'email' => [
                    new NotBlank(),
                    new Email(),
                ],
                'password' => [
                    new NotBlank(),
                    new Length(['min' => 6]),
                ],
                'confirm_password' => [
                    new NotBlank(),
                    new EqualTo([
                        'value' => $this->data['password'],
                        'message' => 'Пароли не совпадают.',
                    ]),
                ],
                'create_submit' => [],
            ]
        );
    }
}
