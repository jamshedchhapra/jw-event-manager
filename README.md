# JW Event Manager

Custom WordPress plugin built for the WP Dev Audition task.

## Scaffolding
Plugin scaffolded using WP-CLI.

Custom CLI command:
`wp jwem seed-events`

## Overview
`JW Event Manager` provides event management with:
- Custom post type and taxonomy
- Event metadata (date, location, organizer, RSVP limit)
- Frontend archive and single templates
- RSVP system with capacity and duplicate checks
- Public REST endpoint
- Event listing shortcode
- WP-CLI seed command
- Localization-ready strings

## Features
- CPT: `jwem_event` with archive and single flow
- Taxonomy: `event_type`
- Shortcode: `[jwem_events]`
- RSVP shortcode: `[jwem_rsvp]` (used in single event template)
- REST API: `/wp-json/jwem/v1/events`
- Cache invalidation on event save/trash/delete/restore
- Nonce and sanitization in RSVP flow

## Installation
1. Copy plugin folder to `wp-content/plugins/jw-event-manager`
2. Activate **JW Event Manager** from WP Admin
3. Save permalinks once (`Settings > Permalinks`) after activation

## Usage
- Create events in WP Admin under **Events**
- Visit event archive at `/events/`
- Add `[jwem_events]` to any page to render event list

## REST API
Endpoint:
- `/wp-json/jwem/v1/events`

Returns:
- `id`
- `title`
- `link`
- `date`
- `location`
- `organizer`

If no events exist, returns an empty array:
- `[]`

## WP-CLI
Seed test events:

```bash
wp jwem seed-events
```

## Final QA Status
Validated scenarios:
1. REST endpoint returns structured array (or `[]` when empty)
2. Shortcode safety:
   - Renders event cards when events exist
   - Shows `No events found` when none exist
   - No fatal/white screen
3. RSVP capacity logic blocks beyond limit and prevents duplicates
4. Archive -> Single -> Back navigation works without JS blocking

## Localization
- Text domain: `jw-event-manager`
- Translation template file: `languages/jw-event-manager.pot`

## Notes
- Input data is sanitized and validated
- RSVP uses nonce verification
- Event-related transients are cleared on data changes
