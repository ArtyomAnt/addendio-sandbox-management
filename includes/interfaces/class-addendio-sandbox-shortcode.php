<?php

/**
 * The interface for shortcode classes.
 *
 * @since      1.0.0
 * @package    Addendio_Sandbox_Management
 * @subpackage Addendio_Sandbox_Management/includes/interfaces
 * @author     Artsem Kashel <artem.kashel@gmail.com>
 */
abstract class Addendio_Sandbox_Management_Shortcode {

	/**
	 * Actual plugin shortcode.
	 */
	const SHORTCODE = self::SHORTCODE;

	/**
	 * @return string $html Shortcode HTML.
	 */
	public abstract function shortcode_html( $atts );
}