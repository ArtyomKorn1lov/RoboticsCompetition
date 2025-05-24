<?php

namespace Robot\Core\Tools\Mail;

interface IHelper
{
    /**
     * @param array $arFields
     * @return void
     */
    public function sendMail(array $arFields): void;
}