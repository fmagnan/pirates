<?php

namespace Ethmael\Utils;

class Config
{
       public static function loadConfigFile($path)
    {
        $yaml = new \Symfony\Component\Yaml\Parser();
        try {
            $config = $yaml->parse(file_get_contents($path));
        } catch (\Symfony\Component\Yaml\Exception\ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
            exit;
        }

        return $config;

    }
}