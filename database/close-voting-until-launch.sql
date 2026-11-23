-- Keep every award category closed while the website is being developed.
-- Voting can be opened later by changing is_open to 1 for selected categories.

UPDATE categories SET is_open = 0;
