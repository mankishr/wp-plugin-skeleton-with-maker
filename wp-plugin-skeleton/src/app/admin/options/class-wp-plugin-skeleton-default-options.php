<?php
/**
 * The default options of the plugin for settings page.
 *
 * @link       http://example.com
 * @since      2.0.0
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Admin/Options
 */

namespace Wp_Plugin_Skeleton\Admin\Options;

use Symfony\Component\OptionsResolver\Options;

/**
 * The default options of the plugin for settings page.
 *
 * Defines options for settings page. Define which option is required. Define allowed types for the option.
 * Define allowed values if there are values that user can select.
 * Inside allowedValues you can use closure function that returns true but in case of an error sets wp settings error (add_settings_error) that will be displayed in the options form.
 * If you return false when there is an error it will throw an exception with detailed explanation, but this should be used only on dev environments.
 * Inside info of the option set values for the input field [id, type, name, label, options (for select field), minlength ...].
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Admin/Options
 * @author     Anka Bajurin Stiskalov
 */
class Wp_Plugin_Skeleton_Default_Options extends Wp_Plugin_Skeleton_Options
{

    public function configureOptions(): void
    {
        $this->resolver->define('third_party_name')
            ->allowedTypes('string')
            ->info(wp_json_encode([
                'type' => 'text',
                'id' => 'third_party_name',
                'name' => 'third_party_name',
                'label' => 'Third party name',
            ]));

        $this->resolver->define('third_party_host')
            ->allowedTypes('string')
            ->info(wp_json_encode([
                'type' => 'text',
                'id' => 'third_party_host',
                'name' => 'third_party_host',
                'label' => 'Third party host',
            ]));

        $this->resolver->setNormalizer('third_party_host', function (Options $options, $value) {
            if ('http://' !== substr($value, 0, 7)) {
                $value = 'http://'.$value;
            }

            return $value;
        });

        $this->resolver->define('third_party_description')
            ->allowedTypes('string')
            ->info(wp_json_encode([
                'type' => 'wp_editor',
                'id' => 'third_party_description',
                'name' => 'third_party_description',
                'label' => 'Third party description',
            ]));

        $this->resolver->define('third_party_type')
            ->required()
            ->default('import')
            ->allowedTypes('string')
            ->allowedValues(static function ($value) {
                // Redirect error to wp settings error to be displayed in the form instead exception page.
                if( !in_array($value,['import', 'import_export'])){
                    add_settings_error(
                        'third_party_type',
                        esc_attr( 'settings_updated' ),
                        'Error! Allowed values are import and import_export.',
                        'error'
                    );
                }
                return true;
            })
            ->info(wp_json_encode([
                    'type' => 'select',
                    'name' => 'third_party_type',
                    'label' => 'API permissions',
                    'options' => ['import' => 'Only import', 'import_export' => 'Import and export']
                ]
            ));

        $this->resolver->define('third_party_active')
            ->default('unchecked')
            ->allowedTypes('string')
            ->info(wp_json_encode([
                    'type' => 'checkbox',
                    'id' => 'third_party_active',
                    'name' => 'third_party_active',
                    'label' => 'Activate third party import'
                ]
            ));
    }

    public static function wp_option_name(): string
    {
        return 'wp_plugin_skeleton_options';
    }

    public static function wp_options_group(): string
    {
        return 'wp_plugin_skeleton_fields';
    }

    public static function wp_options_section(): string
    {
        return 'wp_plugin_skeleton_general';
    }
}