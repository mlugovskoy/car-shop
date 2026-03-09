<?php

use App\Services\DynamicForm\Handlers\TransportHandler;

return [
    'schemas' => [
        'contact' => [
            'id' => 'contact',
            'title' => 'Обратная связь',
            'handler' => TransportHandler::class,
            'steps' => [
                [
                    'id' => 'basic',
                    'title' => 'Основная информация',
                    'icon' => '01',
                    'fields' => [
                        [
                            'id' => 'client_type',
                            'type' => 'radio',
                            'label' => 'Тип клиента',
                            'validation' => ['required'],
                            'messages' => ['required' => 'Выберите тип клиента'],
                            'options' => [
                                ['value' => 'individual', 'label' => 'Физическое лицо'],
                                ['value' => 'company', 'label' => 'Юридическое лицо'],
                            ],
                        ],
                        [
                            'id' => 'full_name',
                            'type' => 'text',
                            'label' => 'ФИО',
                            'placeholder' => 'Иванов Иван Иванович',
                            'validation' => ['required', 'min:3'],
                            'messages' => ['required' => 'Введите ФИО'],
                            'condition' => ['field' => 'client_type', 'operator' => 'equals', 'value' => 'individual'],
                        ],
                        [
                            'id' => 'company_name',
                            'type' => 'text',
                            'label' => 'Название компании',
                            'placeholder' => 'ООО «Пример»',
                            'validation' => ['required', 'min:2'],
                            'condition' => ['field' => 'client_type', 'operator' => 'equals', 'value' => 'company'],
                        ]
                    ],
                ],
                [
                    'id' => 'legal',
                    'title' => 'Реквизиты',
                    'icon' => '02',
                    'fields' => [
                        [
                            'id' => 'inn',
                            'type' => 'text',
                            'label' => 'ИНН',
                            'placeholder' => '1234567890',
                            'validation' => ['required', 'digits_between:10,12'],
                            'messages' => ['digits_between' => 'ИНН — 10 или 12 цифр'],
                        ],
                        [
                            'id' => 'kpp',
                            'type' => 'text',
                            'label' => 'КПП',
                            'placeholder' => '123456789',
                            'validation' => ['nullable'],
                        ],
                        [
                            'id' => 'legal_address',
                            'type' => 'textarea',
                            'label' => 'Юридический адрес',
                            'placeholder' => 'г. Москва, ул. Примерная, д. 1',
                            'rows' => 3,
                            'validation' => ['required', 'min:10'],
                        ],
                        [
                            'id' => 'has_different_postal',
                            'type' => 'checkbox',
                            'label' => '',
                            'checkbox_label' => 'Почтовый адрес отличается от юридического',
                            'validation' => ['nullable'],
                        ],
                        [
                            'id' => 'postal_address',
                            'type' => 'textarea',
                            'label' => 'Почтовый адрес',
                            'placeholder' => 'г. Москва, ул. Примерная, д. 1',
                            'rows' => 3,
                            'validation' => ['required', 'min:10'],
                            'condition' => ['field' => 'has_different_postal', 'operator' => 'not_empty'],
                        ],
                    ],
                ],

                [
                    'id' => 'contact',
                    'title' => 'Контакт',
                    'icon' => '03',
                    'fields' => [
                        [
                            'id' => 'contact_name',
                            'type' => 'text',
                            'label' => 'Контактное лицо',
                            'placeholder' => 'Петров Пётр',
                            'validation' => ['required'],
                        ],
                        [
                            'id' => 'preferred_contact',
                            'type' => 'select',
                            'label' => 'Способ связи',
                            'validation' => ['required'],
                            'options' => [
                                ['value' => 'email', 'label' => 'Email'],
                                ['value' => 'phone', 'label' => 'Телефон'],
                                ['value' => 'telegram', 'label' => 'Telegram'],
                            ],
                        ],
                        [
                            'id' => 'telegram',
                            'type' => 'text',
                            'label' => 'Telegram',
                            'placeholder' => '@username',
                            'validation' => ['required'],
                            'condition' => [
                                'field' => 'preferred_contact',
                                'operator' => 'equals',
                                'value' => 'telegram'
                            ],
                        ],
                        [
                            'id' => 'agree',
                            'type' => 'checkbox',
                            'label' => '',
                            'checkbox_label' => 'Согласен на обработку персональных данных',
                            'validation' => ['accepted'],
                            'messages' => ['accepted' => 'Необходимо согласие'],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
