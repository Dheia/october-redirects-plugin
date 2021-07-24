<?php 

namespace Synder\Redirects\Behaviors;

use System\Behaviors\SettingsModel as BaseSettingsModel;


class SettingsModel extends BaseSettingsModel
{

    /**
     * Strip passed URI
     *
     * @param string $uri
     * @return string
     */
    protected function stripUri($uri)
    {
        if (strpos($uri, 'http') !== 0) {
            return $uri;
        }
        $host = str_replace('www.', '', parse_url(url('/'), \PHP_URL_HOST));
        $url = parse_url($uri);

        // Different Host means external redirect
        if (str_replace('www.', '', $url['host']) != $host) {
            return $uri;
        }

        // Return Path
        return $url['path'];
    }

    /**
     * @inheritDoc
     */
    public function setSettingsValue($key, $value)
    {
        if ($this->isKeyAllowed($key)) {
            return;
        }
        
        if ($key === 'custom_redirects' && is_array($value)) {
            foreach ($value AS &$data) {
                $data['source'] = $this->stripUri($data['source']);
                $data['destination'] = $this->stripUri($data['destination']);
            }
        }
        $this->fieldValues[$key] = $value;
    }
}
