<?php

namespace Core;

abstract class AbstractController
{
    use Responser;

    public function validate($validateRules, $data)
    {
        $errors = [];

        foreach ($validateRules as $field => $rule) {
            $rules = explode('|', $rule);

            foreach ($rules as $singleRule) {
                $params = explode(':', $singleRule);
                $ruleName = array_shift($params);

                $isValid = $this->validateRule($field, $ruleName, $params, $data);

                if (!$isValid)
                    $errors[$field][] = "Validation failed for rule $ruleName";
            }
        }

        return [
            'isValid' => (count($errors) <= 0),
            'errors' => $errors
        ];
    }

    private function validateRule($field, $ruleName, $params, $data)
    {
        switch ($ruleName) {
            case 'required':
                return isset($data[$field]);

            case 'min':
                $minLength = (int) $params[0];
                return strlen($data[$field]) >= $minLength;

            case 'max':
                $maxLength = (int) $params[0];
                return strlen($data[$field]) <= $maxLength;

            case 'regex':
                $pattern = $params[0];
                return preg_match($pattern, $data[$field]);     

            case 'integer':
                return filter_var($data[$field], FILTER_VALIDATE_INT) !== false;

            case 'decimal':
                return filter_var($data[$field], FILTER_VALIDATE_FLOAT) !== false;

            case 'email':
                return filter_var($data[$field], FILTER_VALIDATE_EMAIL) !== false;

            default:
                return true;
        }
    }
}