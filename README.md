# JW Event Manager Plugin
Plugin scaffolded using WP-CLI.
Custom CLI command:
wp jwem seed-events

## Overview
Custom WordPress plugin developed using WP-CLI.

## Features
- Custom Post Type (Events)
- Event Type Taxonomy
- Meta Fields (Date, Location, Organizer)
- RSVP System (AJAX based)
- Email Notification System
- REST API Endpoint
- Search & Filtering (Frontend + Admin)
- CLI Command (Seed Events)
- Performance Caching (Transients API)
- Localization Ready

## Installation
1. Upload plugin to /wp-content/plugins/
2. Activate from WordPress admin

## Usage
- Add events from admin panel
- Use shortcode: [jwem_rsvp]
- Visit archive page: /events/

## REST API
/wp-json/jwem/v1/events

## WP-CLI
wp jwem seed-events

## Testing
Includes PHPUnit test for CPT

## Notes
- All inputs sanitized
- Nonce security implemented
- Optimized queries with caching