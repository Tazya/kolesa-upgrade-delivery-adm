<?php

namespace App\Model\Validators;

class MessageValidator implements ValidatorInterface
{
    private const NOT_EMPTY_FIELDS = ['body' ];
    private const MAX_MESSAGE_LENGTH = 30;

    public function validate(array $data): array
    {
        $errors = $this->validateNotEmpty($data);

        if (!empty($errors)) {
            return $errors;
        }

        return array_merge(
            $this->validateLength($data),
        );
    }

    private function validateNotEmpty(array $data): array
    {
        $errors = [];

        foreach (self::NOT_EMPTY_FIELDS as $fieldName) {
            $value = $data[$fieldName] ?? null;

            if (empty($value)) {
                $errors[$fieldName] = 'Поле "' . $fieldName . '" не должно быть пустым';
            }
        }

        return $errors;
    }

    private function validateLength(array $data): array
    {
        $messageLength = mb_strlen($data['title']) + mb_strlen($data['body']);


        if ($messageLength > self::MAX_MESSAGE_LENGTH) {
            return [
                'messageLen' => 'Длина сообщения не может быть больше ' . self::MAX_MESSAGE_LENGTH . ' символов'
            ];
        }

        return [];
    }

}
