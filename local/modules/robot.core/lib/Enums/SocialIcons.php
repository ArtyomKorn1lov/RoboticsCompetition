<?php

namespace Robot\Core\Enums;

enum SocialIcons: string
{
    case Telegram = 'telegram';
    case WhatsApp = 'whatsapp';
    case Vk = 'vk';
    case Dzen = 'dzen';
    case Youtube = 'youtube';
    case OtherSocial = 'other_social';
    case TelegramFooter = 'telegram_footer';
    case WhatsAppFooter = 'whatsapp_footer';
    case VkFooter = 'vk_footer';
    case DzenFooter = 'dzen_footer';
    case YoutubeFooter = 'youtube_footer';
    case OtherSocialFooter = 'other_social_footer';

    /**
     * @return array[]
     */
    public static function getSelectDefaultList(): array
    {
        return [
            [
                "value" => null,
                "label" => "Не выбрано",
            ],
            [
                "value" => self::Telegram->value,
                "label" => "Telegram",
            ],
            [
                "value" => self::WhatsApp->value,
                "label" => "WhatsApp"
            ],
            [
                "value" => self::Vk->value,
                "label" => "Vk"
            ],
            [
                "value" => self::Dzen->value,
                "label" => "Dzen"
            ],
            [
                "value" => self::Youtube->value,
                "label" => "Youtube"
            ],
            [
                "value" => self::OtherSocial->value,
                "label" => "Другая социальная сеть"
            ]
        ];
    }

    /**
     * @return array[]
     */
    public static function getSelectFooterList(): array
    {
        return [
            [
                "value" => null,
                "label" => "Не выбрано",
            ],
            [
                "value" => self::TelegramFooter->value,
                "label" => "Telegram",
            ],
            [
                "value" => self::WhatsAppFooter->value,
                "label" => "WhatsApp"
            ],
            [
                "value" => self::VkFooter->value,
                "label" => "Vk"
            ],
            [
                "value" => self::DzenFooter->value,
                "label" => "Dzen"
            ],
            [
                "value" => self::YoutubeFooter->value,
                "label" => "Youtube"
            ],
            [
                "value" => self::OtherSocialFooter->value,
                "label" => "Другая социальная сеть"
            ]
        ];
    }
}
