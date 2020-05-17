<?php


namespace Glas\Utils;

class Settings
{
    private $settingsPath;
    private static $obj = null;
    private $settings;

    private function __construct()
    {
        try {
            $this->settingsPath = $_SERVER['DOCUMENT_ROOT'].'/settings.ini';

            if (!file_exists($this->settingsPath)) {
                throw new \Exception("Не найден файл с настройками проекта");
            }

            $this->settings = parse_ini_file($this->settingsPath);
        }
        catch (\Exception $e) {
            exit ($e->getMessage());
        }
    }

    static function get(string $name) {
        if ($name == null) {
            return;
        }

        if (self::$obj == null) {
            self::$obj = new Settings();
        }

        try {
            if (array_key_exists($name, self::$obj->settings)) {
                return self::$obj->settings[$name];
            }
            throw new \Exception("Отсутствует запрашиваемая настройка с именем {$name} в файле настроек");
        }
        catch (\Exception $e) {
            exit ($e->getMessage());
        }
    }
}