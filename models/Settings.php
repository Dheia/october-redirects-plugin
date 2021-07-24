<?php 

namespace Synder\Redirects\Models;

use Model;
use Synder\Redirects\Behaviors\SettingsModel;


class Settings extends Model
{
    /**
     * Implement Controller Behaviours
     * 
     * @var array
     */
    public $implement = [
        SettingsModel::class
    ];
    
    /**
     * @var string
     */
    public $settingsCode = 'synder_redirects';
    
    /**
     * @var string
     */
    public $settingsFields = 'fields.yaml';
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
}
