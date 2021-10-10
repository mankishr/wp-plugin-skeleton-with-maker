<?php
/**
 * Service that registers settings page based on provided options.
 *
 * @link       http://example.com
 * @since      2.0.0
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Admin/Settings
 */

namespace Wp_Plugin_Skeleton\Admin\Settings;


use Wp_Plugin_Skeleton\Admin\Options\Wp_Plugin_Skeleton_Options;

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
class Wp_Plugin_Skeleton_Settings_Service
{
    /**
     * @param Wp_Plugin_Skeleton_Options $options
     */
    public function wp_plugin_skeleton_register_setting_page(Wp_Plugin_Skeleton_Options $options): void
    {
        register_setting( $options::wp_options_group(), $options::wp_option_name() );

        $this->wp_plugin_skeleton_settings( $options );
    }

    /**
     * Add settings fields for best buy plugin
     *
     * @param Wp_Plugin_Skeleton_Options  $options Option value retrieved from database.
     */
    private function wp_plugin_skeleton_settings( Wp_Plugin_Skeleton_Options $options ): void {

        add_settings_section(
            $options::wp_options_section(),
            false,
            function() {
                return false;
            },
            $options::wp_options_group()
        );

        foreach ( $options->wp_html_input_fields() as $field ) {

            $label = $field['label'] ?? '';

            add_settings_field(
                $field['name'],
                $label,
                function() use ( $field, $options ) {
                    echo wp_kses(
                        $this->render_option_field( $field, $options->options(), $options->wp_option_name() ),
                        [
                            'input'  => [
                                'type'  => [],
                                'name'  => [],
                                'id'    => [],
                                'value' => [],
                                'min'   => [],
                                'max'   => [],
                                'size'  => [],
                                'minlength' => [],
                                'required' => [],
                                'checked'   => []
                            ],
                            'select' => [
                                'name'  => [],
                                'id'    => [],
                                'value' => [],
                                'required' => []
                            ],
                            'option' => [
                                'name'     => [],
                                'id'       => [],
                                'value'    => [],
                                'selected' => [],
                            ],
                            'p'      => [
                                'br' => [],
                            ],
                            'textarea'      => [
                                'type'  => [],
                                'name'  => [],
                                'id'    => [],
                                'value' => [],
                                'required' => []
                            ],
                        ]
                    );
                },
                $options::wp_options_group(),
                $options::wp_options_section(),
                [
                    'label_for' => $field['name'],
                ]
            );
        }

    }

    /**
     * Render field HTML
     *
     * @param array  $attributes Field details.
     * @param array  $options Field options from database.
     * @param string $option_name Option name.
     * @return string Rendered HTML of the field.
     */
    private function render_option_field( array $attributes , array $options, string $option_name ): string {

        $attribute_name         = $attributes['name'] ?? '';
        $options_attribute_value = $options[$attributes['name']] ?? '';
        $id = $attributes['id'] ?? $attribute_name;
        $required = $attributes['required'] ?? '';
        $value = $attributes['value'] ?? '';
        $minlength = isset($attributes['minlength']) ? 'minlength = '.(int)$attributes['minlength'] : '';

        switch ( $attributes['type'] ) {
            case 'text':
                $rendered_input_field = sprintf('<input type="text" name="%s[%s]" id="%s" value="%s" %s %s>', $option_name, esc_attr( $attribute_name ), esc_attr( $id ), esc_attr( $options_attribute_value ), $minlength, $required);
                break;
            case 'checkbox':
                $is_checked = checked( 1, $options_attribute_value, false );
                $rendered_input_field = sprintf('<input type="checkbox" value="1" name="%s[%s]" id="%s" %s>', $option_name, esc_attr( $attribute_name ), esc_attr( $id ), $is_checked );
                break;
            case 'hidden':
                $rendered_input_field = sprintf('<input type="hidden" name="%s[%s]" id="%s" value="%s" %s %s>', $option_name, esc_attr( $attribute_name ), esc_attr( $id ), esc_attr( $value ), $minlength, $required);
                break;
            case 'select':
                $rendered_input_field = '';
                if ( ! empty( $attributes['options'] ) && \is_array( $attributes['options'] ) ) {
                    $options_markup = '';
                    foreach ( $attributes['options'] as $key => $option ) {
                        $options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $options_attribute_value, $key, false ), $option );
                    }
                    $rendered_input_field = sprintf( '<select name="%1$s" id="%1$s" %3%s>%2$s</select>', $option_name . '[' . esc_attr( $id ) . ']', $options_markup, $required );
                }
                break;

            case 'wp_editor':
                $editor_content = $options[$attributes['name']] ?? '';
                wp_editor(
                    $editor_content,
                    $attributes['name'],
                    [
                        'textarea_name' => 'wp_plugin_skeleton_options[' . $attributes['name'] . ']',
                        'media_buttons' => false,
                        'textarea_rows' => 12,
                        'teeny'         => true,
                    ]
                );
                $rendered_input_field = '';
                break;
            default :
                $rendered_input_field = '';
        }

        return $rendered_input_field;
    }
}