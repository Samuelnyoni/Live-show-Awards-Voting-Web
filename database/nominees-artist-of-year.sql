-- Add the current Artist of the Year nominees.
-- Safe to run again: existing names in this category will not be duplicated.

INSERT INTO nominees (category_id, name, photo, display_order)
SELECT c.id, n.name, NULL, n.display_order
FROM categories AS c
JOIN (
    SELECT 'Zasper' AS name, 1 AS display_order
    UNION ALL SELECT 'Zaya 593', 2
    UNION ALL SELECT 'Kay Tee', 3
) AS n
WHERE c.slug = 'artist-of-year'
AND NOT EXISTS (
    SELECT 1
    FROM nominees AS existing
    WHERE existing.category_id = c.id
      AND existing.name = n.name
);
