<?php
/**
 * AI Provider Factory.
 *
 * @package DiviAI\AI
 * @since 1.0.0
 */

namespace DiviAI\AI;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Factory for creating AI provider instances.
 */
class ProviderFactory {

    /**
     * Registered provider classes.
     *
     * @var array<string, string>
     */
    private static array $providers = [
        'openai'    => OpenAI::class,
        'anthropic' => Anthropic::class,
    ];

    /**
     * Create a provider instance.
     *
     * @param string      $provider Provider name.
     * @param string|null $api_key  Optional. API key (uses stored key if not provided).
     * @param string      $model    Optional. Model to use.
     * @return ProviderInterface
     * @throws \InvalidArgumentException If provider not found.
     */
    public function create( string $provider, ?string $api_key = null, string $model = '' ): ProviderInterface {
        if ( ! isset( self::$providers[ $provider ] ) ) {
            throw new \InvalidArgumentException(
                sprintf( 'AI provider "%s" not found.', $provider )
            );
        }

        $api_key = $api_key ?? divi_ai_get_api_key( $provider );

        if ( empty( $api_key ) ) {
            throw new \InvalidArgumentException(
                sprintf( 'API key not configured for provider "%s".', $provider )
            );
        }

        $class = self::$providers[ $provider ];

        return new $class( $api_key, $model );
    }

    /**
     * Create provider using default settings.
     *
     * @return ProviderInterface
     * @throws \InvalidArgumentException If no provider configured.
     */
    public function create_default(): ProviderInterface {
        $default_provider = divi_ai_get_setting( 'default_provider', 'openai' );

        try {
            $model = divi_ai_get_setting( "{$default_provider}_model", '' );
            return $this->create( $default_provider, null, $model );
        } catch ( \InvalidArgumentException $e ) {
            // Try fallback provider.
            $fallback = divi_ai_get_setting( 'fallback_provider', '' );

            if ( $fallback && $fallback !== $default_provider ) {
                $model = divi_ai_get_setting( "{$fallback}_model", '' );
                return $this->create( $fallback, null, $model );
            }

            throw $e;
        }
    }

    /**
     * Register a custom provider.
     *
     * @param string $name  Provider name.
     * @param string $class Provider class (must implement ProviderInterface).
     * @return void
     */
    public static function register( string $name, string $class ): void {
        if ( ! is_subclass_of( $class, ProviderInterface::class ) ) {
            throw new \InvalidArgumentException(
                sprintf( 'Provider class must implement %s.', ProviderInterface::class )
            );
        }

        self::$providers[ $name ] = $class;
    }

    /**
     * Get all registered providers.
     *
     * @return array<string, string>
     */
    public static function get_registered(): array {
        return self::$providers;
    }

    /**
     * Check if a provider is registered.
     *
     * @param string $name Provider name.
     * @return bool
     */
    public static function has( string $name ): bool {
        return isset( self::$providers[ $name ] );
    }

    /**
     * Test connection for a provider.
     *
     * @param string $provider Provider name.
     * @return array{success: bool, model?: string, error?: string}
     */
    public static function test_connection( string $provider ): array {
        try {
            $factory  = new self();
            $instance = $factory->create( $provider );
            return $instance->test_connection();
        } catch ( \Exception $e ) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }
}
