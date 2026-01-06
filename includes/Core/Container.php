<?php
/**
 * Simple service container.
 *
 * @package DiviAI\Core
 * @since 1.0.0
 */

namespace DiviAI\Core;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Container class for dependency injection.
 */
class Container {

    /**
     * Registered services.
     *
     * @var array<string, callable>
     */
    private array $services = [];

    /**
     * Resolved instances.
     *
     * @var array<string, mixed>
     */
    private array $instances = [];

    /**
     * Register a service.
     *
     * @param string   $id      Service identifier.
     * @param callable $factory Factory function that creates the service.
     * @return void
     */
    public function register( string $id, callable $factory ): void {
        $this->services[ $id ] = $factory;
    }

    /**
     * Get a service instance.
     *
     * @param string $id Service identifier.
     * @return mixed
     * @throws \InvalidArgumentException If service not found.
     */
    public function get( string $id ) {
        if ( ! $this->has( $id ) ) {
            throw new \InvalidArgumentException(
                sprintf( 'Service "%s" not found in container.', $id )
            );
        }

        // Return cached instance if available.
        if ( isset( $this->instances[ $id ] ) ) {
            return $this->instances[ $id ];
        }

        // Create and cache the instance.
        $this->instances[ $id ] = ( $this->services[ $id ] )( $this );

        return $this->instances[ $id ];
    }

    /**
     * Check if a service is registered.
     *
     * @param string $id Service identifier.
     * @return bool
     */
    public function has( string $id ): bool {
        return isset( $this->services[ $id ] );
    }

    /**
     * Remove a service from the container.
     *
     * @param string $id Service identifier.
     * @return void
     */
    public function remove( string $id ): void {
        unset( $this->services[ $id ], $this->instances[ $id ] );
    }

    /**
     * Get all registered service identifiers.
     *
     * @return array<string>
     */
    public function keys(): array {
        return array_keys( $this->services );
    }
}
