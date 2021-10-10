<?php
/**
 * Abstract class that can be extended and used for any settings page with options that plugin needs.
 *
 * @link       http://example.com
 * @since      2.0.0
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Admin/Options
 */

namespace Wp_Plugin_Skeleton\Admin\Options;


use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The abstract options class.
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Admin/Options
 * @author     Anka Bajurin Stiskalov
 */
abstract class Wp_Plugin_Skeleton_Options
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var OptionsResolver
     */
    protected $resolver;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->resolver = new OptionsResolver();
        $this->configureOptions();

        $this->options = $this->resolver->resolve($options);
    }

    abstract public function configureOptions(): void;

    abstract public static function wp_option_name(): string;

    abstract public static function wp_options_group(): string;

    abstract public static function wp_options_section(): string;

    /**
     * @return array
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function defined_options(): array
    {
        return $this->resolver->getDefinedOptions();
    }

    /**
     * @return array
     */
    public function required_options(): array
    {
        return $this->resolver->getRequiredOptions();
    }

    /**
     * @return array
     * @throws \JsonException
     */
    public function wp_html_input_fields(): array
    {
        $fields = [];

        foreach( $this->resolver->getDefinedOptions() as $option ){
            if($this->resolver->getInfo($option)){
                $fields[] = json_decode($this->resolver->getInfo($option), true, 512, JSON_THROW_ON_ERROR);
            }
        }

        return $fields;
    }
}