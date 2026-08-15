# Pitchfork Lab Directory

A WordPress plugin for use with the Pitchfork theme to manage Research Lab entries and display them in a filterable directory block.

Requires at least: WP 7.0.4
Tested up to: 7.0.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

## Usage Requirements

- Install in the normal WordPress location for plugins, typically `/wp-content/plugins`.
- Activate alongside the Pitchfork theme.
- Advanced Custom Fields Pro is required for the block and field registrations.

## Features

- Research Lab custom post type for lab directory entries.
- Research Area taxonomy for desktop directory filtering.
- ACF fields for External URL, Recruiting Students, and Principal Investigator ASURITE ID.
- ACF-powered `Research Lab Directory` block grouped with Pitchfork blocks in the inserter.
- Server-rendered results with progressive client-side search and filtering.
- Responsive directory layout with featured images, summaries, badges, and a compact filter panel.

## Editing Model

Research Lab posts use the normal title, editor content, featured image, Research Areas taxonomy, and lab detail fields. The description editor is intentionally limited to Paragraph blocks so entries remain concise and suitable for directory display. Inline links remain available inside Paragraph content.

Research Lab entries do not have public single pages or Research Area archive pages in this release. The External URL field is the primary destination when a lab is rendered in the directory.

## Directory Block

The `acf/research-lab-directory` block queries published Research Lab posts alphabetically and renders all results server-side. A small plain JavaScript controller enhances the listing with search, desktop Research Area filtering, Recruiting Students filtering, reset behavior, live result counts, and no-results messaging.

## Development

This plugin does not currently require a build step. PHP, CSS, JavaScript, and block template files are edited directly.

## Release Notes

See [CHANGELOG.md](CHANGELOG.md) for release notes.
