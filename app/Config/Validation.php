<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
// Rules
// --------------------------------------------------------------------

public $brg = [
    'nama' => [
        'rules' => 'required|min_length[5]',
    ],
    'hrg' => [
        'rules' => 'required|integer',
    ],
    'stok'=>[
        'rules' => 'required|integer',
    ],
];

public $brg_errors = [
    'nama' => [
        'required' =>'{field} Harus Diisi<br>',
        'min_length' => '{field} Minimal 5 Karakter<br>',
    ],
    'hrg' => [
        'required' => '{field} Harus Diisi<br>',
        'integer' => '{field} Harus Angka<br>'
    ],
    'stok'=>[
        'required' => '{field} Harus Diisi<br>',
        'integer' => '{field} Harus Angka<br>'
    ],
];
}
