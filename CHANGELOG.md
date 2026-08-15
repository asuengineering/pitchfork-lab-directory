# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## Version 1.0.0

Initial stable release of the Pitchfork Lab Directory plugin.

- ADD: Register the Research Lab custom post type for lab directory entries.
- ADD: Register the Research Area taxonomy for lab filtering.
- ADD: Register ACF fields for External URL, Recruiting Students, and Principal Investigator ASURITE ID.
- ADD: Register the `acf/research-lab-directory` block for displaying a filterable lab directory.
- ADD: Render all directory results server-side and progressively enhance filtering with plain JavaScript.
- ADD: Include client-side search, desktop Research Area filtering, Recruiting Students filtering, reset behavior, live result counts, and no-results messaging.
- ADD: Support responsive directory layouts with featured images, placeholders, summaries, badges, and same-window External URL links.
- ADD: Restrict the Research Lab editor to Paragraph blocks while preserving inline link editing.
- ADD: Provide empty-editor guidance for new Research Lab descriptions.
- ADD: Ensure Research Lab featured image support when the active theme limits post thumbnail support by post type.
- ADD: Place the directory block in the Pitchfork Blocks inserter category, with a local fallback if that category is unavailable.
