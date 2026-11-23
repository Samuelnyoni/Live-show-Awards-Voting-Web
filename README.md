# Live Show Awards Malawi — Voting Website

This repository contains the source code for the Live Show Awards Malawi website.

## Current stage

The first homepage draft is in `index.php`. It uses embedded CSS and a small JavaScript navigation toggle so the first design can be tested as one self-contained page.

## Planned project structure

- `index.php` — public homepage
- `assets/images/` — logo, banners and nominee photographs
- `includes/` — reusable PHP components
- `categories/` — manually created category pages
- `results/` — public voting results
- `config/` — database configuration

## Development notes

- Voting is intended to be free and does not require voter accounts.
- The system will apply a practical browser/IP-based voting limit. This is a deterrent, not a guarantee against duplicate voting.
- Public results are intended to update while voting is still open.
- Do not commit database passwords, API keys or other secrets to this public repository.

## Before launch

Replace the temporary partner label, add the approved logo and banner artwork, confirm sponsorship contact details, and connect the voting and results pages to the database.
