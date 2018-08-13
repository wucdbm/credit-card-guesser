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

class CardType {

    /** @var string */
    protected $name;

    /** @var string */
    protected $code;

    /** @var string */
    protected $regex;

    public function __construct(string $name, string $code, string $regex) {
        $this->name = $name;
        $this->code = $code;
        $this->regex = $regex;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getCode(): string {
        return $this->code;
    }

    public function getRegex(): string {
        return $this->regex;
    }
}
