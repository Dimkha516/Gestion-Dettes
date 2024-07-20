<?php

namespace Core;

class Validator
{
    private $errors = [];
    private $db;

    public function __construct()
    {
        $this->db = new SecurityDatabase();
    }

    public static function validate($username, $password)
    {
        if ($username === 'admin' && $password === 'password') {
            return ['role' => 'boutiquier'];
        } else if ($username === 'client' && $password === 'password') {
            return ['role' => 'client'];
        }
        return false;
    }


    public function validateAddClient($data, $rules)
    {
        foreach ($rules as $field => $rule) {
            $value = isset($data[$field]) ? $data[$field] : '';
            if ($rule == 'required' && empty($value)) {
                $this->errors[$field] = "Le champ $field est requis.";
            }
            if ($field == 'login' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->errors[$field] = "Le champ $field doit être un email valide.";
            }
            if ($field == 'telephone' && !preg_match('/^\d{9}$/', $value)) {
                $this->errors[$field] = "Le champ $field doit être un numéro de téléphone valide.";
            }
        }
        return empty($this->errors);
    }

    public function validateAddPaiement($data, $rules)
    {
        $totalRestant = $_SESSION['totalRestant'];

        foreach ($rules as $field => $rule) {
            $value = isset($data[$field]) ? $data[$field] : '';
    
            if ($rule == 'required' && empty($value)) {
                $this->errors[$field] = "Le champ $field est requis.";
            }
            
            if ($rule == 'positive_number' && (!is_numeric($value) || $value <= 0)) {
                $this->errors[$field] = "Le champ $field doit être un nombre positif supérieur à 0.";
            }
    
            if ($rule == 'max_amount' && is_numeric($value) && $value > $totalRestant) {
                $this->errors[$field] = "Le champ $field doit être inférieur ou égal à $totalRestant.";
            }
        }
    
        return empty($this->errors);

    }

    public function required($field, $data)
    {
        return isset($data[$field]) && !empty($data[$field]);
    }

    public function unique($field, $data, $table, $column)
    {
        $db = new SecurityDatabase();
        $query = $db->query("SELECT COUNT(*) FROM {$table} WHERE {$column} = ?", [$data[$field]]);
        return $query->fetchColumn() == 0;
    }
 
    public function image($field, $data)
    {
        if (!isset($_FILES[$field])) {
            return false;
        }

        $file = $_FILES[$field];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        return in_array($file['type'], $allowedTypes) && $file['size'] > 0;
    }


    public function errors()
    {
        return $this->errors;
    }
}


// public function validateAddClient($data, $rules) {
//     foreach ($rules as $field => $ruleSet) {
//         $rulesArray = explode('|', $ruleSet);

//         foreach ($rulesArray as $rule) { 
//             $ruleName = $rule;
//             $params = [];

//             if (strpos($rule, ':')) {
//                 list($ruleName, $paramString) = explode(':', $rule);
//                 $params = explode(',', $paramString);
//             }

//             if (!call_user_func([$this, $ruleName], $field, $data, ...$params)) {
//                 $this->errors[$field][] = "The {$field} field failed validation for {$ruleName}.";
//             }
//         }
//     }

//     return empty($this->errors);
// }


// Vend 08h:
// maquette prototype
// diagrammes
// fonctionnalités
// Générer reçu
// liste des dettes
// paiement dettes
// enregistrer paiement dette
// liste prod d'une dette
// PAGINER LES LISTES