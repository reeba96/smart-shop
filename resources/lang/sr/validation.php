<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute mora biti prihvaćen.',
    'active_url'           => ':attribute nije važeći URL.',
    'after'                => ':attribute mora biti datum nakon :date.',
    'after_or_equal'       => ':attribute mora biti datum nakon ili jednak datumu :date.',
    'alpha'                => ':attribute može da sadrži samo slova.',
    'alpha_dash'           => ':attribute može da sadrži slova, brojeve, crte i donje crte.',
    'alpha_num'            => ':attribute može da sadrži samo slova i brojeve.',
    'array'                => ':attribute mora biti u nizu.',
    'before'               => ':attribute mora biti datum pre :date.',
    'before_or_equal'      => ':attribute mora biti datum pre ili jednak datumu :date.',
    'between'              => [
        'numeric' => ':attribute mora biti između :min i :max.',
        'file'    => ':attribute mora biti između :min i :max KB.',
        'string'  => ':attribute mora biti između :min i :max karaktera.',
        'array'   => ':attribute mora biti između :min i :max stavki.',
    ],
    'boolean'              => ':attribute polje mora biti tačno ili netačno.',
    'confirmed'            => ':attribute potvrda se ne podudara.',
    'date'                 => ':attribute nije validan datum.',
    'date_format'          => ':attribute ne podudara se sa formatom :format.',
    'different'            => ':attribute i :other se moraju razlikovati.',
    'digits'               => ':attribute moraju biti :digits brojke.',
    'digits_between'       => ':attribute mora biti u rasponu od :min do :max brojki.',
    'dimensions'           => ':attribute ima neodgovarajuće dimenzije slike.',
    'distinct'             => ':attribute polje ima dupliranu vrednost.',
    'email'                => ':attribute mora biti validna email adresa.',
    'exists'               => 'Odabran :attribute je nevažeći.',
    'file'                 => ':attribute mora biti datoteka.',
    'filled'               => ':attribute polje mora imati vrednost.',
    'gt'                   => [
        'numeric' => ':attribute mora biti veće od :value.',
        'file'    => ':attribute mora biti veće od :value KB.',
        'string'  => ':attribute mora biti više od :value karaktera.',
        'array'   => ':attribute mora da ima više od :value stavki.',
    ],
    'gte'                  => [
        'numeric' => ':attribute mora biti veće ili jednako od :value.',
        'file'    => ':attribute mora biti veće ili jednako od :value KB.',
        'string'  => ':attribute mora biti veće ili jednako od :value karaktera.',
        'array'   => ':attribute mora imati :value stavku ili više.',
    ],
    'image'                => ':attribute mora biti slika.',
    'in'                   => 'Izabran :attribute je nevažeći.',
    'in_array'             => ':attribute polje ne postoji u :other.',
    'integer'              => ':attribute mora biti integer.',
    'ip'                   => ':attribute mora biti validna IP adresa.',
    'ipv4'                 => ':attribute mora biti validna IPv4 adresa.',
    'ipv6'                 => ':attribute mora biti validna IPv6 adresa.',
    'json'                 => ':attribute mora biti validan JSON string.',
    'lt'                   => [
        'numeric' => ':attribute mora biti manje od :value.',
        'file'    => ':attribute mora biti manje od :value KB.',
        'string'  => ':attribute mora biti manje od :value karaktera.',
        'array'   => ':attribute mora da ima manje od :value stavki.',
    ],
    'lte'                  => [
        'numeric' => ':attribute mora biti manji ili jednak sa :value.',
        'file'    => ':attribute mora biti manji ili jednak sa :value KB.',
        'string'  => ':attribute mora biti manji ili jednak sa :value karaktera.',
        'array'   => ':attribute ne može da sadrži više od :value stavki.',
    ],
    'max'                  => [
        'numeric' => ':attribute ne može biti veći od :max.',
        'file'    => ':attribute ne može biti veći od :max KB.',
        'string'  => ':attribute ne može biti veći od :max karaktera.',
        'array'   => ':attribute ne može da sadrži više od :max stavki.',
    ],
    'mimes'                => ':attribute mora biti datoteka tipa: :values.',
    'mimetypes'            => ':attribute mora biti datoteka tipa: :values.',
    'min'                  => [
        'numeric' => ':attribute mora biti najmanje :min.',
        'file'    => ':attribute mora biti najmanje :min KB.',
        'string'  => ':attribute mora biti najmanje :min karaktera.',
        'array'   => ':attribute mora da sadrži najmanje :min stavki.',
    ],
    'not_in'               => 'Odabran atribut :attribute je nevažeći.',
    'not_regex'            => ':attribute format je nevažeči.',
    'numeric'              => ':attribute mora biti broj.',
    'present'              => ':attribute polje mora da postoji.',
    'regex'                => ':attribute format je nevažeći.',
    'required'             => ':attribute polje je obavezno.',
    'required_if'          => ':attribute polje se zahteva ako :other je :value.',
    'required_unless'      => ':attribute polje se zahteva osim ako :other je u :values.',
    'required_with'        => ':attribute polje se zahteva kada :values je prisutna.',
    'required_with_all'    => ':attribute polje se zahteva kada :values je prisutna.',
    'required_without'     => ':attribute polje se zahteva kada :values nije prisutna.',
    'required_without_all' => ':attribute polje se zahteva kada nijedna od :values nije prisutna.',
    'same'                 => ':attribute i :other se moraju podudarati.',
    'size'                 => [
        'numeric' => ':attribute mora biti :size.',
        'file'    => ':attribute mora biti :size KB.',
        'string'  => ':attribute mora biti :size karaktera.',
        'array'   => ':attribute mora sadržati :size stavki.',
    ],
    'string'               => ':attribute mora biti string.',
    'timezone'             => ':attribute mora biti u važećoj zoni.',
    'unique'               => ':attribute je zauzeto.',
    'uploaded'             => ':attribute otpremanje nije uspelo.',
    'url'                  => ':attribute format nije validan.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'Izaberite poruku',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];