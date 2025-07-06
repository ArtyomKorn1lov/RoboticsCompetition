<?php

namespace Robot\Core\Tools\Files;

use Bitrix\Main\Localization\Loc;
use CFile;

Loc::loadMessages(__FILE__);

class Helper implements IHelper
{
    protected const YOUTUBE_URL = 'youtube.com/watch?v=';

    protected const VK_URL = 'vkvideo.ru/video';

    protected const RUTUBE_URL = 'rutube.ru/video';

    /**
     * @param int $id
     * @return string|bool
     */
    public function getFilePath(int $id): string|bool
    {
        if (empty($id)) {
            return false;
        }
        $path = CFile::GetPath($id);
        if (empty($path)) {
            return false;
        }
        return $path;
    }

    /**
     * @param array $fileValues
     * @param int $index
     * @return string|bool
     */
    public function getFilePreviewByIndex(array $fileValues, int $index): string|bool
    {
        if (isset($fileValues["ID"]) && $index === 0) {
            return $fileValues["SRC"];
        }

        return $fileValues[$index]["SRC"] ?? false;
    }

    /**
     * @param string $url
     * @return string|bool
     */
    public function getEmbedVideo(string $url): string|bool
    {
        if (empty($url)) {
            return false;
        }
        
        switch (true) {
            case str_contains($url, self::YOUTUBE_URL):
                $url = $this->parseYoutubeEmbed($url);
                break;
            case str_contains($url, self::VK_URL):
                $url = $this->parseVKEmbed($url);
                break;
            case str_contains($url, self::RUTUBE_URL):
                $url = $this->parseRuTubeEmbed($url);
                break;
            default:
                break;
        }

        return $url;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function parseYoutubeEmbed(string $url): string
    {
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\s&]+)/i';
        preg_match($pattern, $url, $matches);
        return "https://www.youtube.com/embed/".$matches[1] ?? $url;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function parseVKEmbed(string $url): string
    {
        $pattern = '/video-(-?\d+)_(\d+)/i';
        preg_match($pattern, $url, $matches);
        return (!empty($matches[1]) && !empty($matches[2])) ? "https://vk.com/video_ext.php?oid="."-{$matches[1]}&id={$matches[2]}"."&hd=2" : $url;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function parseRuTubeEmbed(string $url): string
    {
        $pattern = '/(?:https?:\/\/)?(?:www\.)?rutube\.ru\/video\/([a-zA-Z0-9_-]+)\/?/i';
        preg_match($pattern, $url, $matches);
        return "https://rutube.ru/play/embed/".$matches[1] ?? $url;
    }
}