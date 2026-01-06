<?php
/**
 * AI Provider Interface.
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
 * Interface for AI providers.
 */
interface ProviderInterface {

    /**
     * Get provider name.
     *
     * @return string
     */
    public function get_name(): string;

    /**
     * Test the connection to the AI provider.
     *
     * @return array{success: bool, model?: string, error?: string}
     */
    public function test_connection(): array;

    /**
     * Generate text content.
     *
     * @param string $prompt  The prompt to send.
     * @param array  $options Generation options (model, temperature, max_tokens, etc.).
     * @return array{success: bool, content?: string, tokens_used?: int, error?: string}
     */
    public function generate_text( string $prompt, array $options = [] ): array;

    /**
     * Generate structured content (JSON).
     *
     * @param string $prompt       The prompt to send.
     * @param string $json_schema  Expected JSON schema.
     * @param array  $options      Generation options.
     * @return array{success: bool, data?: array, tokens_used?: int, error?: string}
     */
    public function generate_structured( string $prompt, string $json_schema, array $options = [] ): array;

    /**
     * Generate image (if supported).
     *
     * @param string $prompt  Image description.
     * @param array  $options Generation options (size, quality, style).
     * @return array{success: bool, url?: string, error?: string}
     */
    public function generate_image( string $prompt, array $options = [] ): array;

    /**
     * Check if the provider supports a feature.
     *
     * @param string $feature Feature name (text, image, structured, streaming).
     * @return bool
     */
    public function supports( string $feature ): bool;

    /**
     * Get available models.
     *
     * @return array<string, string> Model ID => Model name.
     */
    public function get_models(): array;

    /**
     * Get the current model.
     *
     * @return string
     */
    public function get_model(): string;

    /**
     * Set the model to use.
     *
     * @param string $model Model identifier.
     * @return void
     */
    public function set_model( string $model ): void;
}
