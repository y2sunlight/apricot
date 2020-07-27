<?php
namespace Apricot;

use Apricot\Foundation\Singleton;
use Apricot\Foundation\Translation;

/**
 * Lang Class - Translation Wrapper
 *
 * @method static Translation getInstance() Gets the Translation instance.
 * @method static string getLangCode() Gets the language code(ISO 639-1).
 * @method static bool has(string $key) Checks if the given key is present.
 * @method static string get(string $key, array $params = []) Gets the message specified by the key.
 */
class Lang extends Singleton
{
    /**
     * Creates the Translation instance.
     *
     * @return Translation
     */
    protected static function createInstance()
    {
        $lang = env('APP_LANG','en');
        if (!empty($user_lang = self::getUserLang()))
        {
            $lang = $user_lang;
        }
        return new Translation($lang);
    }

    /**
     * Gets the user language.
     *
     * @return string language-code(ISO 639-1)
     * @link https://www.loc.gov/standards/iso639-2/php/English_list.php
     */
    protected static function getUserLang(): ?string
    {
        if (!array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER)) return null;
        $http_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

        // Gets user languages
        $user_langs = [];
        foreach($http_langs as $lang)
        {
            $lang = substr(preg_replace( '/;.*/', '', $lang ),0,2);
            if (!in_array($lang, $user_langs)) $user_langs[] = $lang;
        }

        // Gets asset languages
        $asset_langs = @glob(assets_dir('lang').'/*', GLOB_ONLYDIR);
        if (empty($asset_langs)) return null;
        $asset_langs = array_map(
            function ($lang_dir) {
                return basename($lang_dir);
            },
            $asset_langs
        );

        // Matches user and asset languages
        foreach($user_langs as $lang)
        {
            if (in_array($lang, $asset_langs))
            {
                return $lang;
            }
        }
        return null;
    }
}
