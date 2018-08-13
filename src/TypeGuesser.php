<?php

/*
 * This file is part of the wucdbm/credit-card-guesser package.
 *
 * Copyright (c) Martin Kirilov <martin@forci.com>
 *
 * Author Martin Kirilov <martin@forci.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wucdbm\CreditCardGuesser;

use Wucdbm\CreditCardGuesser\Exception\UnknownCardTypeException;

class TypeGuesser {

    private $config = [
//        'Laser' => [
//            'code' => '',
//            'regex' => '/^(6706|6771|6709)/', # betalabs
//        ],
//        'UnionPay' => [
//            'code' => '',
//            'regex' => '/^62/', # betalabs
//        ],
//        'Elo' => [
//            'code' => '',
//            'regex' => '/^(431274|438935|451416|457393|504175|627780|636297|636368|651653|401178|401179|\b(4576[31-32])|\b(6504[85-90])|\b(6504[91-94])|\b(6516[52-54])|\b(65500[0-3])|506699|\b(506[700-778])|\b(509[000-999])|\b(6500[31-33])|\b(6500[35-51])|\b(6504[20-05])|\b(6504[20-39])|\b(650[485-538])|\b(650[541-598])|\b(6507[00-18])|\b(6507[20-27])|\b(6509[01-20])|\b(6516[52-79])|\b(6550[00-19])|\b(6550[21-58])|509040|509074)/', # betalabs
//        ],
//        'Aura' => [
//            'code' => '',
//            'regex' => '/^5[50]/', # betalabs
//        ],
//        'Hipercard' => [
//            'code' => '',
//            'regex' => '/^(38|60[0-9])/', # betalabs
//        ],
        'VisaElectron' => [
            'code' => 'VI',
            'regex' => '/^4[026][17500][508][844][913][917]/', // betalabs
        ],
        'Visa' => [
            'code' => 'VI',
            'regex' => '/^4[0-9]{12}(?:[0-9]{3})/', // betalabs
//            'regex' => '/^4[0-9]{0,15}$/i', # mcred
        ],
        'Amex' => [
            'code' => 'AX',
            'regex' => '/^3[47][0-9]{13}/', // betalabs
//            'regex' => '/^3$|^3[47][0-9]{0,13}$/i', # mcred
        ],
        'MasterCard' => [
            'code' => 'CA',
            'regex' => '/^5[1-5][0-9]{14}/', // betalabs
//            'regex' => '/^5[1-5][0-9]{5,}|222[1-9][0-9]{3,}|22[3-9][0-9]{4,}|2[3-6][0-9]{5,}|27[01][0-9]{4,}|2720[0-9]{3,}$/i', # mcred
        ],
        'Maestro' => [
            'code' => 'CA', // This is MasterCard's code as Maestro is owned by MasterCard, no clue whether this would work anywhere
            'regex' => '/^(5(018|0[23]|[68])|6(39|7))/', // betalabs
        ],
        'Discover' => [
            'code' => 'DS',
            'regex' => '/^6(?:011|5[0-9]{2})[0-9]{12}/', // betalabs
//            'regex' => '/^6$|^6[05]$|^601[1]?$|^65[0-9][0-9]?$|^6(?:011|5[0-9]{2})[0-9]{0,12}$/i', # mcred
        ],
        'JCB' => [
            'code' => 'JB', // Could also be JC, according to the card-types.md list
//            'regex' => '/^35/', # betalabs
            'regex' => '/^(?:2131|1800|35[0-9]{3})[0-9]{3,}$/i', // mcred
        ],
        'DinersClub' => [
            'code' => 'DI',
//            'regex' => '/^(36|38|30[0-5])/', # betalabs
            'regex' => '/^3(?:0[0-5]|[68][0-9])[0-9]{4,}$/i', // mcred
        ]
    ];

    /**
     * @param string $number
     *
     * @return CardType
     *
     * @throws UnknownCardTypeException
     */
    public function guess(string $number): CardType {
        $number = preg_replace('/[^0-9]/', '', $number);

        foreach ($this->config as $name => ['code' => $code, 'regex' => $regex]) {
            if (preg_match($regex, $number)) {
                return new CardType($name, $code, $regex);
            }
        }

        throw new UnknownCardTypeException();
    }

    public function setCode(string $name, string $code) {
        $this->config[$name]['code'] = $code;
    }

    public function setRegex(string $name, string $regex) {
        $this->config[$name]['regex'] = $regex;
    }

    public function addCard(string $name, string $code, string $regex) {
        $this->config[$name] = [
            'code' => $code,
            'regex' => $regex
        ];
    }

    public function removeCard(string $name) {
        unset($this->config[$name]);
    }
}
